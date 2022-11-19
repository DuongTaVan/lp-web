<?php

/*
|--------------------------------------------------------------------------
| Web Routes for admin type
|--------------------------------------------------------------------------
|
 */

Route::group(['middleware' => 'is_login_portal', 'namespace' => 'Auth'], function () {
    // Login
    Route::get('login', 'LoginController@showForm')->name('login');
    Route::post('login', 'LoginController@login')->name('handle-login');

    // Reset password
    Route::group(['prefix' => 'password', 'as' => 'password-reset.'], function () {
        Route::get('/reset', 'ResetPasswordController@showLinkRequestForm')->name('show-link');
        Route::get('/reset/{token}', 'ResetPasswordController@showResetForm')->name('show-reset-form');
        Route::post('/mail', 'ResetPasswordController@sendResetLinkEmail')->name('send');
        Route::post('/reset', 'ResetPasswordController@resetPassword')->name('reset');
    });
});

Route::group(['middleware' => ['is_logout_portal']], function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('statistic', 'StatisticController@index')->name('statistic.index');
    Route::get('sale-detail', 'SaleController@index')->name('sale.index');
    Route::get('term-statistic', 'StatisticController@termStatistic')->name('term-statistic.index');
    Route::get('transfer-histories', 'TransferHistoryController@index')->name('transfer-histories');
    Route::get('transfer-histories/detail/{id}', 'TransferHistoryController@show')->name('transfer-histories')->name('show');
    Route::get('transfer-histories/count', 'TransferHistoryController@getCountTransfer');
    Route::put('transfer-histories', 'TransferHistoryController@registerTransfer')->name('transfer.update');
    Route::get('transfer-error', 'TransferHistoryController@getErrorLappi')->name('transfer.error-lappi');
    Route::post('transfer-histories/try-again', 'TransferHistoryController@tryAgainTransfer')->name('transfer.try-again');
    Route::put('transfer-histories/send-mail', 'TransferHistoryController@sendmailTransfer')->name('transfer.send-mail');
    Route::get('sales', 'SaleController@index')->name('sales');
    Route::get('categories/type/{id}', 'CategoryController@getListCategoryByType');

    Route::group(['prefix' => 'box-notification-trans-contents', 'as' => 'box-notification-trans-contents.'], function () {
        Route::get('/', 'BoxNotificationTransContentsController@index')->name('index');
        Route::post('/', 'BoxNotificationTransContentsController@store')->name('store');
        Route::get('/create', 'BoxNotificationTransContentsController@create')->name('create');
        Route::get('/{id}', 'BoxNotificationTransContentsController@show')->name('show');
    });
    Route::get('/change-password', 'Auth\ChangePasswordController@display')->name('change-password');
    Route::post('/post-change-password', 'Auth\ChangePasswordController@changePassword')->name('post-change-password');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('user.list');
        Route::get('{user_id}/detail', 'UserController@show')->name('user.detail');
    });

    Route::group(['prefix' => 'identity', 'as' => 'identity.'], function () {
        Route::get('detail/{id}', 'ImagePathController@getDetailIdentity');
        Route::get('count', 'ImagePathController@getCountIdentity');
        Route::get('identity-verification-image', 'ImagePathController@getIdentityVerificationImage')->name('identity-verification-image');
        Route::put('identity-verification-image/{image_path_id}', 'ImagePathController@approveIdentityVerificationImage')->name('approve-identity-verification-image');
        Route::put('read-connect-verification/{userId}', 'UserController@readConnectVerification')->name('read-connect-verification');
    });

    Route::group(['prefix' => 'business'], function () {
        Route::get('detail/{id}', 'ImagePathController@getDetailBusiness');
        Route::get('count', 'ImagePathController@getCountBusiness');
        Route::get('business-verification-image', 'ImagePathController@index')->name('business.business-verification-image');
        Route::put('business-verification-image/{id}', 'ImagePathController@approveBusinessVerificationImage')->name('business.approve-business-verification-image');
    });

    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
        Route::get('', 'CourseController@index')->name('index');
        Route::get('count', 'CourseController@countCourseNotApprove');
        Route::get('{courseId}', 'CourseController@show')->name('show');
        Route::post('approval/{courseId}', 'CourseController@approval')->name('approval');
    });
});
