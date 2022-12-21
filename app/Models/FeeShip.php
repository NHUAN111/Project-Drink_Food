<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeShip extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_fee_ship';

    public function find_fee_byId($fee_id){
        $result = FeeShip::find($fee_id);
        return $result;
    }

    public function city(){
        return $this->belongsTo('App\Models\City', 'fee_matp');
    }

    public function pronvice(){
        return $this->belongsTo('App\Models\Pronvice', 'fee_maqh');
    }

    public function wards(){
        return $this->belongsTo('App\Models\Wards', 'fee_xaid');
    }
}
