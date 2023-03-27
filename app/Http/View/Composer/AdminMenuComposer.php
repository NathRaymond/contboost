<?php

namespace App\Http\View\Composer;

use App\Helpers\Facads\Menu;
use App\Helpers\Classes\MenuItems;
use Illuminate\Support\Facades\Auth;

class AdminMenuComposer
{
    /**
     * Bind data to the view.
     *
     * @return collection
     */
    public function register()
    {
        $this->registerAdminMenu();
    }

    /**
     * Register Admin Menu for the AvoRed E commerce package.
     *
     * @return void
     */
    public function registerAdminMenu()
    {
        if (Auth::check()) {
            Menu::make(
                'dashboard',
                function (MenuItems $menu) {
                    $menu->label('admin.dashboard')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-dashboard')
                        ->route('admin.dashboard');
                }
            );

            // Pages Menu Items
            Menu::make(
                'pages',
                function (MenuItems $menu) {
                    $menu->label('admin.pages')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-write')
                        ->route('admin.pages');
                }
            );
            $pagesMenu = Menu::get('pages');
            $pagesMenu->subMenu(
                'add-page',
                function (MenuItems $menu) {
                    $menu->key('create')
                        ->label('admin.createPage')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.pages.create');
                }
            );
            $pagesMenu->subMenu(
                'manage-pages',
                function (MenuItems $menu) {
                    $menu->key('index')
                        ->label('admin.managePages')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.pages');
                }
            );

            // Blog Menu Items
            Menu::make(
                'posts',
                function (MenuItems $menu) {
                    $menu->label('admin.posts')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-pin')
                        ->route('admin.posts');
                }
            );
            $postsMenu = Menu::get('posts');
            $postsMenu->subMenu(
                'manage-posts',
                function (MenuItems $menu) {
                    $menu->key('create')
                        ->label('admin.allPosts')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.posts');
                }
            );
            $postsMenu->subMenu(
                'create-posts',
                function (MenuItems $menu) {
                    $menu->key('create')
                        ->label('admin.newPost')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.posts.create');
                }
            );
            $postsMenu->subMenu(
                'manage-categories',
                function (MenuItems $menu) {
                    $menu->key('categories-index')
                        ->label('admin.categories')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.categories', ['type'  => "post"]);
                }
            );

            $postsMenu->subMenu(
                'manage-tags',
                function (MenuItems $menu) {
                    $menu->key('tags-index')
                        ->label('admin.tags')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.tags');
                }
            );

            Menu::make(
                'users',
                function (MenuItems $menu) {
                    $menu->label('admin.users')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-users')
                        ->route('admin.users');
                }
            );

            $usersMenu = Menu::get('users');
            $usersMenu->subMenu(
                'manage-users',
                function (MenuItems $menu) {
                    $menu->key('create')
                        ->label('admin.manageUsers')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.users');
                }
            );
            $usersMenu->subMenu(
                'manage-roles',
                function (MenuItems $menu) {
                    $menu->key('create')
                        ->label('admin.roles')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.roles');
                }
            );
            Menu::make(
                'appearance',
                function (MenuItems $menu) {
                    $menu->label('common.appearance')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-brush-alt')
                        ->route('admin.menus');
                }
            );
            $appearanceMenu = Menu::get('appearance');
            $appearanceMenu->subMenu(
                'manage-menu',
                function (MenuItems $menu) {
                    $menu->key('menus')
                        ->label('common.menus')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.menus');
                }
            );
            $appearanceMenu->subMenu(
                'manage-widgets',
                function (MenuItems $menu) {
                    $menu->key('widgets')
                        ->label('widgets.widgets')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.widgets.index');
                }
            );
            $appearanceMenu->subMenu(
                'settings',
                function (MenuItems $menu) {
                    $menu->key('settings')
                        ->label('common.settings')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.settings');
                }
            );

            Menu::make(
                'plans',
                function (MenuItems $menu) {
                    $menu->label('admin.plans')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-invest-monitor')
                        ->route('admin.plans');
                }
            );
            $plansMenu = Menu::get('plans');
            $plansMenu->subMenu(
                'manage-plans',
                function (MenuItems $menu) {
                    $menu->key('plans-index')
                        ->label('admin.plans')
                        ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.plans');
                }
            );
            $plansMenu->subMenu(
                'manage-plans-create',
                function (MenuItems $menu) {
                    $menu->key('plans-create')
                    ->label('admin.createPlan')
                    ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.plans.create');
                }
            );
            Menu::make(
                'transactions',
                function (MenuItems $menu) {
                    $menu->label('admin.transactions')
                    ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-revenue')
                        ->route('admin.transactions.list');
                }
            );


            Menu::make(
                'usecases',
                function (MenuItems $menu) {
                    $menu->label('admin.usecases')
                    ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-grid-alt')
                        ->route('admin.usecases');
                }
            );
            $usecasesMenu = Menu::get('usecases');
            $usecasesMenu->subMenu(
                'manage-usecases',
                function (MenuItems $menu) {
                    $menu->key('usecases-index')
                    ->label('admin.usecases')
                    ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.usecases');
                }
            );
            $usecasesMenu->subMenu(
                'manage-usecases-create',
                function (MenuItems $menu) {
                    $menu->key('usecases-create')
                    ->label('admin.createUsecase')
                    ->type(MenuItems::ADMIN)
                        ->icon('nav-icon lni lni-chevron-right')
                        ->route('admin.usecases.create');
                }
            );


        }
    }
}
