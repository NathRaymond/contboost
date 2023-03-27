<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';

Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::prefix('connector')->group(function () {
            Route::patch('/', [UploadController::class, 'chunk'])->name('uploader.chunk');
            Route::post('/process', [UploadController::class, 'upload'])->name('uploader.upload');
            Route::delete('/process', [UploadController::class, 'delete'])->name('uploader.delete');
        });
    }
);

Route::group(
    ['middleware' => ['FrontTheme']],
    function () {
        Route::get('lang/{locale}', [LangController::class, 'changeLocale'])->name('switch.lang');

        Route::get('page/{slug}', [PageController::class, 'show'])->name('page.show');
        Route::get('/', [HomeController::class, 'index'])->name('front.index');
        //social
        Route::get('social/{provider}', [SocialController::class, 'redirect'])->name('social.login.redirect');
        Route::get('social/{provider}/callback', [SocialController::class, 'Callback'])->name('social.login.callback');
        Route::get('page/{slug}', [PageController::class, 'show'])->name('page.show');

        // Blog
        Route::get('post/{slug}', [BlogController::class, 'show'])->name('posts.show');
        Route::get('blog', [BlogController::class, 'index'])->name('blog.show');
        Route::get('category/{category}', [BlogController::class, 'category'])->name('blog.category');
        Route::get('tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');

        //contactus
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
    }
);


Route::group(
    ['middleware' => ['FrontTheme', 'auth', 'verified']],
    function () {
        Route::get('document/{document_id?}', [DocumentController::class, 'index'])->name('document.index');
        Route::post('get-usecase-fields', [DocumentController::class, 'getFields'])->name('document.getFields');
        Route::post('store-document/{document?}', [DocumentController::class, 'storeDocument'])->name('document.storeDocument');
        Route::get('favourite-action/{document}', [DocumentController::class, 'favouriteAction'])->name('document.favouriteAction');
        Route::post('update-document/{document?}', [DocumentController::class, 'updateDocument'])->name('document.updateDocument');
        Route::get('download-document/{document}', [DocumentController::class, 'downloadDocument'])->name('document.downloadDocument');
        Route::get('delete-document/{document}', [DocumentController::class, 'deleteDocument'])->name('document.deleteDocument');
        Route::post('store-document-ajax/{document?}', [DocumentController::class, 'storeDocumentAjax'])->name('document.storeDocumentAjax');

        //plans
        Route::get('plans', [PlansController::class, 'plans'])->name('plans.list');
        Route::get('cancel-subscription', [UserController::class, 'cancleSubscription'])->name('plans.cancel.subscription');

        // payments
        Route::get('payments/checkout/{plan_id}/{type}', [PaymentsController::class, 'checkout'])->name('payments.checkout');
        Route::post('payments/process', [PaymentsController::class, 'process'])->name('payments.process');
        Route::get('payments/success/{transaction_id}', [PaymentsController::class, 'success'])->name('payments.success');
        Route::get('payments/cancel/{transaction_id}', [PaymentsController::class, 'cancel'])->name('payments.cancel');
        Route::get('payments/finish', [PaymentsController::class, 'finish'])->name('payments.finish');
        Route::post('gateway/view', [PaymentsController::class, 'getGatewayView'])->name('payments.gateway-view');

        //transactions
        Route::get('user/transactions', [PaymentsController::class, 'transactions'])->name('payments.transactions');
        Route::get('transaction/invoice/{transaction}', [PaymentsController::class, 'invoice'])->name('transaction.invoice');
        Route::get('transaction/invoice/download/{transaction}', [PaymentsController::class, 'invoiceDownload'])->name('transaction.invoice.download');
        Route::get('payments/webhook', [PaymentsController::class, 'webhookListener'])->name('payments.webhook-listener');

        //users profile
        Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::get('user/password', [UserController::class, 'password'])->name('user.password');
        Route::get('user/delete-user-account', [UserController::class, 'delete'])->name('user.deleteAccount');
        Route::get('user/plan', [UserController::class, 'plan'])->name('user.plan');
        Route::delete('user/delete-user-account', [UserController::class, 'destroy'])->name('user.deleteAccount.action');
        Route::get('user/twofactorauth', [UserController::class, 'twofactorauth'])->name('user.twofactor');
        Route::post('user/profile/update', [UserController::class, 'profileUpdate'])->name('user.profile.update');
        Route::post('user/password/update', [UserController::class, 'passwordUpdate'])->name('user.password.update');
        Route::post('user/twofactor/update', [UserController::class, 'twofactorUpdate'])->name('user.twofactor.update');
        Route::get('user/twofactor/disable', [UserController::class, 'twofactorDisable'])->name('user.twofactor.disable');
        Route::post('authenticate', [UserController::class, 'authenticate'])->name('user.authenticate');
    }
);
