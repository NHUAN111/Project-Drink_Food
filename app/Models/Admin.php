<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'admin_email', 'admin_pass', 'admin_name', 'admin_phone'
    ];

    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';

    public static function check_login($admin_email, $admin_pass){
        $result = Admin::where('admin_email', $admin_email)->where('admin_pass', $admin_pass)->first();
        return $result;
    } 
}
