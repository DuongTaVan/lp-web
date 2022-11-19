<?php

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\QuestionTicket\PurchaseQuestionTicketRequest;
use App\Services\Client\QuestionTicket\PurchaseQuestionTicketService;

class QuestionTicketController extends Controller
{
    /**
     * Purchase question ticket
     *
     * @param PurchaseQuestionTicketRequest $request
     * @param PurchaseQuestionTicketService $service
     */
    public function purchaseQuestionTicket(PurchaseQuestionTicketRequest $request, PurchaseQuestionTicketService $service)
    {
        return $service->purchaseQuestionTicket($request->all());
    }
}
