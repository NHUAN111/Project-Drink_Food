<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Redirect;


class OrderController extends Controller
{
    public function manager_order()
    {
        $all_order = Order::orderBy('order_id', 'DESC')->paginate(10);

        $manager_order = view('Admin.Order.manager_order')
            ->with(compact('all_order'));

        return view('admin.admin_layout')
            ->with(compact('manager_order'));
    }

    public function view_order(Request $request)
    {
        $order_byId = Order::where('order_code', $request->order_code)->first();
        $order_detailId = OrderDetail::where('order_code', $request->order_code)->get();
        $coupon = Coupon::where('coupon_code', $order_byId->order_coupon)->first();
        // Nếu không tồn tại coupon
        if ($order_byId->order_coupon == 0) {
            $coupon_condition = 0; // % hay tiền không có trong trường, chỉ gửi dữ liệu qua để kt
        } else {
            $coupon_condition = $coupon->coupon_condition; // % hay tiền không có trong trường, chỉ gửi dữ liệu qua để kt
        }
        $manager_order = view('Admin.Order.view_order')
            ->with(compact('order_byId', 'order_detailId', 'coupon_condition'));

        return view('admin.admin_layout')
            ->with(compact('manager_order'));
    }

    public function delete_order(Request $request)
    {
        // $shipping_id = Shipping::find($request->order_id);
        // $shipping_id->delete();

        $order_byId = Order::find($request->order_id);
        $order_byId->delete();
    }

    // Xác nhận đơn hàng
    public function confirmation_order(Request $request)
    {
        $data = $request->all();
        if($data['order_status'] == 0){
            $order = Order::where('order_id', $data['order_id'])->first();
            $order->update(['order_status' => 1]);
        }
    }

    public function cancel_order(Request $request)
    {
        $data = $request->all();
        if($data['order_status'] == 0){
            $order = Order::where('order_id', $data['order_id'])->first();
            $order->update(['order_status' => 3]);
        }
    }

    public function load_order()
    {
        // 0: Đơn hàng mới
        // 1: Đơn đã duyệt
        // 2: Đơn đã bị Huỷ
        // 3: Đơn hàng bị từ chối
        $output = '';
        $i = 0;
        $all_order = Order::orderBy('order_id', 'DESC')->paginate(10);
        foreach ($all_order as $key => $value_order) {
            $output .= '
        <tr class="table">
            <td>' . ++$i . '</td>
            <td>' . $value_order->order_code . '</td>';
            if ($value_order->customer_id == 0) {
                $output .= '
                <td>Khách vãng lai</td>';
            } else {
                $output .= '
                <td>' . $value_order->customer->customer_name . '</td>';
            }
            if ($value_order->order_status == 0) {
                $output .= '
                      <td class="fw-bold text-info"> Đang Chờ Duyệt <span class="mdi mdi-new-box" style="color: #198ae3; font-size: 22px;"></span></td>';
            } else if($value_order->order_status == 1){
                $output .= '
                    <td class="text-success fw-bold"> Đơn Đã Duyệt  <span class="mdi mdi-check-circle" style="color: green; font-size: 22px;"></span>   </td>';
            } else if($value_order->order_status == 2){
                $output .= '
                    <td class="fw-bold" style="color: orange"> Đơn Bị Huỷ <span class="mdi mdi-calendar-remove" style="color: orange; font-size: 22px;"></span>   </td>';
            }else if($value_order->order_status == 3){
                $output .= '
                    <td class="text-danger fw-bold"> Đơn Bị Từ Chối <span class="mdi mdi-calendar-remove" style="color: red; font-size: 22px;"></span>   </td>';
            }
            if ($value_order->payment->payment_method == 1) {
                $output .= '<td>Thanh toán khi nhận hàng</td>';
            } else {
                $output .= '<td>Thanh toán trực tuyến</td>';
            }
            Carbon::setLocale('vi');
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $NgayDat = Carbon::create($value_order->created_at);
            $NgayDuyet = Carbon::create($value_order->updated_at);
            $output .= '
                <td>' . $NgayDat->format('d/m/Y') . ' <br> <br> ' . $NgayDat->format('h:i:s') . ' </td>';
            if ($value_order->order_status == 0) {
                $output .= '
                    <td>' . $value_order->updated_at . '</td>';
            } else {
                $output .= '
                    <td>' . $NgayDuyet->format('d/m/Y') . ' <br> <br> ' . $NgayDuyet->format('h:i:s') . '</td>';
            }
            $output .= '
            <td>';
            //Xử lý đơn hàng
            if ($value_order->order_status == 0) {
                $output .= '
                    <div>
                        <a href="' . URL('/admin/order/view-order?order_code=' . $value_order->order_code) . '"
                            class="btn btn-gradient-info">
                            <i class="mdi mdi-eye"></i>
                                Xem đơn
                        </a>
                        <br><br>
                        <a data-item_id = "' . $value_order->order_id . '" data-item_status="0" class="btn btn-gradient-danger cancel-order">
                            <i class="mdi mdi-close-circle"></i>
                                Từ chối
                        </a>
                        <br> <br>
                        <a data-item_id = "' . $value_order->order_id . '" data-item_status="0" class="btn btn-gradient-success update-status">
                            <i class="mdi mdi-check-circle"></i>
                                Duyệt đơn
                        </a>
                    </div>';
            } else if ($value_order->order_status == 1) {
                $output .= '
                    <div>
                        <a href="' . URL('/admin/order/view-order?order_code=' . $value_order->order_code) . '"
                            class="btn btn-gradient-info">
                            <i class="mdi mdi-eye"></i>
                            Xem đơn
                        </a>
                        <br> <br>
                        <a data-item_id = "' . $value_order->order_id . '" class="btn btn-gradient-danger btn-delete-order">
                            <i class="mdi mdi-delete-sweep"></i>
                            Xóa đơn
                        </a>
                    </div>';
            }else if($value_order->order_status == 2){
                $output .= '
                <div>
                    <a href="' . URL('/admin/order/view-order?order_code=' . $value_order->order_code) . '"
                        class="btn btn-gradient-info">
                        <i class="mdi mdi-eye"></i>
                        Xem đơn
                    </a>
                    <br> <br>
                    <a data-item_id = "' . $value_order->order_id . '" class="btn btn-gradient-danger btn-delete-order">
                        <i class="mdi mdi-delete-sweep"></i>
                        Xóa đơn
                    </a>
                </div>';
            } else if($value_order->order_status == 3){
                $output .= '
                <div>
                    <a href="' . URL('/admin/order/view-order?order_code=' . $value_order->order_code) . '"
                        class="btn btn-gradient-info">
                        <i class="mdi mdi-eye"></i>
                        Xem đơn
                    </a>
                    <br> <br>
                    <a data-item_id = "' . $value_order->order_id . '" class="btn btn-gradient-danger btn-delete-order">
                        <i class="mdi mdi-delete-sweep"></i>
                        Xóa đơn
                    </a>
                </div>';
            }
            $output .= '
            </td>';
        }
        $output .= '
    </tr>';
        return $output;
    }

    public function print_order(Request $request){
        $order_code = $request->order_code;
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($order_code));
        return  $pdf->stream();
    }

    public function print_order_convert($order_code){
        $order = Order::where('order_code', $order_code)->first();
        $order_detail = OrderDetail::where('order_code', $order_code)->get();
        $output = '';
        $output .='
            <style>
                body{
                    font-family: DejaVu Sans;
                }
                th, td{
                    padding: 10px;
                    text-align: center;
                }
            </style>
            <div style="display: flex">
                <div style="text-align: center"> 
                    <img width=150 height=150 style="border-radius: 50%; object-fit: cover" src="https://virama.vn/wp-content/uploads/2021/02/mok-5-scaled.jpg" alt="">
                </div>
                <div>
                    <h5 style="text-align: center;">470 Đường Trần Đại Nghĩa, Khu đô thị, Ngũ Hành Sơn, Đà Nẵng 550000</h5>
                </div>
                <h3 style="border-bottom: 1px solid #000;text-align: center">HOÁ ĐƠN THANH TOÁN</h3>
                <span>Mã Đơn Hàng: '.$order->order_code.'</span> </br>
                <span>Thời Gian Đặt: '.$order->created_at.'</span> </br> 
            </div>
            <table style="border-collapse: collapse; width: 100%;"  >
                <thead>
                    <th style="border: 1px solid #ddd;">STT</th>
                    <th style="border: 1px solid #ddd;">Món</th>
                    <th style="border: 1px solid #ddd;">SL</th>
                    <th style="border: 1px solid #ddd;">Giá</th>
                    <th style="border: 1px solid #ddd;">Thành Tiền</th>
                </thead>
                <tbody>';
                $i = 0;
                $total = 0;
                foreach( $order_detail as $key => $v_order_detail){
                    $subtotal = $v_order_detail->food_price * $v_order_detail->food_sales_quantity;
                    $total += $subtotal;
                    $output.='
                    <tr>
                        <td style="border: 1px solid #ddd;">'.++$i.'</td> 
                        <td style="border: 1px solid #ddd;">'.$v_order_detail->food->food_name.'</td>
                        <td style="border: 1px solid #ddd;">'.$v_order_detail->food_sales_quantity.'</td>
                        <td style="border: 1px solid #ddd;">'.number_format($v_order_detail->food_price,0,',','.').' đ</td>
                        <td style="border: 1px solid #ddd;">'.number_format($subtotal,0,',','.').' đ</td>
                    </tr>';
                } 
                $output .='
                <tr>
                    <th style="border: 1px solid #ddd;" text-align: start" colspan=4>Tổng Đơn</th>
                    <th style="border: 1px solid #ddd;" colspan=1>'.number_format($total,0,',','.').' đ</th>
                </tr>
                </tbody>';
    
            if ($order->order_coupon == 0) {
                $fee_ship = $order->order_feeship;
                $total = $total + $fee_ship;
                $output .='
                <tr>
                    <th text-align: start" colspan=4>Giảm Giá</th>
                    <th  colspan=1> 0đ</th>
                </tr>
                <tr>
                    <th text-align: start" colspan=4>Phí Ship</th>
                    <th  colspan=1>'.number_format($order->order_feeship,0,',','.').' đ</th>
                </tr>
                <tr style="border-bottom: 1px solid">
                    <th text-align: start;" colspan=4>Tổng Thanh Toán</th>
                    <th  colspan=1>'.number_format($total,0,',','.') .'đ</th>
                </tr>';
            } else {
                $fee_ship = $order->order_feeship;
                $coupon_price = $order->coupon_price; // Số tiền giảm
                if ($coupon_price <= 100) { // Theo %
                    $total_coupon = ($total * $coupon_price) / 100; //Số Tiền Giảm %
                    $total = ($total - $total_coupon) + $fee_ship;
                    $output .='
                <tr>
                    <th text-align: start" colspan=4>Giảm Giá</th>
                    <th  colspan=1> -'. $order->coupon_price .' %</th>
                </tr>
                <tr>
                    <th text-align: start" colspan=4>Phí Ship</th>
                    <th  colspan=1>'.number_format($order->order_feeship,0,',','.').' đ</th>
                </tr>
                <tr style="border-bottom: 1px solid">
                    <th text-align: start;" colspan=4>Tổng Thanh Toán</th>
                    <th  colspan=1>'.number_format($total,0,',','.') .'đ</th>
                </tr>';
                } else if ($coupon_price > 1000) { // Theo Tiền
                    $total_coupon = $total - $coupon_price; //Số Tiền Giảm Theo Tiền
                    $total = $total_coupon + $fee_ship;
                    $output .='
                    <tr>
                        <th text-align: start" colspan=4>Giảm Giá</th>
                        <th  colspan=1> -'. number_format($order->coupon_price,0,',','.') .' đ</th>
                    </tr>
                    <tr>
                        <th text-align: start" colspan=4>Phí Ship</th>
                        <th  colspan=1>'.number_format($order->order_feeship,0,',','.').' đ</th>
                    </tr>
                    <tr style="border-bottom: 1px solid">
                        <th text-align: start;" colspan=4>Tổng Thanh Toán</th>
                        <th colspan=1>'.number_format($total,0,',','.') .'đ</th>
                    </tr>
                    </table>';
                }
            }
            $output .='
            <div style="display: flex; justify-content: center;">
                <h5 style="text-align: center">TAT-Xin Cảm Ơn Quý Khách Đã Đặt Hàng !</h5> 
                <h5 style="text-align: center">Liện Hệ TAT: 0359.826.836</h5>   
            </div>';
        return $output;
    }   
}
