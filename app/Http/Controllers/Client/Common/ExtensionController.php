<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Extension\PurchaseExtensionRequest;
use App\Services\Client\Extension\PurchaseExtensionService;

class ExtensionController extends Controller
{
    /**
     * Purchase extension
     *
     * @param PurchaseExtensionRequest $request
     * @param PurchaseExtensionService $service
     * @return array|bool[]
     */
    public function purchaseExtension(PurchaseExtensionRequest $request, PurchaseExtensionService $service)
    {
        return $service->purchaseExtension($request->all());
    }
}
