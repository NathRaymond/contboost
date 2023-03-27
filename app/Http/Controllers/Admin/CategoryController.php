<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $locales = Language::getLocales();
        $search = $request->get('q', false);

        $categories = Category::withCount('posts')
            ->parents()
            ->with(['children' => function ($query)  use ($type) {
                $query->where('type', $type);
            }])->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->when(!empty($search), function ($query) use ($search) {
                $query->search($search, null, true);
            })
            ->paginate();

        $parents = Category::active()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->parents()
            ->get();

        return view('categories.index', compact('locales', 'categories', 'parents', 'type'));
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create(
            [
                'status' => $request->input('status', true),
                'parent' => $request->parent,
                'type' => $request->input('type', "Post")
            ]
        );

        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);
            if ($translation[$lang->locale]['name']) {
                $category->fill($translation);
            }
        }
        $category->save();

        return redirect()
            ->back()
            ->withSuccess(__('admin.cateogryCreated'));
    }

    public function edit(Request $request, Category $category)
    {
        $type = $category->type;
        $locales = Language::getLocales();
        $categories = Category::withCount('posts')
            ->parents()
            ->with(['children' => function ($query)  use ($type) {
                $query->where('type', $type);
            }])->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->paginate();

        $parents = Category::active()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->parents()
            ->get();


        return view('categories.index', compact('locales', 'parents', 'categories', 'category'));
    }

    /**
     *
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'status' => $request->input('status', false),
            'parent' => $request->parent,
            'type' => "Post"
        ]);

        $langs = Language::getLocales();
        foreach ($langs as $lang) {
            $translation = $request->only($lang->locale);

            if ($translation[$lang->locale]['name']) {
                $category->fill($translation);
            }
        }
        $category->save();

        return redirect()->route('admin.categories')->withSuccess(__('admin.categoryUpdated'));
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->withSuccess(__('admin.categoryDeleted'));
    }
}
