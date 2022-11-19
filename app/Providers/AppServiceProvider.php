<?php

namespace App\Providers;

use App\Services\Client\BoxNotification\BoxNotificationService;
use App\Services\Client\Common\CourseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\CourseSchedule\CourseScheduleService;
use App\Services\Client\Teacher\TeacherMyPageService;
use App\Services\Client\Student\Course\MyPagePurchaseService;
use App\Services\Client\Student\MyPageOrderService;
use App\Services\Client\Student\MyPagePurchaseHistoryService;
use App\Services\Portal\UserService;
use App\Services\Portal\IdentityImageService;
use App\Services\Portal\TransferHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(
        Request                      $request,
        BoxNotificationService       $service,
        MyPagePurchaseHistoryService $historyService,
        MyPagePurchaseService        $purchaseService,
        MyPageOrderService           $orderCancelService,
        FirebaseService              $firebaseService,
        TeacherMyPageService         $teacherMyPageService,
        CourseScheduleService        $courseScheduleService,
        IdentityImageService         $identityImageService,
        CourseService                $courseService,
        TransferHistoryService       $transferHistoryService,
        UserService                  $userService
    )
    {
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }

        if (\Cache::has('currentDate')) {
            try {
                now()->setTestNow(\Cache::get('currentDate'));
            } catch (\Exception $e) {
                \Cache::forget('currentDate');
            }
        }
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount); ?>";
        });
        Blade::directive('percent', function ($element) {
            $element = explode(",", $element);
            $numerator = $element[0];
            $denominator = count($element) === 2 ? $element[1] : 0;

            return "<?php echo (int)$denominator ? (floor($numerator / $denominator * 1000) / 10) : 0; ?>";
        });
        Blade::directive('ratio', function ($element) {
            $element = explode(",", $element);
            $numerator = $element[0];
            $denominator = count($element) === 2 ? $element[1] : 0;

            return "<?php echo $denominator ? number_format(floor(($numerator) / ($denominator))) : 0; ?>";
        });

        Blade::directive('fakeBirthday', function ($element) {
            return "<?php
                switch (true) {
                    case ($element <= 19):
                        echo '10代';
                        break;
                    case ($element <= 29):
                        echo '20代';
                        break;
                    case ($element <= 39):
                        echo '30代';
                        break;
                    case ($element <= 49):
                        echo '40代';
                        break;
                    case ($element <= 59):
                        echo '50代';
                        break;
                    default:
                        echo '60代';
                        break;
                }?>";
        });

        // global variable
        View::composer([
            'client.layout.header',
            'client.layout.livestream.header',
        ], function ($view) use ($service, $request, $historyService, $teacherMyPageService) {
            if (auth()->guard('client')->check()) {
                $noticePopup = $service->listNotificationUnread()->toArray();
                if (\Route::currentRouteName() == 'client.teacher.notice-page') {
                    // check if user reload page.
                    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
                    if (!$pageWasRefreshed) {
                        $service->updateReadBoxNotice($request);
                        $noticePopup = $service->listNotificationUnread()->toArray();
                    }
                }
                $orderReviews = $historyService->getOrderReview($request);
                $totalReviews = $historyService->totalCourseScheduleReview($orderReviews);
                $teacherFollow = $teacherMyPageService->totalListFollower();
                $view->with([
                    'totalReviews' => $totalReviews,
                    'noticePopup' => $noticePopup,
                    'currentUser' => auth()->guard('client')->user(),
                    'teacherFollow' => $teacherFollow,
                ]);
            }
        });

        View::composer(['client.common.header-order'], function ($view) use ($orderCancelService) {
            $orderCancelService = $orderCancelService->orderCancel();

            $view->with([
                'orderCancelService' => $orderCancelService,
            ]);
        });

        View::composer([
            'client.student-mypage.sidebar-left',
            'client.layout.header'
        ],
            function ($view) use ($firebaseService) {
                if (auth('client')->check()) {
                    $totalUnread = Cache::pull('student/' . auth('client')->id() . '/count_message_unread')['total'] ??
                        $firebaseService->getStudentMessageUnread()['total'];
                    $view->with([
                        'COURSE_MESSAGE_UNREAD_STUDENT' => $totalUnread,
                    ]);
                }
            });

        View::composer([
            'client.screen.teacher.my-page.sidebar-left',
            'client.screen.teacher.my-page.message.__partials.navbar',
            'client.screen.teacher.my-page.services.tab',
            'client.layout.header'
        ],
            function ($view) use ($firebaseService, $courseScheduleService, $teacherMyPageService) {
                if (auth()->guard('client')->check()) {
                    $totalUnread = $firebaseService->getTeacherMessageUnread($courseScheduleService);
                    $totalMessageNotification = $teacherMyPageService->countDataMessage();
                    $teacherFollow = $teacherMyPageService->totalListFollower();
                    $totalCourseScheduleOpen = $courseScheduleService->totalCourseScheduleOpen();
                    $total = $totalUnread['totalMessageUnread'] + $totalMessageNotification['unreadNotification'];

                    $view->with([
                        'COURSE_MESSAGE_UNREAD' => $total,
                        'totalPurchasedUnread' => $totalUnread['totalPurchasedUnread'],
                        'totalNotPurchasedUnread' => $totalUnread['totalNotPurchasedUnread'],
                        'totalMessageNotification' => $totalMessageNotification,
                        'teacherFollow' => $teacherFollow,
                        'totalCourseScheduleOpen' => $totalCourseScheduleOpen,
                    ]);
                }
            });

        View::composer(['client.student-mypage.sidebar-left', 'client.layout.header'],
            function ($view) use (
                $request,
                $historyService,
                $purchaseService,
                $teacherMyPageService
            ) {
                if (auth()->guard('client')->check()) {
                    $total = 0;
                    $purchaseService = $purchaseService->courseSchedulePurchaseList($request);
                    $orderReviews = $historyService->getOrderReview($request);
                    $totalReviews = $historyService->totalCourseScheduleReview($orderReviews);
                    $totalMessageNotification = $teacherMyPageService->countDataMessage();
                    $view->with([
                        'total' => $total,
                        'purchaseService' => $purchaseService,
                        'totalReviews' => $totalReviews,
                        'totalMessageNotification' => $totalMessageNotification,
                    ]);
                }
            });

        View::composer('portal/layouts/sidebar', function ($view) use ($transferHistoryService, $courseService, $identityImageService, $userService) {
            $identityVerificationImage = $userService->countIdentityNotVerificationImage();
            $businessVerificationImage = $identityImageService->businessNotVerificationImage();
            $courses = $courseService->countCourseNotApprove();
            $transferHistory = $transferHistoryService->tranferHistoryError();
            $view->with([
                'identityVerificationImage' => $identityVerificationImage,
                'businessVerificationImage' => $businessVerificationImage,
                'courses' => $courses,
                'transferHistory' => $transferHistory,
            ]);
        });
    }
}
