<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Tool;
use App\Models\Tag;
use App\Models\Category;
use App\Http\Requests\Admin\ToolRequest;

class ToolsController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $locales = Language::getLocales();
      $search = $request->get('q', false);

      $tools = Tool::query();
      if (!empty($search)) {
          $tools->search($search, null, true);
      }
      $tools = $tools->paginate();

      return view('tools.index', compact('locales', 'tools'));
    }

    /**
     *
     */

    public function edit(Request $request, Tool $tool)
    {
        $locales = Language::getLocales();
        $categories = Category::all();
        $tags = Tag::all();

        return view('tools.edit', compact('locales', 'tool', 'categories','tags'));
    }

    /**
     *
     */
    public function update(ToolRequest $request, Tool $tool)
    {
        $tool_update_array =
        [
          'slug' => $request->slug,
          'icon' => "",
        ];

        if ($request->file("icon")) {
            if ($image = fileUpload($request->file("icon"))) {
                $tool_update_array['icon'] = $image;
            }
        }

        $tool->update($tool_update_array);

        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($request->file("{$lang->locale}.og_image")) {
                if ($image = fileUpload($request->file("{$lang->locale}.og_image"))) {
                    $translation['og_image'] = $image;
                }
            } else {
                unset($translation[$lang->locale]['og_image']);
            }
            if ($translation[$lang->locale]['name']) {
                $tool->fill($translation);
            }
        }
        $tool->save();

        $tool->tags()->sync($request->tags);
        $tool->categories()->sync($request->categories);

        return redirect()->route('admin.tools')->withSuccess(__('admin.toolUpdated'));
    }



}
