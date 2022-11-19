<?php

namespace App\Http\Middleware\Client;

use App\Services\Common\StripePaymentService;
use Closure;

class CheckPaymentMethod
{
    protected $stripePaymentService;

    public function __construct(
        StripePaymentService $stripePaymentService
    )
    {
        $this->stripePaymentService = $stripePaymentService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $courseScheduleId = $request->route()->parameter('courseScheduleId');
        $response = $this->stripePaymentService->getCreditCard();
        if ($response['data'] == null) {
            $params = [$courseScheduleId];
            if (strpos($request->path(), "sub-course") !== false) {
                $params['type'] = 'sub-course';
            }
            return redirect()->route('client.orders.payment.edit', $params);
        }
        return $next($request);
    }
}
