<?php

use Illuminate\Http\Request;

Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//Route::get('/email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

Route::get('/after-verify', 'UserController@afterVerify');

Route::group([ 'namespace' => 'Auth', 'middleware' => 'api', 'prefix' => 'password' ], function() {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::group(['name' => 'api.', 'middleware' => 'logger'], function() {

    Route::post('/register', 'Auth\ApiAuthController@register')->name('register');
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login');

    Route::resource('contact-messages', ContactMessagesController::class)->only('store');

    Route::resource('announcements', AnnouncementsController::class)->only(['index', 'show']);

    Route::get('logos', LogosController::class.'@index');

    Route::get('site_content/{slug}', SiteContentController::class.'@show');

    Route::get('/skills', EnumsController::class.'@skills');
    Route::get('/guidelines', EnumsController::class.'@guidelines');
    Route::get('/interests', EnumsController::class.'@interests');
    Route::get('/countries', EnumsController::class.'@countries');
    Route::get('/careers', EnumsController::class.'@careers');
    Route::get('/study_levels', EnumsController::class.'@studyLevels');

    Route::get('/statistics', StatisticsController::class);

    Route::get('/questions', function() {
        return config('cantera.submission_questions');
    });

    Route::resource('creatives', CreativeDatasController::class)->only('show');

    Route::middleware('auth:api')->group(function() {

        Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

        Route::post('/profile-image', CreativeDatasController::class . '@updateProfileImage');

        Route::resource('creatives', CreativeDatasController::class)->only('update');

        Route::get('/is_verified', UserController::class . '@isVerified');

        Route::middleware('verified')->group(function() {
            Route::post('/creatives/background-image', CreativeDatasController::class . '@updateBackgroundImage');

            Route::post('/announcements/{announcement}/subscribe', AnnouncementsController::class.'@subscribe');

            Route::get('/submissions/{creativeData?}', SubmissionsController::class.'@index');
            Route::post('/submissions/{announcement}', SubmissionsController::class.'@store');
            Route::get('/submissions/{submission}', SubmissionsController::class.'@show');
            Route::delete('/submissions/{submission}', SubmissionsController::class.'@destroy');
        });
    });

    Route::middleware(['auth:api','logger'])->get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
});

