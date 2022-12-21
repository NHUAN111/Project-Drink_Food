<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use SoftDeletes;
    protected $dates = [
       'deleted_at',
    ]; 
    public $timestamps = false;
    protected $fillable = [
    	'food_name', 'category_id', 'food_desc', 'food_content', 'food_price', 'food_img', 'food_status', 'food_condition', 'food_number'
    ];
    protected $primaryKey = 'food_id';
    protected $table = 'tbl_food';

    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function all_food(){
        $result = Food::orderBy('food_id', 'desc')
        ->take(12)->get();
        return $result;
    }

    public static function find_food_byId($food_id){
        $result = Food::find($food_id);
        return $result;
    }

    // Frontend
    public function all_food_hien(){
        $result = Food::orderBy('food_id', 'desc')
        ->where('food_status', '0')->get();
        return $result;
    }
}


