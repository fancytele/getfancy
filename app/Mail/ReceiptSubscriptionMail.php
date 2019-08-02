<?php

namespace App\Mail;

use App\Addon;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Stripe\Invoice as StripeInvoice;
use Stripe\Plan as StripePlan;

class ReceiptSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The StripeInvoice instance.
     *
     * @var StripeInvoice
     */
    public $receipt;

    /**
     * The product data.
     *
     * @var Collection
     */
    public $product;

    /**
     * The plans array data.
     *
     * @var array
     */
    public $plans;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(StripeInvoice $receipt)
    {
        $this->receipt = $receipt;
        $this->receipt->amount_paid = $this->formatStripeAmount($this->receipt->amount_paid);

        $this->setReceiptData();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.receipt')->subject("Fancy Payment Receipt");
    }

    /**
     * Set the data used in the View
     *
     * @return void
     */
    public function setReceiptData()
    {
        $subscription = Subscription::where('stripe_id', $this->receipt->subscription)->first();

        $stripe_data = collect($this->receipt->lines->data)->map(function ($item) {
            return $item->plan;
        });

        // Set Product
        $stripe_product = $stripe_data->firstWhere('nickname', $subscription->product->name);
        $this->setProduct($stripe_product);

        // Set Plans
        $stripe_plans = $stripe_data->filter(function ($item) use ($subscription) {
            return $item->nickname !== $subscription->product->name;
        })->values();

        $this->setPlans($stripe_plans);
    }

    /**
     * Set Product data
     *
     * @param StripePlan $stripe_product
     * @return void
     */
    public function setProduct(StripePlan $stripe_product)
    {
        $this->product = (object) [
            'name' => $stripe_product->nickname,
            'amount' => $this->formatStripeAmount($stripe_product->amount)
        ];
    }

    /**
     * Set Plans data
     *
     * @param StripePlan $stripe_product
     * @return void
     */
    public function setPlans(Collection $stripe_plans)
    {
        $plans = Addon::whereIn('code', $stripe_plans->pluck('nickname'))->get();

        $this->plans = $stripe_plans->map(function ($item) use ($plans) {
            return [
                'name' => $plans->firstWhere('code', $item->nickname)->name,
                'amount' => $this->formatStripeAmount($item->amount)
            ];
        })->toArray();
    }

    /**
     * Set Stripe amount to currency format
     * e.g.: 199900 -> 1,999.00
     * 
     * @param StripePlan $stripe_product
     * @return void
     */
    public function formatStripeAmount(int $amount)
    {
        return number_format((float) $amount / 100, 2);
    }
}
