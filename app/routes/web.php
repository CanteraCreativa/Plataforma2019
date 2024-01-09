<?php

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


Route::prefix('/admin')->group(function(){
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::name('admin.')->middleware(['auth','role:admin'])->group(function(){
        Route::get('/', function(){ return redirect()->route('admin.dashboard'); });
        Route::get('/reset-password', 'Auth\ResetPasswordController@showResetForm')->name('password-reset');
        Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('contact-messages', ContactMessagesController::class)->only(['index', 'update', 'show', 'destroy']);

        Route::resource('logos', LogosController::class);

        Route::get('/creatives/resend_verification/{id}', CreativeDatasController::class.'@resendVerificationEmail')->name('creatives.resend_verification');
        Route::resource('creatives', CreativeDatasController::class)->only(['index', 'update', 'show', 'destroy']);
        Route::get('creatives/activate/{id}', CreativeDatasController::class.'@activate')->name('creatives.activate');
        Route::post('announcements/{announcement}/pick-winners', PickAnnouncementWinnersController::class)->name('announcements.pick_winners');
        Route::resource('announcements', AnnouncementsController::class);
        Route::get('announcements/activate/{id}', AnnouncementsController::class.'@activate')->name('announcements.activate');
        Route::resource('site_content', SiteContentController::class);

        Route::get('submissions/export', SubmissionsController::class.'@export')->name('submissions.export');
        Route::put('submissions/{submission}/review', ReviewSubmissionController::class)->name('submissions.review');
        Route::resource('submissions', SubmissionsController::class);
        Route::get('submissions/activate/{id}', SubmissionsController::class.'@activate')->name('submissions.activate');

        Route::get('/users/export', UserController::class.'@export')->name('users.export');

        Route::get('/inscriptions/export', AnnouncementsController::class.'@exportInscriptions')->name('inscriptions.export');

        Route::get('/updater', UpdaterController::class.'@index');
        Route::post('/update', UpdaterController::class.'@update');

    });
});

Route::get('/email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

Route::get('/view_submission_image', 'SubmissionsController@download')->name('view_submission_image');

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

/*
Route::view('/', 'app', ['uri' => '/']);

// Vue routes wildcard
Route::get('/{vue_capture}', function ($vue_capture) {
    return view('app', ['uri' => $vue_capture]);
})->where('vue_capture', '[\/\w\.-]*');*/

Route::get('/{uri?}', 'FrontendRenderController@index')->where('uri', '[\/\w\.-]*');


