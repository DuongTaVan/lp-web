<?php

// For testing
//Route::get('/date/{date}', function ($date) {
//    if ($date === 'clear') {
//        Cache::forget('currentDate');
//
//        return 'Clear cache success';
//    }
//    if ($date === 'check') {
//        return 'Current date now: ' . now()->parse(Cache::get('currentDate') ?? now());
//    }
//    Cache::put('currentDate', $date, 1626152078);
//
//    try {
//        return 'Set datetime success to: ' . now()->parse(Cache::get('currentDate'));
//    } catch (\Exception $e) {
//        Cache::forget('currentDate');
//
//        return 'Fail';
//    }
//});
//
//if (Cache::has('currentDate')) {
//    try {
//        now()->setTestNow(Cache::get('currentDate'));
//    } catch (\Exception $e) {
//        Cache::forget('currentDate');
//    }
//}

/*
|--------------------------------------------------------------------------
| Web Routes for common type
|--------------------------------------------------------------------------
|
*/

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Batch
//Route::get('/command', function () {
//    return view('command');
//})->name('command');
Route::get('command', 'CommandController@command')->name('command');
Route::get('batch_01', 'CommandController@insertBoxNotification')->name('batch_01');
Route::get('batch_02', 'CommandController@sendEmail')->name('batch_02');
Route::get('batch_03', 'CommandController@captureCreditCard')->name('batch_03');
Route::get('batch_04', 'CommandController@changeCourseSchedule')->name('batch_04');
Route::get('batch_05', 'CommandController@updateExpiredPoint')->name('batch_05');
Route::get('batch_06', 'CommandController@insertRanking')->name('batch_06');
Route::get('batch_07', 'CommandController@insertSaleTotal')->name('batch_07');
Route::get('batch_08', 'CommandController@createStatistics')->name('batch_08');
Route::get('batch_09', 'CommandController@changeTeacherRank')->name('batch_09');
Route::get('remind-confirm', 'CommandController@remindConfirm')->name('remind_confirm');
Route::get('test-mail', 'CommandController@testMail')->name('test_mail');
Route::get('cancel-course-schedule', 'CommandController@cancelCourseSchedule')->name('cancel_course_schedule');
Route::get('send-mail-new-service', 'CommandController@sendMailNewService')->name('send_mail_new_service');
Route::get('payout-teacher', 'CommandController@payoutTeacher')->name('payout-teacher');
Route::get('payout-lappi', 'CommandController@payoutLappi')->name('payout-lappi');
Route::get('read-csv', 'CommandController@readCsv')->name('read_csv');
Route::group(['prefix' => 'home'], function ($router) {
//    Route::get('/', 'Client\HomeController@index')->name('home');
//    Route::get('/search', 'Client\HomeController@search')->name('search');
    Route::post('get-course-schedules-in-day', 'Client\Common\TopPageController@schedulesInDay')->name('schedules-in-day');
});

Route::get('test', 'CommandController@test');
