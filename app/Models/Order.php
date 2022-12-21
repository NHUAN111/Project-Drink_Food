<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_code',  'order_coupon', 'order_feeship', 'coupon_price' ,'customer_id', 'shipping_id', 'payment_id', 'order_status', 'created_at', 'updated_at'
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    public function find_order_byId($order_id){
        $result = Order::find($order_id);
        return $result;
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customers', 'customer_id');
    }

    public function shipping(){
        return $this->belongsTo('App\Models\Shipping', 'shipping_id');
    }

    public function payment(){
        return $this->belongsTo('App\Models\Payment', 'payment_id');
    }
}