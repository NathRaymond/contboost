<?php

namespace App\Http\Controllers;

use App\Models\Usecase;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Components\Drivers\OpenAi;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $document_id = null,)
    {
        $usecases = Usecase::active()
            ->withTranslation()
            ->when(Auth::user()->hasActiveSubscription(), function ($query) {
                $authorized = Auth::user()->getActiveSubscription()->plan->usecases->pluck('id');
                $query->whereIn('id', $authorized);
            })
            ->get();

        $langs = openai_languages();
        $tones = get_tones();
        $variants = get_variants();
        $creativities = get_writing_styles();
        $search = $request->get('q', null);

        $documents = Document::query()
            ->when(!empty($search), function ($query) use ($search) {
                $query->search($search,);
            })
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->paginate(10);

        $selected_document = null;
        if ($document_id != null) {
            $selected_document = Document::query()
                ->with(['requests' => function ($query) {
                    $query->latest();
                }])
                ->where('id', $document_id)
                ->first();

            if ($selected_document->user_id != Auth::user()->id) {
                return redirect()->back();
            }
        }

        $selected_usecase = null;
        if (isset($request->usecase)) {
            $selected_usecase = Usecase::find($request->usecase);
        }

        return view('document.index', compact('selected_usecase', 'usecases', 'langs', 'tones', 'variants', 'creativities', 'documents', 'selected_document'));
    }

    public function getFields(Request $request)
    {
        $usecase = Usecase::findOrFail($request->id);
        $view = view('document.fields', compact('usecase'))->render();

        return response()->json(['view' => $view]);
    }

    public function storeDocument(Request $request, Document $document = null)
    {
        if (empty(config('artisan.openai_api_key'))) {
            return redirect()->back()->withError(__('admin.emptyAiKey'));
        }

        $usecase = Usecase::withTranslation()->withCount('usageToday')->findOrFail($request->usecase_id);

        $validate = $this->checkPropertyValidity($usecase);

        if (!$validate['status']) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'data' => null, 'message' => $validate['message']]);
            }
            return redirect()->back()->withErrors($validate['message']);
        }

        $promptResponse = $this->getPrompt($request->usecase_id, $request);
        if ($promptResponse['status'] == false) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'data' => null, 'message' => $promptResponse['message']]);
            }
            return redirect()->back()->withErrors($promptResponse['message']);
        }

        $prompt = $promptResponse['prompt'];
        $result = new OpenAi();
        $response = $result->parse($prompt);

        if (!$response['success'] || $prompt == null) {
            $errMessage = $response['success'] ?? '';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'data' => null, 'message' => $errMessage]);
            }

            return redirect()->back()->withErrors($errMessage);
        }

        $usecase->createVisitLog(auth()->user());

        if (!$document) {
            $documentArray = [
                'user_id' => auth()->id(),
                'name' => "Untitle Document",
            ];

            $document = Document::create($documentArray);
        }
        info($response['text']);
        $requestArray = [
            'document_id' => $document->id,
            'result' => $response['text'] ?? "",
            'tokens' => $response['usage']['total_tokens'] ?? 0,
            'no_of_words' => str_word_count($response['text'] ?? ''),
        ];

        $document->no_of_words = $document->no_of_words + str_word_count($response['text'] ?? '');
        $document->tokens = $document->tokens + ($response['usage']['total_tokens'] ?? 0);
        $document->update();
        DocumentRequest::create($requestArray);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $response['text'] ?? "", 'message' => "successfull"]);
        }

        return redirect()->route('document.index', ['document_id' => $document->id]);
    }

    private function getPrompt($usecase_id, $request)
    {
        $return_arry = [];
        $usecase = Usecase::where('id', $usecase_id)->first();
        $prompt = $usecase->command;
        if (!empty($request->tone)) {
            $prompt .= ". Your reply must be in [tone] tone";
        }

        if (!empty($request->style)) {
            $prompt .= ". Your writting style should be [style]";
        }

        if ($usecase->fields != null) {
            foreach ($usecase->fields as $field) {
                if ($field->short_code != null) {
                    $value = $field->id;
                    $required = $field->required;
                    if ($required == 1 && $request->values[$value] == null) {
                        $return_arry = ['message' => __('document.requiredError', ['name' => $field->label]), 'status' => false];

                        return $return_arry;
                    }
                    $prompt = str_replace($field->short_code, html_entity_decode($request->values[$value], ENT_QUOTES), $prompt);
                }
            }
        }

        $prompt = str_replace("[language]", $request->language, $prompt);
        $prompt = str_replace("[tone]", $request->tone, $prompt);
        $prompt = str_replace("[variant]", $request->variant, $prompt);
        $prompt = str_replace("[style]", $request->style, $prompt);

        $return_arry = ['status' => true, 'prompt' => $prompt];

        return $return_arry;
    }

    public function checkPropertyValidity($usecase)
    {
        $checkUserSubscription = Auth::user()->hasActiveSubscription();
        $userPlan = Auth::user()->getActiveSubscription()->plan ?? null;
        $usageCountLimit = $checkUserSubscription ? $userPlan->usecase_daily_limit : setting('usecase_daily_limit', '100');
        $wordCountLimit = $checkUserSubscription ? $userPlan->no_of_words : setting('no_of_words', '100');

        if ($usageCountLimit  <= $usecase->usage_today_count) {
            return ['status' => false, 'message' => __('document.limitExceed')];
        }

        if (Auth::user()->documentWords() >= $wordCountLimit) {
            return ['status' => false, 'message' => __('document.limitExceedWords')];
        }

        return ['status' => true, 'message' => ''];
    }

    public function checkUsage($usecase)
    {
        $usageCountLimit = Auth::user()->hasActiveSubscription() ? Auth::user()->getActiveSubscription()->plan->usecase_daily_limit : setting('usecase_daily_limit', '100');

        if ($usageCountLimit  <= $usecase->usage_today_count) {
            return false;
        }

        return true;
    }

    public function favouriteAction(Document $document)
    {
        $document->is_favourite = ($document->is_favourite == 1) ? 0 : 1;
        $document->update();
        return redirect()->back()->withSucccess(__('document.favouriteActionDone'));
    }

    public function updateDocument(Request $request, Document $document = null)
    {
        $document->name = $request->name;
        $document->update();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => __('document.documentUpdated')]);
        }

        return redirect()->back()->withSucccess(__('document.documentUpdated'));
    }

    public function downloadDocument(Document $document)
    {
        $content = '';

        foreach ($document->requests as $request) {
            $content .= wpautop($request->result) . "<br>&mdash;<br>";
        }

        $headers = array(
            "Content-type" => "text/html",
            "Content-Disposition" => "attachment;Filename={$document->name}.doc"
        );

        return response('<html><body>' . $content . '</body></html>', 200, $headers);
    }

    public function deleteDocument(Document $document = null)
    {
        $document->delete();

        return redirect()->back()->withSucccess(__('document.documentDeleted'));
    }
}
