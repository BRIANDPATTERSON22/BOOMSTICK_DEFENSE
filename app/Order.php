<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'orders';
    protected $fillable = ['uuid','order_no','customer_id','shipping_id','payment_id','coupon_id','note', 'rejection_message', 'sub_total', 'shipping_amount', 'transaction_amount', 'coupon_amount',' tax_amount', 'vat_amount', 'grand_total', 'is_same_as_billing', 'billing_address', 'billing_country_id', 'billing_city', 'billing_state', 'billing_postal_code', 'delivery_address', 'delivery_country_id', 'delivery_city', 'delivery_state', 'delivery_postal_code', 'checkout_type', 'payment_status', 'order_status', 'shipping_status', 'delivery_status', 'timezone_identifier', 'delivery_date', 'pickup_date', 'paypal_payment_id', 'paypal_payer_id', 'ip', 'is_viewed', 'bs_shipping_amount', 'rsr_shipping_amount'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem', 'order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Payment', 'payment_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo('App\Shipping', 'shipping_id');
    }

    public function coupongId()
    {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }
    public function coupon()
    {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo('App\SalesPerson', 'sales_person_id');
    }

    // 
    public function hasOrderbillingCountry()
    {
        return $this->belongsTo('App\Country', 'billing_country_id');
    }

    public function hasOrderdeliveryCountry()
    {
        return $this->belongsTo('App\Country', 'delivery_country_id');
    }

    // Status
    public function getOrderStatus()
    {
        if ($this->order_status == 1) {
            return '<span class="label label-default">Pending/ Unapproved</span>';
        }elseif ($this->order_status == 2) {
            return '<span class="label label-warning">Approved/ Processing</span>';
        }elseif ($this->order_status == 3) {
            return '<span class="label label-success">Completed</span>';
        }elseif ($this->order_status == 4) {
            return '<strike><span class="label label-danger">Order Rejected</span></strike>';
        }else{
            return '<span class="label label-default"> --- </span>';
        }

        // foreach (config('default.orderStatusArray') as $key => $value){
        //     foreach ($value as $key2 => $value2) {
        //        return $value2;
        //     }
        //     // if ($key == $this->order_status){
        //          // return $key[];
        //     // }
        // }
        // return config('default.orderStatusArray')[$this->order_status][2];
        // return config('default.checkoutTypeArray')[$this->order_status];

        // return "<span class="label label-default">{config('default.orderStatusArray')[$this->order_status][1]}</span>";
        // config('default.orderStatusArray')[$this->order_status][1]
        // return  "<span class=\"label label-"{config('default.orderStatusArray')[$this->order_status][1]}">{config('default.orderStatusArray')[$this->order_status][1]}</span>;

    }

    public function getDeliveryStatus()
    {
        // @if($row->status == 1)
        //     <span class="label label-default">Approval pending</span>
        // @elseif($row->status == 2)
        //     <span class="label label-warning">Order Approved</span>
        // @elseif($row->status == 3)
        //     <strike><span class="label label-danger">Order Rejected</span></strike> 
        // @elseif($row->status == 4)
        //     <span class="label label-primary">Dispatched</span>
        // @elseif($row->status == 5)
        //     <span class="label label-success">Delivered</span>
        // @endif

        if ($this->delivery_status == 1) {
            return '<span class="label label-primary">Dispatched</span>';
        }elseif ($this->delivery_status == 2) {
            return '<span class="label label-success">Delivered</span>';
        }else{
            return '<span class="label label-default"> --- </span>';
        }
    }

    public function getPaymentStatus()
    {
        // @if ($row->pay_status == 'PAID')
        //     <span class="label label-success">PAID</span>
        // @elseif($row->pay_status == 'UNPAID')
        //     <span class="label label-primary bg-navy">UNPAID</span>
        // @elseif($row->pay_status == 'INCOMPLETED')
        //     <span class="label label-default">INCOMPLETED</span>
        // @elseif($row->pay_status == 'FAILED')
        //     <strike> <span class="label label-danger">FAILED</span> </strike>
        // @else
        //     <span class="label label-danger">ERROR</span>
        // @endif

        if ($this->payment_status == 1) {
            return '<span class="label label-primary bg-navy">UNPAID/ ON HOLD</span>';
        }elseif ($this->delivery_status == 2) {
            return '<span class="label label-success">PAID</span>';
        }elseif ($this->delivery_status == 3) {
            return '<span class="label label-success">INCOMPLETED</span>';
        }elseif ($this->delivery_status == 4) {
            return '<span class="label label-danger">FAILED</span>';
        }elseif ($this->delivery_status == 5) {
            return '<span class="label label-info">REFUNDED</span>';
        }elseif ($this->delivery_status == 6) {
            return '<span class="label label-danger">ERROR</span>';
        }else{
            return '<span class="label label-default"> --- </span>';
        }
    }
}
