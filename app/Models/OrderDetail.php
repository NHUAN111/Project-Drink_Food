<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'order_code', 'food_id', 'food_name', 'food_price', 'food_sales_quantity', 'created_at', 'updated_at'
    ];
    protected $primaryKey = 'order_details_id';
    protected $table = 'tbl_order_details';

    public function order(){
        return $this->belongsTo('App\Models\Order', 'order_code');
    }

    public function food(){
        return $this->belongsTo('App\Models\Food', 'food_id');
    }

}
