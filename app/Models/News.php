<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'news_title', 'news_image', 'news_content', 'news_status', 'create_at', 'update_at'
    ];
    protected $primaryKey = 'news_id';
    protected $table = 'tbl_news';

}