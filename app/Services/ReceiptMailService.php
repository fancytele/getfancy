<?php

namespace App\Services;

use App\Addon;
use App\Subscription;
use Illuminate\Support\Collection;

class ReceiptMailService
{
    /**
     * Stripe receipt 
     *
     * @var array
     */
    private $receipt;

    /**
     * StripeService instance
     *
     * @var StripeService
     */
    private $stripeService;

    /**
     * Stripe Subscription instance
     *
     * @var \Stripe\Subscription
     */
    private $receiptSubscription;

    /**
     * Stripe Product data
     *
     * @var array
     */
    private $receiptProduct;

    /**
     * Stripe Plans data
     *
     * @var array
     */
    private $receiptPlans;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(array $receipt)
    {
        $this->receipt = $receipt;
        $this->stripeService = new StripeService();
        $this->receiptSubscription = $this->stripeService->getSubscription($this->receipt['subscription']);

        $stripe_plans = collect($this->receipt['lines']['data'])->map(function ($item) {
            return $item['plan'];
        });

        $this->setProduct($stripe_plans);
        $this->setPlans($stripe_plans);
    }

    /**
     * Get receipt collection ready for Mail
     *
     * @return object
     */
    public function getDataToMail()
    {
        return (object) [
            'id' => $this->receipt['id'],
            'customer' => $this->receipt['customer_name'],
            'amount' => $this->formatStripeAmount($this->receipt['amount_paid']),
            'created' => $this->receipt['created'],
            'period_start' => $this->receiptSubscription->current_period_start,
            'period_end' => $this->receiptSubscription->current_period_end,
            'product' => (object) [
                'name' => $this->receiptProduct['nickname'],
                'amount' => $this->formatStripeAmount($this->receiptProduct['amount'])
            ],
            'plans' => (object) $this->receiptPlans
        ];
    }

    /**
     * Set Receipt data
     *
     * @param Collection $stripe_plans
     * @return void
     */
    private function setProduct(Collection $stripe_plans)
    {
        $subscription = Subscription::where('stripe_id', $this->receiptSubscription->id)->first();
        $this->receiptProduct = $stripe_plans->firstWhere('nickname', $subscription->product->name);
    }

    /**
     * Set Receipt Plans
     *
     * @param Collection $stripe_plans
     * @return void
     */
    private function setPlans(Collection $stripe_plans)
    {
        $only_plans = $stripe_plans->filter(function ($item) {
            return $item['nickname'] !== $this->receiptProduct['nickname'];
        })->values();

        $addons = Addon::whereIn('code', $only_plans->pluck('nickname'))->get();

        $this->receiptPlans = $only_plans->map(function ($item) use ($addons) {
            return [
                'name' => $addons->firstWhere('code', $item['nickname'])->name,
                'amount' => $this->formatStripeAmount($item['amount'])
            ];
        })->toArray();
    }

    /**
     * Set Stripe amount to currency format
     * e.g.: 199900 -> 1,999.00
     * 
     * @param int $amount
     * @return string
     */
    private function formatStripeAmount(int $amount)
    {
        return number_format((float) $amount / 100, 2);
    }
}
