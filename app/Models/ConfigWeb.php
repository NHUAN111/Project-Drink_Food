<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigWeb extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'config_image', 'config_title', 'config_type',
    ];
    protected $primaryKey = 'config_id';
    protected $table = 'tbl_configweb';

}