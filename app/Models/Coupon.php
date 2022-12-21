<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'coupon_name', 'coupon_code', 'coupon_qty', 'coupon_number', 'coupon_condition', 'coupon_start', 'coupon_end',
    ];
    protected $primaryKey = 'coupon_id';
    protected $table = 'tbl_coupon';

    public function all_coupon(){
        $result = Coupon::orderBy('coupon_id', 'desc')
        ->take(12)->get();
        return $result;
    }
}