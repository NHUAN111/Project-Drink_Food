<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;


class CouponController extends Controller
{
    public function insert_coupon(){
        return view('Admin.Coupon.insert_coupon');
    }

    public function insert_coupon_code(Request $request){
        $coupon_code = Coupon::where('coupon_code', $request->coupon_code)->first();
        if($coupon_code){
            Toastr::error('Tên Mã Giảm Đã Tồn Tại', 'Thông Báo');
            return redirect()->back();
        }else{
            $data = $request->all();
            $coupon =  new Coupon();
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_number= $data['coupon_number'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_qty = $data['coupon_qty'];
            $coupon->coupon_condition = $data['coupon_condition'];
            $coupon->coupon_start = $data['coupon_start'];
            $coupon->coupon_end = $data['coupon_end'];
            $coupon->save();
            Toastr::Success('Thêm mã thành công', 'Thành công');
            return Redirect::to('/admin/coupon/insert-coupon');
        }
    }

    public function list_coupon(){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon = Coupon::orderBy('coupon_id', 'desc')->get();
        return view('Admin.Coupon.list_coupon')
        ->with(compact('coupon', 'today'));
    }

    public function delete_coupon(Request $request){
        $data = $request->delete_id;
        $coupon = Coupon::find($data);
        $coupon->delete();
        return Redirect::to('/admin/coupon/list-coupon');
    }

    public function edit_coupon_code(Request $request){
        $edit_coupon = Coupon::find($request->coupon_id);
        $manager_coupon = view('Admin.coupon.edit_coupon')
            ->with('edit_coupon', $edit_coupon);
        return view('admin.admin_layout')->with('edit_coupon', $manager_coupon);
    }

    public function update_coupon_code(Request $request){
        $data = $request->all();
        $coupon = Coupon::find($data['coupon_id']);

        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_qty = $data['coupon_qty'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_start = $data['coupon_start'];
        $coupon->coupon_end = $data['coupon_end'];
        $coupon->save();
        Toastr::success('Cập nhật mã giảm thành công', 'Thành công');
        return Redirect::to('/admin/coupon/list-coupon');
    }

    public function check_coupon(Request $request){
        // Kiểm tra hạn, mã giảm tồn tại, giá phải lớn hơn số giảm và số lượng
        $data = $request->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_end', '>=', $today)->where('coupon_qty', '>', 0)->first();
        if ($coupon) {
            $count_coupon = $coupon->count();
            if ($count_coupon) {
                $coupon_session = Session::get('coupon');
                if ($coupon_session) {
                    $is_vailibale = 0;
                    if ($is_vailibale == 0) {
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                            'coupon_qty' => $coupon->coupon_qty,
                        );
                        Session::put('coupon', $cou);
                    }
                } else {
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                        'coupon_qty' => $coupon->coupon_qty,
                    );
                    Session::put('coupon', $cou);
                }
                Session::save();
                Session::put('coupon', $cou);
                Toastr::success('Thêm mã giảm thành công', 'Thành công');
                return redirect()->back();
            }
        } else {
            Toastr::error('Mã giảm không tồn tại thành công', 'Thông báo');
            return redirect()->back();
        }
    }

    public function load_coupon(){
        $output = '';
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon = Coupon::orderBy('coupon_id', 'DESC')->get();
        foreach ($coupon as $key => $cou){
        $output .='
        <tr class="table">
            <td>'. $cou->coupon_name.'</td>
            <td>'.$cou->coupon_code .'</td>
            <td>'. $cou->coupon_qty.'</td>
            <td>';
                if($cou->coupon_condition == 1){
                    $output .='
                        Giảm '. $cou->coupon_number .' %';
                    }else{
                    $output .='
                        Giảm '. number_format($cou->coupon_number, 0, ',', '.') .' k';
                    }
                $output .='
            </td>
            <td>';
                if ($cou->coupon_end >= $today){
                    $output .='
                        <b style="color: green">Còn Hạn</b>';
                    }else{
                        $output .='
                    <b style="color: red">Hết Hạn</b>';
                    }
                $output .='
            </td>
            <td>'. $cou->coupon_start.'</td>
            <td>'.$cou->coupon_end.'</td>
            <td>
                <div>
                    <a class="delete-coupon" data-coupon_id="'.$cou->coupon_id .'">
                        <i class="mdi mdi-delete"
                            style="color: red; margin-right: 10px; font-size: 1.4rem"></i>
                    </a>
                    <a href="'. URL('/admin/coupon/edit-coupon-code?coupon_id=' . $cou->coupon_id) .'">
                        <i class="mdi mdi-open-in-new"
                            style="color:green; margin-right: 10px; font-size: 1.4rem"></i>
                    </a>
                </div>
            </td>
        </tr>';
    }
    return $output;
    }
}
