<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Course\CourseCommonRequest;
use App\Services\Client\TopPage\TopPageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TopPageController extends Controller
{
    /**
     * Get home
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function home(CourseCommonRequest $request, TopPageService $service)
    {
        $service->addPageViewTopPage();
        $topPage = $service->getDataTopPage();
        $data = $service->getDataCategory();
        $searchParams = [
            'category_id' => $request->input('category_id'),
            'category_type' => $request->input('category_type'),
            'time_frame' => $request->input('time_frame', null),
        ];

        return view('client.screen.home', compact('topPage', 'data', 'searchParams'));
    }

    /**
     *  Get schedules in day
     * @param Request $request
     * @param TopPageService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function schedulesInDay(Request $request, TopPageService $service)
    {
        $data = $service->getSchedulesInDay($request);

        return response([
            'data' => $data
        ]);
    }

    /**
     * Top page search.
     *
     * @param CourseCommonRequest $request
     * @param TopPageService $service
     * @return array
     */
    public function search(CourseCommonRequest $request, TopPageService $service)
    {
        $data = $service->searchCourse($request);
        $categories = $service->getDataCategory();

        $searchParams = [
            'sort' => $request->input('sort', null),
            'category_id' => (int)$request->input('category_id'),
            'category_type' => (int)$request->input('category_type'),
            'time_frame' => $request->input('time_frame'),
        ];

        return view('client.screen.search', compact('data', 'searchParams', 'categories'));
    }

    /**
     * Footer payment method page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function paymentMethodPage()
    {
        return view('client.screen.footer.payment_method');
    }

    /**
     * Footer student user fuide.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function userGuide()
    {
        return view('client.screen.footer.user-guide');
    }

    /**
     * Footer use live streaming.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function livestreaming()
    {
        return view('client.screen.footer.live-streaming');
    }

    /**
     * Footer use video call.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function videoCall()
    {
        return view('client.screen.footer.video-call');
    }

    /**
     * Footer use delivery method.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function deliveryMethod()
    {
        return view('client.screen.footer.delivery-method');
    }

    /**
     * Footer use video call.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function managementCompany()
    {
        return view('client.screen.footer.management-company');
    }

    /**
     * Become lappi.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function becomeLappi()
    {
        return view('client.common.become-lappi');
    }

    public function pageNotFound()
    {
        return view('common.404');
    }

    public function forbidden()
    {
        return view('common.403');
    }

    public function pageExpired()
    {
        return view('common.419');
    }

    public function notFound()
    {
        return view('client.view-notfound');
    }

    public function termsOfService()
    {
        return view('client.screen.footer.terms-of-service');
    }

    public function privacyPolicy()
    {
        return view('client.screen.footer.privacy-policy');
    }

    public function faq()
    {
        return view('client.screen.footer.faq');
    }

    public function safetynAdSecurity()
    {
        return view('client.screen.footer.safety_security');
    }

    public function aboutUsageFee()
    {
        return view('client.screen.footer.usage_fee');
    }

    public function guideNewMember()
    {
        return view('client.screen.footer.guide-new-member');
    }

    public function specifiedCommercialTransactionLaw()
    {
        return view('client.screen.footer.specified-commercial-transaction-law');
    }

    public function sellerGuidelines()
    {
        return view('client.screen.footer.seller_guidelines');
    }

    public function aboutLappi()
    {
        return view('client.screen.footer.about-lappi');
    }

    public function deliveryScreenVideoCall()
    {
        return view('client.screen.footer.delivery-screen.video-call');
    }

    public function deliveryScreenLivestream()
    {
        return view('client.screen.footer.delivery-screen.livestream');
    }

    public function deliveryScreenFortune()
    {
        return view('client.screen.footer.delivery-screen.fortune-telling');
    }

    public function permission()
    {
        return view('common.permission');
    }

    public function logout()
    {
        auth()->guard('client')->logout();
        Session::flush();
        return redirect('login');
    }

    public function registerSuccess()
    {
        $user = auth()->guard('client')->user();
        return view('client.auth.register-complete', compact('user'));
    }

    public function cardInfo(\App\Services\Common\StripePaymentService $stripePaymentService)
    {
        return $stripePaymentService->getCreditCard();
    }
}
