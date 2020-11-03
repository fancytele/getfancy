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
    private $data;

    /**
     * Create a new service instance.
     *
     * @param array $receipt
     * @param $data
     */
    public function __construct(array $receipt , $data)
    {
        $this->receipt = $receipt;
        $this->data = $data;
        $this->stripeService = new StripeService();
        $this->receiptSubscription = $this->stripeService->getSubscription($this->receipt['subscription']);

        $this->setPlans($data['addons']);
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
                'name' => 'Monthly',
                'amount' => $this->data['price']
            ],
            'plans' => (object) $this->receiptPlans,
            'amount_paid' => array_sum(array_column($this->receiptPlans , 'amount'))
        ];
    }

    /**
     * Set Receipt Plans
     *
     * @param $data
     * @return void
     */
    private function setPlans($data)
    {
        $addons = Addon::whereIn('code' , $data)->get();

        $this->receiptPlans = [];
       foreach ($addons as $addon){
            $this->receiptPlans[] =  [
              'name' =>$addon['name'],
              'amount' => $addon['cost']
            ];
        }
    }

    /**
     * Set Stripe amount to currency format
     *
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
