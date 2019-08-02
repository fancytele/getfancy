<?php

namespace App\Http\Controllers;

use App\Mail\ReceiptSubscriptionMail;
use App\Services\StripeService;
use Stripe\Error\InvalidRequest as StripeInvalidRequest;

class EmailController extends Controller
{
    private $stripeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function receiptSubscription(string $receipt_id)
    {
        try {
            $receipt = $this->stripeService->getInvoice($receipt_id);
        } catch (StripeInvalidRequest $e) {
            return abort(404);
        }

        return new ReceiptSubscriptionMail($receipt);
    }
}
