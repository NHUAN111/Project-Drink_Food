<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = [
       'deleted_at' ,
    ]; 
    public $timestamps = false;
    protected $fillable = [
        'category_name', 'category_img', 'category_status'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category';

    public function all_category(){
        $result = Category::orderBy('category_id', 'asc')->get();
        return $result;
    }

    public function find_category_byId($category_id){
        $result = Category::find($category_id);
        return $result;
    }

    // Frontend
    public function all_category_hien(){
        $result = Category::orderBy('category_id', 'asc')->where('category_status', '0')->take(6)->get();
        return $result;
    }
}
