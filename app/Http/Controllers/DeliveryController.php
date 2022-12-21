<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Pronvice;
use App\Models\Wards;
use App\Models\FeeShip;
use Brian2694\Toastr\Facades\Toastr;

class DeliveryController extends Controller
{
    public function select_feeship(){
        $fee_ship = FeeShip::orderBy('fee_id', 'ASC')->get();
        $output = '';
        $output .= '
    <div class="card">
        <div class="card-body">
        <table class="table-bordered table">
            <thead>
                <tr>
                    <th style="font-weight: bold;"> Tên thành phố </th>
                    <th style="font-weight: bold;"> Tên quân huyện </th>
                    <th style="font-weight: bold;"> Tên xã phường </th>
                    <th style="font-weight: bold;"> Phí vận chuyển </th>
                    <th style="font-weight: bold;"> Chức năng </th>
                </tr>
            </thead>
            <tbody>';
            foreach ($fee_ship as $key => $v_fee_ship) {
            $output .= '
                <tr class="table">
                    <td>'.$v_fee_ship->city->name_city.'</td>
                    <td>'.$v_fee_ship->pronvice->name_quanhuyen.'</td>
                    <td>'.$v_fee_ship->wards->name_xaphuong.'</td>
                    <td contenteditable data-feeship_id="'.$v_fee_ship->fee_id.'" class="fee_feeship_edit">'.number_format($v_fee_ship->fee_feeship, 0 , ',', '.').' đ</td>
                    <td>
                        <a class="delete-feeship" data-feeship_id="'.$v_fee_ship->fee_id.'">
                            <i class="mdi mdi-delete"
                            style="color: red; margin-right: 10px; font-size: 1.4rem"></i>
                        </a>
                    </td>
                </tr>';
                }
            $output .='
            </tbody>
        </table>
        </div>
    </div>';
        echo $output;
    }

    public function delete_delivery(Request $request){
        $data = $request->delete_id;
        $feeship = FeeShip::find($data);
        $feeship->delete();
    }

    public function insert_delivery(Request $request)
    {
        $data = $request->all();
        $fee_ship = new FeeShip();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }

    public function delivery(Request $request)
    {
        $city = City::orderBy('matp', 'desc')->whereIn('matp', [48,49])->get();

        return view('Admin.Fee_ship.add_delivery')
            ->with(compact('city'));
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_pronivce = Pronvice::where('matp', $data['matp'])->orderBy('maqh', 'ASC')->get();
                $output .= '<option>--Chọn quận huyện--</option>';
                foreach ($select_pronivce as $key => $pronivce) {
                    $output .= '<option value="' . $pronivce->maqh . '" >' . $pronivce->name_quanhuyen . ' </option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['matp'])->orderBy('xaid', 'ASC')->get();
                $output .= '<option>--Chọn xã phường--</option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value="' . $ward->xaid . '" >' . $ward->name_xaphuong . ' </option>';
                }
            }
        }
        echo $output;
    }

    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = FeeShip::find($data['feeship_id']);
        $fee_value = trim($data['fee_value'],'.');
        $fee_value = trim($data['fee_value'],'đ');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
