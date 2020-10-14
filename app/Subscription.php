<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         "stripe_id", "stripe_product", "stripe_invoice", "ends_at"
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        "trial_ends_at", "ends_at", "created_at", "updated_at"
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Product
     */
    /*public function product()
    {
        return $this->belongsTo(Product::class);
    }
*/
    /**
     * Get total active subscriptions by product type
     *
     * @return mixed
     */
    /*public static function countByProduct()
    {
        return static::selectRaw('products.id, products.name as product_name, IFNULL(count(subscriptions.product_id), 0) as total')
            ->from('products')
            ->leftJoin('subscriptions', 'subscriptions.product_id', '=', 'products.id')
            ->where('products.id', '>', '0')
            ->orWhere('subscriptions.ends_at', '>=', Carbon::now())
            ->groupBy('products.id')
            ->get();
    }
    */
}
