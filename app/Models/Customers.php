<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model{
    public $timestamps = false;
    protected $fillable = [
        'customer_email', 'customer_name', 'customer_pass', 'customer_phone'
    ];
    protected $primaryKey = 'customer_id';
    protected $table = 'tbl_customers';

    public static function check_login($customer_email, $customer_pass){
        $result = Customers::where('customer_email', $customer_email)->where('customer_pass', $customer_pass)->first();
        return $result;
    } 

}