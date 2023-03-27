<?php

namespace App\Helpers\Classes;

use App\Models\Tag;
use App\Models\Page;
use App\Models\Post;
use App\Models\Usecase;
use App\Models\Category;
use App\Helpers\Facads\MenuBuilder;
use App\Helpers\Classes\Menu\MenuContainer;
use App\Helpers\Classes\Menu\RegisterMenuItem;

class BuilderMenu
{
    public function __construct()
    {
        $this->registerBuilderItems();
    }

    protected function customPages()
    {
        $pages = collect([]);
        $pages->push((object)[
            'id' => 'pricing',
            'title' => __('admin.pricing'),
            'target' => '_self',
            'type' => 'route',
            'params' => [],
            'route' => 'plans.list',
        ]);
        $pages->push((object)[
            'id' => 'home',
            'title' => __('admin.home'),
            'target' => '_self',
            'type' => 'route',
            'params' => [],
            'route' => 'front.index',
        ]);
        $pages->push((object)[
            'id' => 'blog',
            'title' => __('admin.blog'),
            'target' => '_self',
            'type' => 'route',
            'params' => [],
            'route' => 'blog.show',
        ]);

        return $pages;
    }

    protected function registerBuilderItems()
    {
        // Usecases
        MenuBuilder::register(
            'usecases',
            function (MenuContainer $menu) {
                $menu->name(trans('admin.usecases'))
                ->key('usecases-menu');
            },
            20
        );
        $usecases = MenuBuilder::get('usecases');
        Usecase::with('translations')->active()->get()->each(function ($case) use ($usecases) {
            $usecases->item("usecasee-item-{$case->id}", function (RegisterMenuItem $menu) use ($case) {
                $case->translateOrDefault();
                $menu->label($case->name ?? __('common.noTitle'))
                ->key("usecasee-{$case->id}")
                ->target('_self')
                ->type('route')
                ->params([
                    'usecase' => $case->id
                ])
                    ->route('document.index');
            });
        });

        // Pages
        MenuBuilder::register(
            'pages',
            function (MenuContainer $menu) {
                $menu->name(trans('admin.pages'))
                    ->key('pages-menu');
            },
            10
        );
        $pages = MenuBuilder::get('pages');
        Page::with('translations')->get()->each(function ($page) use ($pages) {
            $pages->item("page-{$page->id}", function (RegisterMenuItem $menu) use ($page) {
                $menu->label($page->title)
                    ->key("page-{$page->id}")
                    ->target('_self')
                    ->type('route')
                    ->params([
                        'model' => 'Page',
                        'id' => $page->id
                    ])
                    ->route('pages.show');
            });
        });
        $this->customPages()->each(function ($page) use ($pages) {
            $pages->item("page-{$page->id}", function (RegisterMenuItem $menu) use ($page) {
                $menu->label($page->title)
                    ->key("page-{$page->id}")
                    ->target($page->target)
                    ->type($page->type)
                    ->route($page->route);
            });
        });

        // posts
        MenuBuilder::register(
            'posts',
            function (MenuContainer $menu) {
                $menu->name(trans('admin.posts'))
                    ->key('posts-menu');
            },
            30
        );
        $posts = MenuBuilder::get('posts');
        Post::with('translations')->get()->each(function ($post) use ($posts) {
            $posts->item("post-{$post->id}", function (RegisterMenuItem $menu) use ($post) {
                $menu->label($post->title)
                    ->key("post-{$post->id}")
                    ->target('_self')
                    ->type('route')
                    ->params([
                        'model' => 'Post',
                        'id' => $post->id
                    ])
                    ->route('posts.show');
            });
        });

        // categories
        MenuBuilder::register(
            'categories',
            function (MenuContainer $menu) {
                $menu->name(trans('admin.categories'))
                    ->key('categories-menu');
            },
            40
        );
        $categories = MenuBuilder::get('categories');
        Category::with('translations')->get()->each(function ($category) use ($categories) {
            $categories->item("page-{$category->id}", function (RegisterMenuItem $menu) use ($category) {
                $category->translateOrDefault();
                $menu->label($category->name ?? __('common.noTitle'))
                    ->key("category-{$category->id}")
                    ->target('_self')
                    ->type('route')
                    ->params([
                        'model' => 'Category',
                        'id' => $category->id
                    ])
                    ->route('blog.category');
            });
        });

        MenuBuilder::register(
            'tags',
            function (MenuContainer $menu) {
                $menu->name(trans('admin.tags'))
                ->key('tags-menu');
            },
            50
        );
        $tags = MenuBuilder::get('tags');
        Tag::with('translations')->get()->each(function ($tag) use ($tags) {
            $tags->item("tag-{$tag->id}", function (RegisterMenuItem $menu) use ($tag) {
                $menu->label($tag->name)
                ->key("tag-{$tag->id}")
                ->target('_self')
                ->type('route')
                ->params([
                    'model' => 'Tag',
                    'id' => $tag->id
                ])
                    ->route('blog.tag');
            });
        });
    }
}
