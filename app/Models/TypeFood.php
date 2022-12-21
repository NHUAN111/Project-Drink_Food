<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFood extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'type_food_name', 'type_food_price', 'type_food_status' ,'type_food_time'
    ];

    protected $primaryKey = 'type_food_id';
    protected $table = 'tbl_type_food';


}