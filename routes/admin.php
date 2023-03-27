<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\WidgetsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UsecasesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionsController;

require __DIR__ . '/admin_auth.php';

/*Installation Routes*/
Route::group(
    ['prefix' => 'install',  'middleware' => ['AdminTheme', 'RedirectIfInstalled']],
    function () {
        Route::get('/pre-installation', [InstallController::class, 'preInstallation'])->name('preinstall');
        Route::get('/verify', [InstallController::class, 'verifyPurchase'])->name('verifypurchase');
        Route::get('/verify/redirect', [InstallController::class, 'redirectPurchase'])->name('verify.redirect');
        Route::get('/verify/return', [InstallController::class, 'returnPurchase'])->name('verify.return');
        Route::get('/verify/cancel', [InstallController::class, 'cancelPurchase'])->name('verify.cancel');
        Route::get('/configuration', [InstallController::class, 'getConfiguration'])->name('installconfig.get');
        Route::post('/configuration', [InstallController::class, 'postConfiguration'])->name('installconfig.post');
        Route::get('/complete', [InstallController::class, 'complete'])->name('installcomplete');
    }
);


Route::group(
    ['prefix' => env('APP_ADMIN_PREFIX', 'admin'),  'middleware' => ['AdminTheme', 'auth', 'verified']],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.home')->can('manage dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->can('manage dashboard');
        Route::get('pages', [PageController::class, 'index'])->name('admin.pages')->can('manage page');
        Route::get('pages/create', [PageController::class, 'create'])->name('admin.pages.create')->can('create page');
        Route::post('pages/create', [PageController::class, 'store'])->name('admin.pages.store')->can('create page');
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('admin.pages.edit')->can('edit page');
        Route::post('pages/{page}/edit', [PageController::class, 'update'])->name('admin.pages.update')->can('edit page');
        Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('admin.pages.destroy')->can('delete page');


        Route::get('posts', [PostsController::class, 'index'])->name('admin.posts')->can('manage post');
        Route::get('posts/create', [PostsController::class, 'create'])->name('admin.posts.create')->can('create post');
        Route::post('posts/create', [PostsController::class, 'store'])->name('admin.posts.store')->can('create post');
        Route::get('posts/{post}/edit', [PostsController::class, 'edit'])->name('admin.posts.edit')->can('edit post');
        Route::post('posts/{post}/edit', [PostsController::class, 'update'])->name('admin.posts.update')->can('edit post');
        Route::delete('posts/{post}', [PostsController::class, 'destroy'])->name('admin.posts.destroy')->can('delete post');

        Route::get('tags', [TagsController::class, 'index'])->name('admin.tags')->can('manage tag');
        Route::post('tags/create', [TagsController::class, 'store'])->name('admin.tags.store')->can('create tag');
        Route::get('tags/{tag}/edit', [TagsController::class, 'edit'])->name('admin.tags.edit')->can('edit tag');
        Route::post('tags/{tag}/edit', [TagsController::class, 'update'])->name('admin.tags.update')->can('edit tag');
        Route::delete('tags/{tag}', [TagsController::class, 'destroy'])->name('admin.tags.destroy')->can('delete tag');

        Route::get('categories/{type?}', [CategoryController::class, 'index'])->name('admin.categories')->can('manage category');
        Route::post('categories/create', [CategoryController::class, 'store'])->name('admin.categories.store')->can('create category');
        Route::post('categories/{category}/edit', [CategoryController::class, 'update'])->name('admin.categories.update')->can('edit category');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit')->can('edit category');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy')->can('delete category');

        Route::get('roles/{role?}', [RolesController::class, 'index'])->name('admin.roles');
        Route::post('roles/create', [RolesController::class, 'store'])->name('admin.roles.store');
        Route::post('roles/{role}/update', [RolesController::class, 'update'])->name('admin.roles.update');
        Route::post('roles/edit', [RolesController::class, 'edit'])->name('admin.roles.edit');
        Route::delete('roles/{role}', [RolesController::class, 'destroy'])->name('admin.roles.destroy');
        Route::post('roles/unassign/action', [RolesController::class, 'roleAction'])->name('admin.role.action');
        Route::post('roles/users/get/{role}', [RolesController::class, 'getUsers'])->name('admin.role.getUsers');

        Route::get('users/{user?}', [UserController::class, 'index'])->name('admin.users')->can('manage users');
        Route::post('users/create', [UserController::class, 'store'])->name('admin.users.store')->can('create users');
        Route::post('users/update', [UserController::class, 'update'])->name('admin.users.update')->can('edit users');
        Route::post('users/edit', [UserController::class, 'edit'])->name('admin.users.edit')->can('edit users');
        Route::get('users/status/change/{id}/{status}', [UserController::class, 'statusChange'])->name('admin.users.status.change')->can('edit users');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy')->can('delete users');

        Route::get('permissions/{user?}', [PermissionsController::class, 'index'])->name('admin.permissions')->can('manage permissions');
        Route::post('permissions/create', [PermissionsController::class, 'store'])->name('admin.permissions.store')->can('manage permissions');
        Route::post('permissions/{user}/edit', [PermissionsController::class, 'update'])->name('admin.permissions.update')->can('manage permissions');
        Route::get('permissions/{user}/edit', [PermissionsController::class, 'update'])->name('admin.permissions.edit')->can('manage permissions');

        // Menu Manager
        Route::get('/menus/{menu?}', [MenuController::class, 'index'])->name('admin.menus')->can('manage menus');
        Route::post('/menu/create', [MenuController::class, 'store'])->name('admin.menus.create')->can('create menus');
        Route::post('/menus/{menu}/add-items', [MenuController::class, 'addItems'])->name('admin.menus.add-items')->can('edit menus');
        Route::post('/menus/{menu}/update', [MenuController::class, 'update'])->name('admin.menus.update')->can('edit menus');
        Route::delete('/menu/{menu}/delete', [MenuController::class, 'destroy'])->name('admin.menus.destroy')->can('delete menus');
        Route::delete('/menu/{menu}/{item}/delete', [MenuController::class, 'destroyItem'])->name('admin.menus.item.destroy')->can('delete menus');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings')->can('manage settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update')->can('manage settings');

        //profile
        Route::get('user/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('user/password', [ProfileController::class, 'password'])->name('admin.password');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile/2fa', [ProfileController::class, 'twofactorauth'])->name('admin.mfa');
        Route::post('profile/twofactor/update', [ProfileController::class, 'twofactorUpdate'])->name('admin.twofactor.update');
        Route::get('profile/twofactor/disable', [ProfileController::class, 'twofactorDisable'])->name('admin.twofactor.disable');

        // System tools
        Route::get('/rebuild', [SystemController::class, 'rebuild'])->name('system.rebuild')->can('application operations');
        Route::get('/optimize', [SystemController::class, 'optimize'])->name('system.optimize')->can('application operations');
        Route::get('/clear-cache', [SystemController::class, 'cache'])->name('system.cache')->can('application operations');
        Route::get('/clear-view-cache', [SystemController::class, 'view'])->name('system.view')->can('application operations');
        Route::get('/clear-route-cache', [SystemController::class, 'route'])->name('system.route')->can('application operations');
        Route::get('/sitemap', [SitemapController::class, 'generate'])->name('sitemap.generate')->can('application operations');

        //plans
        Route::get('/plans', [PlansController::class, 'index'])->name('admin.plans')->can('manage plans');
        Route::get('/plans/create', [PlansController::class, 'create'])->name('admin.plans.create')->can('create plans');
        Route::post('/plans/store', [PlansController::class, 'store'])->name('admin.plans.store')->can('create plans');
        Route::get('plans/{plan}/edit', [PlansController::class, 'edit'])->name('admin.plans.edit')->can('edit plans');
        Route::post('plans/{plan}/update', [PlansController::class, 'update'])->name('admin.plans.update')->can('edit plans');
        Route::delete('plans/{plan}', [PlansController::class, 'destroy'])->name('admin.plans.destroy')->can('delete plans');
        Route::get('plans/status/change/{id}/{status}', [PlansController::class, 'statusChange'])->name('admin.plans.status.change')->can('manage plans');
        Route::get('/newplan', [PlansController::class, 'createPlanSusbcription'])->name('admin.createPlanSusbcription')->can('manage plans');
        Route::get('plans/transactions', [PlansController::class, 'transactions'])->name('admin.transactions.list')->can('manage transactions');

        //Widgets Routes
        Route::resource('/widgets', WidgetsController::class, ['as' => 'admin', 'only' => ['index', 'store', 'update', 'destroy']]);
        Route::post('/widgets/sort', [WidgetsController::class, 'sort'])->name('admin.widgets.sort')->can('manage widgets');

        //usecases
        Route::get('/usecases', [UsecasesController::class, 'index'])->name('admin.usecases')->can('manage usecases');
        Route::get('/usecases/create', [UsecasesController::class, 'create'])->name('admin.usecases.create')->can('create usecases');
        Route::post('/usecases/store', [UsecasesController::class, 'store'])->name('admin.usecases.store')->can('create usecases');
        Route::get('usecases/{usecase}/edit', [UsecasesController::class, 'edit'])->name('admin.usecases.edit')->can('edit usecases');
        Route::post('usecases/{usecase}/update', [UsecasesController::class, 'update'])->name('admin.usecases.update')->can('edit usecases');
        Route::delete('usecases/{usecase}', [UsecasesController::class, 'destroy'])->name('admin.usecases.destroy')->can('delete usecases');
        Route::get('usecases/status/change/{id}/{status}', [UsecasesController::class, 'statusChange'])->name('admin.usecases.status.change')->can('edit usecases');
    }
);
