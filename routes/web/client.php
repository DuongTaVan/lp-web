<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes for user type
|--------------------------------------------------------------------------
|
 */

Route::group(['middleware' => 'is_login_client', 'namespace' => 'Auth'], function () {
    // Login
    Route::get('login', 'LoginController@showForm')->name('login');
    Route::post('login', 'LoginController@login')->name('handle-login');
    Route::post('logout', 'LoginController@logout')->name('handle-logout');
    // Socialite auth
    Route::get('auth/{service}/redirect', 'SocialiteController@getUrlRedirect')->name('auth.url-redirect');
    Route::get('auth/{service}', 'SocialiteController@handleCallBack')->name('auth.callback');

    //Register
    Route::get('register', 'RegisterController@showForm')->name('register');
    Route::get('register-form', 'RegisterController@showFormRegisterLessTwenty')->name('register-form');
    Route::get('register-form/{userId}', 'RegisterController@showFormRegisterLessTwenty')->name('register-form-user');
    Route::post('register', 'RegisterController@handleRegister')->name('handle-register');
    Route::get('verify/email', 'RegisterController@activeAccount')->name('active-account');
    Route::get('resend-email', 'RegisterController@resendEmail')->name('resend-email');

    Route::get('register-less-twenty-year-old', 'RegisterController@showFormRegisterLessTwenty')
        ->name('register-less-twenty');
});
// TeacherRegister
Route::group(['middleware' => ['is_step_teacher'], 'namespace' => 'Teacher', 'as' => 'teacher.', 'prefix' => 'teacher'], function () {
    Route::group(['prefix' => 'register', 'as' => 'register.'], function () {
        Route::get('/', 'TeacherRegisterController@register')->name('setting-account');
        Route::post('/', 'TeacherRegisterController@registerUpdate')->name('update');
//        Route::get('/setting-account', 'TeacherRegisterController@settingAccount')->name('setting-account');
//        Route::post('{userId}/update-account', 'TeacherRegisterController@updateAccount')->name('setting-account.update');
//        Route::post('{userId}/remove-image', 'TeacherRegisterController@removeImage')->name('setting-account.remove-image');
//        Route::get('/identification', 'TeacherRegisterController@identification')->name('setting-account.identification');
//        Route::get('/identification-two', 'TeacherRegisterController@identificationTwo')->name('setting-account.identification-two');
//        Route::post('{userId}/image-identify', 'TeacherRegisterController@updateImageIdentify')->name('setting-account.identification-two-update');
//        Route::post('{userId}/identification', 'TeacherRegisterController@verifyNdaOrBusinessCard')->name('setting-account.verify-nda-business-card');
//        Route::post('{userId}/business-verify', 'TeacherRegisterController@verifyNda');
//        Route::post('{userId}/business-card', 'TeacherRegisterController@verifyBusinessCard');
//        Route::post('{userId}/submit-identification', 'TeacherRegisterController@submitIdentification')->name('setting-account.submit-identification');
//        Route::get('{userId}/nda-verify', 'TeacherRegisterController@ndaVerify')->name('setting-account.nda-verify');
//        Route::get('{userId}/payment', 'TeacherRegisterController@payment')->name('setting-account.payment');
//        Route::post('{userId}/updatePayment', 'TeacherRegisterController@updateBankAccount')->name('setting-account.updatePayment');
    });
});

Route::post('bank-autocomplete', 'Teacher\TeacherRegisterController@bankAutocomplete')->name('bank-autocomplete');
Route::post('branch-autocomplete', 'Teacher\TeacherRegisterController@branchAutocomplete')->name('branch-autocomplete');

// 01_Top page
Route::get('/', 'Common\TopPageController@home')->name('home');
Route::get('/search', 'Common\TopPageController@search')->name('home.search');
Route::get('/user-guide', 'Common\TopPageController@userGuide')->name('user-guide');
Route::get('/live-streaming', 'Common\TopPageController@livestreaming')->name('live-streaming');
Route::get('/video-call', 'Common\TopPageController@videoCall')->name('video-call');
Route::get('/delivery-method', 'Common\TopPageController@deliveryMethod')->name('delivery-method');
Route::get('/management-company', 'Common\TopPageController@managementCompany')->name('management-company');

Route::group(['prefix' => 'teacher', 'as' => 'teacher.'], function () {
    // detail teacher
    Route::get('/detail/{user_id}', 'Common\TeacherPageController@teacherPage')->name('detail');
    Route::get('/{user_id}/message', 'Common\TeacherPageController@detailMessage')->name('detail.message');

    // load data ajax
    Route::get('/course-detail/{user_id}', 'Common\TeacherPageController@courseDetail')->name('course-detail');
    Route::get('/review-detail/{user_id}', 'Common\TeacherPageController@reviewDetail')->name('review-detail');
});


//option view share
Route::post('/option-view-share', 'Common\TopPageController@optionViewShare')->name('share.option-view');

// 03_Course schedule detail.
Route::namespace('Common')->group(function () {
    Route::group(['prefix' => 'course-schedules', 'as' => 'course-schedules.'], function () {
        Route::get('{course_schedule_id}/detail/fetch_data', 'CourseScheduleController@fetchData')->name('course-schedule.fetchData');
        Route::get('{course_schedule_id}/detail', 'CourseScheduleController@detail')->name('detail');
        Route::get('{course_schedule_id}/get-new-buyer', 'CourseScheduleController@getNewBuyer');
        Route::get('{course_schedule_id}/detail-status', 'CourseScheduleController@detailStatus')->name('detail-status');
    });
});
// Reset password
Route::group(['prefix' => 'password', 'as' => 'password-reset.'], function () {
    Route::get('/reset', 'Auth\ResetPasswordController@showLinkRequestForm')->name('show-link');
    Route::get('/reset-form/{token}', 'Auth\ResetPasswordController@showResetForm')->name('show-reset-form');
    Route::post('/mail', 'Auth\ResetPasswordController@sendResetLinkEmail')->name('send');
    Route::post('/reset', 'Auth\ResetPasswordController@resetPassword')->name('reset');
});
Route::group(['middleware' => ['is_logout_client']], function () {
    Route::get('logout', 'Common\TopPageController@logout');

//    Route::get('logout', function () {
//        auth()->guard('client')->logout();
//        \Illuminate\Support\Facades\Session::flush();
//        return redirect('login');
//    });
    Route::get('register-success', 'Common\TopPageController@registerSuccess')->name('register-success');
//    Route::get('register-success', function () {
//        $user = auth()->guard('client')->user();
//        return view('client.auth.register-complete', compact('user'));
//    })->name('register-success');
    Route::get('/api/card-info', 'Common\TopPageController@cardInfo');
//    Route::get('/api/card-info', function (\App\Services\Common\StripePaymentService $stripePaymentService) {
//        return $stripePaymentService->getCreditCard();
//    });

    // Common
    Route::namespace('Common')->group(function () {
        // Box Notification
        Route::group(['prefix' => 'teacher', 'as' => 'teacher.'], function () {
            Route::get('/notice', 'TeacherPageController@noticePage')->name('notice-page');
            Route::post('/notice/update-read-box', 'TeacherPageController@updateNoticeBox');
            Route::get('/notice/{noticeId}', 'TeacherPageController@show')->name('notice-detail');
        });

        // Purchase gift
        Route::post('/student/student-livestream/purchase-gift', 'GiftController@purchaseGift');

        Route::group(['prefix' => 'course-schedules', 'as' => 'course-schedules.'], function () {
            Route::post('/purchase-main-course', 'CourseScheduleController@purchaseMainCourse')->name('purchase-main-course');
            Route::post('/purchase-sub-course', 'CourseScheduleController@purchaseSubCourse')->name('purchase-sub-course');
        });

        // 07_Purchase gift
        Route::group(['prefix' => 'gift', 'as' => 'gift.'], function () {
            Route::post('/purchase', 'GiftController@purchaseGift')->name('purchase');
            Route::get('/list-old', 'GiftController@listOldGift');
        });

        // 08_Purchase question ticket
        Route::group(['prefix' => 'question-ticket', 'as' => 'question-ticket.'], function () {
            Route::post('/purchase', 'QuestionTicketController@purchaseQuestionTicket')->name('purchase');
        });

        Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
            Route::get('/list', 'MessageController@list')->name('list');
            Route::post('/notify', 'MessageController@sendEmailNotify')->name('send-email-notify');
            Route::get('/room/{roomId}', 'MessageController@detailRoom')->name('room-detail');
            Route::post('/send', 'MessageController@sendMessage')->name('send');
        });

        // 09_Purchase extension
        Route::group(['prefix' => 'extension', 'as' => 'extension.'], function () {
            Route::post('/purchase', 'ExtensionController@purchaseExtension')->name('purchase');
        });

        // Search course.
//        Route::get('courses', 'CourseController@listCourse')->name('courses.search');

        // agora
        Route::get('/agora-chat', 'AgoraController@index');
        Route::post('/agora/token', 'AgoraController@token');
        Route::post('/agora/call-user', 'AgoraController@callUser');

        // update image
        Route::post('/upload-image', 'ImagePathController@uploadImage')->name('image.upload');
        Route::post('/remove-image', 'ImagePathController@removeImageBackground')->name('image.remove');
        Route::post('/remove-image-default', 'TeacherPageController@removeImageBackgroundDefault')->name('image.remove-default');
    });

    // Student
    Route::group(['prefix' => 'student', 'as' => 'student.', 'namespace' => 'Student'], function () {
        // Report mail
        Route::post('/send-mail-report', 'JoinCourseController@reportTeacher')->name('report-teacher');
        Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
            Route::get('/review/{courseScheduleId}', 'CourseController@review')->name('page-review');
            Route::post('/review', 'CourseController@postReview')->name('post-review');
            Route::post('/restock', 'CourseController@postRequest');
        });
        // 28_Follow teacher
        Route::post('/follow-teacher', 'FollowController@followTeacher')->name('follow-teacher');
        Route::get('/follows', 'MyPageController@myPageFollowList')->name('follows');
        Route::post('/cancel-order', 'MyPageController@cancelOrder')->name('cancel-participation');
        Route::post('/cancel-order-confirm', 'MyPageController@cancelOrderConfirm')->name('cancel-participation-confirm');

        // student my-page
        Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
            // dashboard
            Route::get('/', 'MyPageController@dashboard')->name('dashboard');
            Route::get('/order-cancel', 'MyPageController@order')->name('order');
            Route::get('/order-list', 'MyPageController@list')->name('list');
            Route::get('/order-detail/{id}', 'MyPageController@show')->name('detail');
            Route::get('/order-review', 'MyPageController@review')->name('review');
            Route::get('/order-view/{id}', 'MyPageController@view')->name('view');
            Route::get('/follow', 'MyPageController@follow')->name('follow');
            Route::get('/account-setting', 'MyPageController@accountSetting')->name('account-setting');
            Route::get('/change-password', 'MyPageController@display')->name('change-password');
            Route::post('/change-password', 'MyPageController@changePassword')->name('post-student-changePassword');
            Route::get('/notify-setting', 'MyPageController@notiSetting')->name('notify-setting');
            Route::put('/notify-setting', 'MyPageController@settingNotify')->name('setting-notify');
            Route::get('/delete-account', 'MyPageController@deleteAccount')->name('delete-account');
            Route::post('/delete-account', 'MyPageController@closeAccount')->name('delete-account-post');
            Route::get('/credit-card-info', 'MyPageController@creditCardInfo')->name('credit-card-info');
            Route::get('/profile-email', 'MyPageController@profileAndEmail')->name('profile-and-email');
            Route::post('/profile-email', 'MyPageController@updateProfileAndEmail')->name('post-profile-and-email');
            Route::get('/edit-profile-email', 'MyPageController@updateProfileEmail')->name('edit-profile');
            Route::post('/edit-profile-email', 'MyPageController@updateProfile')->name('edit-profile-and-email-post');

            // Student my page purchase service.
            Route::get('/purchase-service', 'MyPageController@purchaseService')->name('purchase-service');
            Route::get('/purchase-service/live-stream-guide', 'MyPageController@liveStreamGuide')->name('livestream-guide');
//            Route::get('/purchase-service/live-stream-guide', function () {
//                return view('client.student-mypage.live-stream');
//            })->name('livestream-guide');
            Route::get('/purchase-service/video-call-guide', 'MyPageController@videoCallGuide')->name('video-call-guide');

//            Route::get('/purchase-service/video-call-guide', function () {
//                return view('client.student-mypage.video-call');
//            })->name('video-call-guide');

            // my page message course purchase
            // my page point
            Route::get('/point', 'MyPageController@point')->name('point');
            Route::get('/coupon', 'MyPageController@coupon')->name('coupon');
            // message
            Route::group(['prefix' => 'messages', 'as' => 'message.'], function () {
                Route::get('/courses-purchase', 'MyPageController@coursePurchasing')->name('course-purchasing');
                //message detail
                Route::get('detail/{userId}', 'MyPageController@detailMessage')->name('detail');
            });
        });

        // 29_Close account
        Route::post('/close-account', 'UserController@closeAccount')->name('.close-account');

        // Join Course Prepare LiveStream
        Route::group(['prefix' => 'join-course', 'as' => 'student-join-course.'], function () {
            Route::get('/question-ticket/{courseScheduleId}', 'JoinCourseController@getQuestionTicket')->name('join-course-id');
            Route::get('/{courseScheduleId}', 'JoinCourseController@joinCourse')->name('join-course-id');
            Route::get('/pay-extent/{courseScheduleId}', 'JoinCourseController@payExtent')->name('pay-extent');
            Route::post('/get-time-end/{courseScheduleId}', 'JoinCourseController@getTimeEnd')->name('get-time-end');
            Route::post('/pay-extent-end/{courseScheduleId}', 'JoinCourseController@payExtentEnd')->name('pay-extent-end');
        });
        //End Join Course Prepare LiveStream

        // Question ticket
        Route::group(['prefix' => 'question-ticket', 'as' => 'question-ticket.'], function () {
            Route::get('/{courseScheduleId}', 'JoinCourseController@getQuestionTicket');
            Route::post('', 'JoinCourseController@useQuestionTicket');
        });
        Route::post('/stamp', 'JoinCourseController@useQuestionTicketStamp');
        // End question ticket

        //Student Livestream
        Route::group(['prefix' => 'livestream', 'as' => 'livestream'], function () {
            Route::get('/{courseScheduleId}', 'StudentLiveStreamController@studentLiveStream')->name('student-live-stream')->where('courseScheduleId', '[0-9]+');
        });
        //End Student Live Stream

        Route::group(['prefix' => 'messages', 'as' => 'message.'], function () {
            //message purchase
            Route::get('/', 'MyPageController@listMessage')->name('list');
            Route::get('/room/{roomId}', 'MyPageController@detailRoom')->name('room-detail');

            //message detail
            Route::get('{courseScheduleId}/detail', 'MyPageController@getDetailCourseMessage')->name('message-detail');
            Route::get('teacher/{teacherId}', 'MyPageController@getDetailTeacherMessage')->name('message-detail-teacher');
            Route::post('send-message', 'MyPageController@sendDetailCourseMessage');
        });
    });

    // Teacher
    Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'namespace' => 'Teacher', 'middleware' => 'is_role_teacher'], function () {
        Route::get('/sub-course-detail/{courseId}', 'TeacherLiveStreamController@subCourseDetailPage')->name('sub-course.detail');
        //16_Available course schedule list
        //18_Cancel course schedule
        Route::put('/services/course/{course_schedule_id}/cancel', 'TeacherController@cancelCourse')->name('services.cancel-course');
        Route::get('/purchaser/list', 'TeacherMyPageController@getList')->name('purchaser.list');
        Route::get('/teacher-sale', 'TeacherMyPageController@listTeacherSale')->name('sale');
        //My Page
        Route::group(['prefix' => 'my-page', 'as' => 'my-page.'], function () {
            //15_Teacher dashboard
            Route::get('/', 'TeacherMyPageController@dashboard')->name('dashboard');
            Route::post('message/noticePopup', 'TeacherMyPageController@sendMessage')->name('myteacher.message-popup');
            Route::post('confirm-transfer', 'TeacherMyPageController@withDrawal')->name('teacher-mypage.confirm-transfer');
            Route::get('follower', 'TeacherMyPageController@listFollower')->name('teacher.follower');
            Route::group(['prefix' => 'message', 'as' => 'message.'], function () {
                // Teacher_message
                Route::post('send-message', 'TeacherMyPageController@sendDetailCourseMessage');
                Route::get('{courseScheduleId}/detail/{userId}', 'TeacherMyPageController@getMessageRoomDetail')->name('message-detail');
                Route::get('/detail/{userId}', 'TeacherMyPageController@getMessageRoomPrivate')->name('message-private-detail');
                Route::get('/message-course', 'TeacherMyPageController@messageCourse')->name('message-course');
                Route::get('/buyer/{courseScheduleId}', 'TeacherMyPageController@messageBuyer')->name('buyer');
                Route::get('/inquiry-list', 'TeacherMyPageController@getListPrivateChat')->name('inquiry-list');
                Route::get('/notification', 'TeacherMyPageController@messageNotification')->name('notification');
                Route::get('/notice', 'TeacherMyPageController@messageNotice')->name('notice');
                Route::post('/notice/store', 'TeacherMyPageController@messageNoticeStore')->name('teacher-my-page.message.notice.create');
                Route::post('/notification/updateIsRead', 'TeacherMyPageController@updateStatusReadNotification')->name('teacher-my-page.message.notification.update');
            });
            Route::get('service-list', 'TeacherMyPageController@serviceList')->name('service-list');
            Route::delete('service-list/delete', 'TeacherMyPageController@deleteCourse')->name('service-list.delete');
            Route::post('service-list/cancel', 'TeacherMyPageController@cancelCourse')->name('service-list.cancel');
            Route::get('service-list/{courseScheduleId}/list-student', 'TeacherMyPageController@getListStudent')->name('service-list.list-student');
            Route::group(['prefix' => 'sale-history', 'as' => 'sale-history'], function () {
//                Route::get('/', 'TeacherMyPageController@saleHistory')->name('teacher-mypage.sale-history');
                Route::get('/student-list/{id}', 'TeacherMyPageController@saleHistoryStudentList')->name('student-list');
                Route::get('/review/{id}', 'TeacherMyPageController@saleHistoryReview')->name('review');
            });
            Route::group(['prefix' => 'transfer-apply', 'as' => 'transfer-apply'], function () {
                Route::get('/application', 'TeacherMyPageController@transferApply');
                Route::post('/update-card/{id}', 'TeacherMyPageController@updateCard')->name('update-card');
            });
        });
        //End My Page
        Route::get('/my-page/follower', 'TeacherMyPageController@follower')->name('mypage-teacher-follower');
        Route::get('/my-page/profit', 'TeacherMyPageController@profitLiveStream')->name('profit-livestream');
        Route::get('/my-page/seller', 'TeacherMyPageController@sellerUserGuide')->name('seller-user-guide');
        Route::get('/my-page/delete-account', 'TeacherMyPageController@deleteAccount')->name('mypage-teacher-delete-account');
        Route::post('/my-page/delete-account', 'TeacherMyPageController@closeAccount')->name('mypage-teacher-delete-account-update');
        Route::get('/my-page/setting-account', 'TeacherMyPageController@settingAccount')->name('mypage-teacher-settingAccount');
        Route::post('/my-page/rest', 'TeacherMyPageController@restAccount')->name('mypage-teacher-restAccount');
        Route::get('/my-page/profile-edit', 'TeacherMyPageController@profileEdit')->name('mypage-teacher-profile-edit');
        Route::get('/my-page/profile-edit-nickname', 'TeacherMyPageController@profileEditNickname')->name('mypage-teacher-profile-edit-nickname');
        Route::post('/my-page/profile-edit', 'TeacherMyPageController@updateProfileNickname')->name('post-mypage-teacher-profile-edit-nickname');
        Route::get('/my-page/info-edit', 'TeacherMyPageController@infoEdit')->name('mypage-teacher-info-edit');
        Route::post('/my-page/info-edit', 'TeacherMyPageController@registrationInfoEdit')->name('mypage-teacher-info-edit-update');
        Route::get('/my-page/verification-edit', 'TeacherMyPageController@verificationEdit')->name('mypage-teacher-verifi-identity');
        Route::post('/my-page/verification-edit', 'TeacherMyPageController@updateVerification')->name('mypage-teacher-verifi-identity-update');
        Route::get('/my-page/credentials-edit', 'TeacherMyPageController@credentialsEdit')->name('mypage-teacher-credentials');
        Route::post('/my-page/credentials-edit', 'TeacherMyPageController@updateBusinessCard')->name('mypage-teacher-credentials-update');
        Route::get('/my-page/nda-detail', 'TeacherMyPageController@ndaDetails')->name('mypage-teacher-nda');
        Route::get('/my-page/generate-pdf-nda', 'TeacherMyPageController@generateNdaPDF')->name('mypage-generate-pdf-nda');

        //Teacher Join Course
        Route::group(['prefix' => 'join-course', 'as' => 'teacher-join-course.'], function () {
            Route::get('/{courseId}', 'TeacherLiveStreamController@joinCourse')->name('join-course-id');
            Route::post('/add-time-actual/{courseId}', 'TeacherLiveStreamController@addTimeActual')->name('add-time-actual');
        });
//        Route::group(['prefix' => 'course-preview', 'as' => 'course-preview.'], function () {
//            Route::get('{course_id}/{time_course_schedule}/livestream', 'TeacherCourseController@livestream')->name('livestream');
//            Route::get('{course_id}/consultation', 'TeacherCourseController@consultation')->name('consultation');
//            Route::get('{course_id}/fortune', 'TeacherCourseController@fortune')->name('fortune');
//        });

//        Route::group(['prefix' => 'course-schedule-preview', 'as' => 'course-schedule-preview.'], function () {
//            Route::get('{course_schedule_id}/consultation', 'TeacherCourseController@consultationPreview')->name('consultation');
//            Route::get('{course_schedule_id}/fortune', 'TeacherCourseController@fortunePreview')->name('fortune');
//        });

        Route::get('/guidelines', 'TeacherCourseController@viewGuidelines')->name('guidelines');
        //End Teacher Join Course

        Route::post('/courses/preview-course', 'TeacherController@previewCourse');
        Route::put('/courses/{id}/preview-clone-course', 'TeacherController@previewCloneCourse');
        // create course role teacher
        Route::resource('/courses', 'TeacherController')->only([
            'create', 'store', 'show', 'update'
        ]);
        Route::put('/courses/{id}/draft', 'TeacherController@updateDraft')->name('update-draft');
        Route::put('/course_schedules/{course_schedule_id}/preview', 'TeacherController@previewCourseSchedule');
        Route::resource('/course_schedules', 'TeacherCourseScheduleController')->only([
            'show', 'update'
        ]);
//        Route::get('/courses/{id}/draft', 'TeacherCourseScheduleController@draft')->name('draft');
        Route::group(['prefix' => 'course_schedules', 'as' => 'course_schedules.'], function () {
            Route::get('/{course_schedule_id}/public', 'TeacherController@publicCourseSchedule')->name('public');
        });
        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
            Route::get('/preview/{course_id}', 'TeacherCourseController@preview')->name('preview');
            Route::get('/preview-schedule/{id}', 'TeacherCourseController@previewSchedule')->name('preview-schedule');
            Route::get('/{courseId}/public', 'TeacherCourseController@publicCourse')->name('public');
            Route::get('/{courseId}/clone', 'TeacherCourseController@cloneCourse')->name('clone');
            Route::post('/live-stream/{courseId}/validate-step-2', 'TeacherController@validateCourseStep2');
        });
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        // order payment method edit
        Route::get('{courseScheduleId}/payment/edit', 'Common\PaymentController@edit')->name('payment.edit');
        // callback route payment success
        Route::get('payment-success', 'Common\PaymentController@processPayment')->name('payment.success');
        // edit payment method
        Route::post('edit', 'Common\PaymentController@update')->name('payment.update');
        // credit card and order confirm
        Route::post('/credit-confirm', 'Common\PaymentController@creditConfirmPayment')->name('payment.credit-confirm');
        // submit payment
        Route::post('submit-payment', 'Common\PaymentController@submitPayment')->name('payment.submit-payment');
        // sub course detail
        Route::get('/sub-course/{subCourseId}/detail', 'Common\PaymentController@subCourseScheduleDetail')->name('sub-course.detail');
        // do sub course order
        Route::post('sub-course/order', 'Common\PaymentController@getViewSubCourseOrder')->name('payment.sub-order');
        // group route required payment method
        // order payment method
        Route::get('/{courseScheduleId}', 'Common\PaymentController@index')->name('payment.index');
        // sub course order
        Route::get('sub-course/{mainCourseScheduleId}/order', 'Common\PaymentController@viewSubCourseOrder')->name('payment.sub-course.view');

        Route::group(['middleware' => 'require_payment_method'], function () {
            // order confirm
            Route::get('{courseScheduleId}/confirm', 'Common\PaymentController@confirmPayment')->name('payment.confirm');
            // sub-course confirm
            Route::get('sub-course/{mainCourseScheduleId}/confirm', 'Common\PaymentController@confirmSubCourseOrder')->name('payment.sub-course-confirm');
        });
    });
    Route::get('permission', 'Common\TopPageController@permission')->name('common.permission');
});
//Footer
Route::get('/my-page/seller-rank', 'Teacher\TeacherMyPageController@sellerRank')->name('seller-rank');
Route::get('/my-page/email-end-course-schedule/{courseSchedules}', 'Teacher\TeacherMyPageController@EmailEndCourseSchedule')->name('email-end-course');
Route::get('/my-page/inquiry-teacher', 'Teacher\TeacherMyPageController@inquiry')->name('inquiry-teacher');
Route::get('/my-page/inquiry', 'Teacher\TeacherMyPageController@inquiryTeacher')->name('inquiry');
Route::post('/my-page/send-inquiry', 'Teacher\TeacherMyPageController@sendInquiry')->name('send-inquiry');
Route::get('/my-page/guide', 'Teacher\TeacherMyPageController@guide')->name('guide');
Route::get('/my-page/guide-nine', 'Teacher\TeacherMyPageController@guideNine')->name('guide-nine');
Route::get('student/my-page/guide', 'Teacher\TeacherMyPageController@studentGuide')->name('student-guide');
Route::get('teacher/my-page/guide', 'Teacher\TeacherMyPageController@teacherGuide')->name('teacher-guide');

//become lappi
Route::get('/page-not-found', 'Common\TopPageController@pageNotFound')->name('common.404');
Route::get('/forbidden', 'Common\TopPageController@forbidden')->name('common.403');
Route::get('/page-expired', 'Common\TopPageController@pageExpired')->name('common.419');
Route::get('/not-found', 'Common\TopPageController@notFound')->name('client.notfound');

//Route::get('/page-not-found', function () {
//    return view('common.404');
//})->name('common.404');
//Route::get('/forbidden', function () {
//    return view('common.403');
//})->name('common.403');
//Route::get('/page-expired', function () {
//    return view('common.419');
//})->name('common.419');
//Route::get('not-found', function () {
//    return view('client.view-notfound');
//})->name('client.notfound');

//become lappi
Route::get('/become-lappi', 'Common\TopPageController@becomeLappi')->name('become-lappi');

//footer
//term of service
Route::get('/terms-of-service', 'Common\TopPageController@termsOfService')->name('terms-of-service');
//Route::get('/terms-of-service', function () {
//    return view('client.screen.footer.terms-of-service');
//})->name('terms-of-service');
Route::get('/privacy-policy', 'Common\TopPageController@privacyPolicy')->name('privacy-policy');

//Route::get('/privacy-policy', function () {
//    return view('client.screen.footer.privacy-policy');
//})->name('privacy-policy');

Route::get('/faq', 'Common\TopPageController@faq')->name('faq');

//Route::get('/faq', function () {
//    return view('client.screen.footer.faq');
//})->name('faq');
//payment_method
Route::get('/about-payment-method', 'Common\TopPageController@paymentMethodPage')->name('about.payment-method');
//safety-and-security
Route::get('/safety-and-security', 'Common\TopPageController@safetynAdSecurity')->name('safety-and-security');

//Route::get('/safety-and-security', function () {
//    return view('client.screen.footer.safety_security');
//})->name('safety-and-security');

Route::get('/about-usage-fee', 'Common\TopPageController@aboutUsageFee')->name('usage-fee');

//Route::get('/about-usage-fee', function () {
//    return view('client.screen.footer.usage_fee');
//})->name('usage-fee');

Route::get('/guide-new-member', 'Common\TopPageController@guideNewMember')->name('guide-new-member');

//Route::get('/guide-new-member', function () {
//    return view('client.screen.footer.guide-new-member');
//})->name('guide-new-member');

Route::get('/specified-commercial-transaction-law', 'Common\TopPageController@specifiedCommercialTransactionLaw')->name('specified-commercial-transaction-law');

//Route::get('/specified-commercial-transaction-law', function () {
//    return view('client.screen.footer.specified-commercial-transaction-law');
//})->name('specified-commercial-transaction-law');
//

Route::get('/seller-guidelines', 'Common\TopPageController@sellerGuidelines')->name('seller-guidelines');

//Route::get('/seller-guidelines', function () {
//    return view('client.screen.footer.seller_guidelines');
//})->name('seller-guidelines');
//

Route::get('/about-lappi', 'Common\TopPageController@aboutLappi')->name('about-lappi');

//Route::get('/about-lappi', function () {
//    return view('client.screen.footer.about-lappi');
//})->name('about-lappi');

Route::get('/student-guide/delivery-screen-video-call', 'Common\TopPageController@deliveryScreenVideoCall')->name('delivery-screen-video-call');

//Route::get('/student-guide/delivery-screen-video-call', function () {
//    return view('client.screen.footer.delivery-screen.video-call');
//})->name('delivery-screen-video-call');
Route::get('/student-guide/delivery-screen-livestream', 'Common\TopPageController@deliveryScreenLivestream')->name('delivery-screen-livestream');
//
//Route::get('/student-guide/delivery-screen-livestream', function () {
//    return view('client.screen.footer.delivery-screen.livestream');
//})->name('delivery-screen-livestream');

Route::get('/student-guide/delivery-screen-fortune', 'Common\TopPageController@deliveryScreenFortune')->name('delivery-screen-fortune');

//Route::get('/student-guide/delivery-screen-fortune', function () {
//    return view('client.screen.footer.delivery-screen.fortune-telling');
//})->name('delivery-screen-fortune');
