<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Gift\PurchaseGiftRequest;
use App\Services\Client\Gift\PurchaseGiftService;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    private $giftService;

    public function __construct()
    {
        $this->giftService = app(PurchaseGiftService::class);
    }

    /**
     * Purchase gift
     *
     * @param PurchaseGiftRequest $request
     * @param PurchaseGiftService $service
     * @return array|bool[]
     */
    public function purchaseGift(PurchaseGiftRequest $request, PurchaseGiftService $service)
    {
        return $service->purchaseGift($request->all());
    }

    public function listOldGift(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $boughtGifts = $this->giftService->boughtGifts($request->csId);
            foreach ($boughtGifts as $key => $item) {
                $boughtGifts[$key] = (object)[
                    'gift' => (object)[
                        'name' => $item->gift->name,
                        'image' => $item->gift->image
                    ],
                    'user' => (object)[
                        'fullName' => $item->user->full_name,
                        'profile' => $item->user->profile_image
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $boughtGifts
            ]);
        }
    }
}
