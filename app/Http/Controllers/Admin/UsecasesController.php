<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Tool;
use App\Models\Usecase;
use App\Models\Language;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\PlanProperty;
use Illuminate\Http\Request;
use App\Helpers\Facads\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Http\Requests\Admin\UsecaseRequest;

class UsecasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locales = Language::getLocales();
        $search = $request->get('q', false);

        $usecases = Usecase::with('translations')
            ->when(!empty($search), function ($query) use ($search) {
                $query->search($search, null, true);
            })
            ->paginate();

        return view('usecases.index', compact('locales', 'usecases'));
    }

    public function create(Request $request)
    {
        $locales = Language::getLocales();

        return view('usecases.create', compact('locales'));
    }

    public function store(UsecaseRequest $request)
    {
        $fields = [];
        if (!empty($request->field_type)) {
            foreach ($request->field_type as $key => $types) {
                $id = "id_key_{$key}";
                $fields[] = [
                    'id' => $id, 'type' => $types, 'label' => $request->label[$key],
                    'placeholder' => $request->placeholder[$key], 'required' => $request->required[$key],
                    'short_code' => $request->short_code[$key]
                ];
            }
        }

        $usecaseArry = [
            'color' => $request->color,
            'order' => $request->order,
            'icon_class' => $request->icon_class,
            'icon_type' => $request->icon_type,
            'fields' => $fields,
            'command' => $request->command,
        ];
        $usecase = Usecase::create($usecaseArry);

        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($translation[$lang->locale]['name']) {
                $usecase->fill($translation);
            }
        }
        $usecase->save();

        // attach media
        if ($request->hasFile("icon")) {
            $usecase->clearMediaCollection("usecase-icon");
            $usecase->addMediaFromRequest("icon")->toMediaCollection('usecase-icon');
        }

        return redirect()->route('admin.usecases')->withSuccess(__('admin.usecaseCreated'));
    }


    public function edit(Request $request, Usecase $usecase)
    {
        $locales = Language::getLocales();

        return view('usecases.edit', compact('locales', 'usecase'));
    }

    /**
     *
     */
    public function update(UsecaseRequest $request, Usecase $usecase)
    {
        $fields = [];
        if (!empty($request->field_type)) {
            foreach ($request->field_type as $key => $types) {
                $id = "id_key_{$key}";
                $fields[] = [
                    'id' => $id, 'type' => $types, 'label' => $request->label[$key],
                    'placeholder' => $request->placeholder[$key], 'required' => $request->required[$key],
                    'short_code' => $request->short_code[$key]
                ];
            }
        }

        $usecaseArry = [
            'color' => $request->color,
            'order' => $request->order,
            'icon_class' => $request->icon_class,
            'icon_type' => $request->icon_type,
            'fields' => $fields,
            'command' => $request->command,
        ];
        $usecase->update($usecaseArry);
        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($translation[$lang->locale]['name']) {
                $usecase->fill($translation);
            }
        }
        $usecase->save();

        // attach media
        if ($request->hasFile("icon")) {
            $usecase->clearMediaCollection("usecase-icon");
            $usecase->addMediaFromRequest("icon")->toMediaCollection('usecase-icon');
        }

        return redirect()->route('admin.usecases')->withSuccess(__('admin.usecaseUpdated'));
    }

    public function statusChange($id, $status)
    {
        $usecase = Usecase::find($id);
        $usecase->update(['status' => $status]);

        return redirect()->route('admin.usecases')->withSuccess(__('admin.usecaseUpdated'));
    }

    public function destroy(Usecase $usecase)
    {
        $usecase->delete();

        return redirect()->back()->withSuccess(__('admin.usecaseDeleted'));
    }
}
