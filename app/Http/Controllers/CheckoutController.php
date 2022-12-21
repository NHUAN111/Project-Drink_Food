<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customers;
use App\Models\Shipping;
use App\Models\FeeShip;
use App\Models\Payment;
use App\Models\Order;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Pronvice;
use App\Models\Wards;
use App\Models\ConfigWeb;
use App\Models\OrderDetail;
use Brian2694\Toastr\Facades\Toastr;
use App\Rules\Captcha;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function dang_nhap()
    {
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.checkout.login')->with(compact('config_web', 'config_web_logo'));
    }

    public function dang_nhap_check(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
            'customer_email' => 'required', /* Nghiên cứu thêm validate của lava có thể truyền vào |string|min5|max15 để very */
            'customer_pass' => 'required',
            'g-recaptcha-response' => new Captcha(), //dòng kiểm tra Captcha
        ]);

        $EmailorName = $data['customer_email'];
        $customer_pass = md5($data['customer_pass']);
        $remember = $request->remember;

        $login = Customers::where('customer_pass', $customer_pass)->where('customer_email', $EmailorName)->orWhere('customer_name', $EmailorName)->first();
        if ($login) {
            if (isset($remember)) {
                if ($remember == 'on') {
                    setcookie("customer_email", $EmailorName, time() + (60 * 60 * 24 * 7));
                    setcookie("customer_pass", $customer_pass, time() + (60 * 60 * 24 * 7));
                }
            }
            $customer = array(
                'customer_id' => $login->customer_id,
                'customer_name' => $login->customer_name,
                'customer_phone' => $login->customer_phone,
            );
            session()->put('customer', $customer);
            Toastr::success('Đăng Nhập Thành Công!');
            return Redirect::to('/trang-chu');
        } else {
            Toastr::error('Đăng Nhập Thất Bại');
            return redirect()->back();
        }
    }

    public function dang_ky()
    {
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.Checkout.register')->with(compact('config_web_logo', 'config_web'));
    }

    public function them_dang_ky(Request $request)
    {
        $result = Customers::where('customer_email', $request->customer_email)->first();
        if ($result) {
            Toastr::error('Email Đã Tồn Tại');
            return redirect()->back();
        } else {
            $data = $request->validate([
                'customer_email' => 'required',
                'customer_pass' => 'required',
                'customer_name' => 'required',
                'customer_phone' => 'required',
                'g-recaptcha-response' => new Captcha(),
            ]);
            $customer = new Customers();
            $customer->customer_email = $data['customer_email'];
            $customer->customer_pass = md5($data['customer_pass']);
            $customer->customer_name = $data['customer_name'];
            $customer->customer_phone = $data['customer_phone'];
            $customer->save();

            if (isset($remember)) {
                if ($remember == 'on') {
                    setcookie("customer_email", $data['customer_email'], time() + (60 * 60 * 24 * 7));
                    setcookie("customer_pass", $data['customer_pass'], time() + (60 * 60 * 24 * 7));
                }
            }

            $customer = array(
                'customer_id' => $customer->customer_id,
                'customer_name' => $data['customer_name'],
                'customer_phone' =>  $data['customer_phone'],
                'customer_pass' => $data['customer_pass'],
            );
            session()->put('customer', $customer);
            Toastr::success('Đăng Ký Thành Công');
            return redirect()->to('/');
        }
    }

    public function dang_xuat()
    {
        Session::forget('customer_email');
        Session::forget('customer_pass');
        Session::forget('customer');
        setCookie("customer_email", null, time() + -100);
        setCookie("customer_pass", null, time() + -100);
        Toastr::success('Đăng Xuất Thành Công');
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.Checkout.login')->with(compact('config_web', 'config_web_logo'));
    }

    public function thu_tuc_thanh_toan()
    {
        $city = City::orderBy('matp', 'desc')->whereIn('matp', [48, 49])->get();

        $meta = array(
            'title' => 'Thông Tin Vận Chuyển',
            'description' => 'Trùm Ẩm Thực - Trang Tìm Kiếm Và Đặt Thức Uống Và Đồ Ăn Nhanh',
            'keywords' => 'Trùm Ẩm Thực, Đặt Món Ăn Nhanh',
            'canonical' => request()->url(),
            // 'sitename' => 'nhuandeptraivanhanbro.doancoso2.laravel.vn',
            'image' => '',
        );

        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

        return view('pages.Checkout.checkout')
            ->with(compact('city', 'meta', 'config_web_logo', 'config_web'));
    }

    public function thanh_toan()
    {
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.checkout.payment')->with(compact('config_web', 'config_web_logo'));
    }

    public function thong_tin_van_chuyen(Request $request)
    {
        $data = $request->all();
        // $data = $request->validate([
        //     'shipping_name' => 'required',
        //     'shipping_phone' => 'required',
        //     'shipping_address' => 'required',
        //     'shipping_notes' => 'required',             
        // ]);

        $address_shipping = Session::get('address_shipping');
        $name_tp = City::where('matp', $address_shipping['matp'])->first();
        $name_tp = $name_tp->name_city;

        $name_qh = Pronvice::where('maqh', $address_shipping['maqh'])->first();
        $name_qh = $name_qh->name_quanhuyen;

        $name_xaid = Wards::where('xaid', $address_shipping['xaid'])->first();
        $name_xaid = $name_xaid->name_xaphuong;

        $shipping_address =  $data['shipping_address'] . ' ' .  $name_xaid . ', ' .  $name_qh . ', ' .  $name_tp;
        Session::forget('address_shipping');

        $shipping = array(
            'shipping_name' => $data['shipping_name'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_address' => $shipping_address,
            'shipping_email' => $data['shipping_email'],
            'shipping_notes' => $data['shipping_notes'],
        );
        Session::put('shipping', $shipping);
        return Redirect::to('/thanh-toan');
    }


    public function payment()
    {
        $output = '';
        $output .= '';
        if (Session::get('cart')) {
            $total = 0;
            // Tổng đơn hàng SL * Giá
            foreach (Session::get('cart') as $key => $cart) {
                $subtotal = $cart['food_price'] * $cart['food_qty'];
                $total += $subtotal;
                $output .= '
            <tr class="cart-items-info">
                <td class="cart-item-img">
                    <img src="' . asset('public/upload/MonAn/' . $cart['food_img']) . '" alt="">
                </td>
                <td class="cart-item-name">' . $cart['food_name'] . '</td>
                <td class="cart-item-price">
                    ' . number_format($cart['food_price'], 0, ',', '.') . ' ' . 'đ' . '
                </td>
                <td class="cart-item-qty">
                    <input type="number" class="btn-update-cart" data-session_id="' . $cart['session_id'] . '" value="' . $cart['food_qty'] . '" min="1" name="">
                    <input type="hidden" name="rowId_cart" class="btn btn-sm" >
                </td>

                <td colspan="" class="cart-total-price">
                   ' . number_format($subtotal, 0, ',', '.') . ' ' . 'đ' . '</td>
                <td class="cart-item-close">
                    <a>
                        <i class="fa-regular fa-circle-xmark delete-cart" data-id=' . $cart['session_id'] . '></i>
                    </a>
                </td>
            </tr>';
            }

            $output .= '
        <tr class="cart-total">
            <td colspan="2" class="cart-total-title">Tổng:
                <span style="color: #9c9c9c; font-size: 1rem; font-weight: 400">(Tạm tính)</span>
            </td>';
            if (Session::get('fee')) {
                $fee_ship = Session::get('fee');
                $total_fee = $total + $fee_ship;
                $output .= '<td colspan="4" class="cart-total-price">
                    ' . number_format($total_fee, 0, ',', '.') . ' ' . 'đ' . '
                </td>';
            }
            $output .= '
        </tr>';

            if (Session::get('cart')) {
                $output .= '
                <tr class="m-1">
                    <td colspan="6">';
                if (Session::get('fee')) {
                    $output .= '
                            <label class="form-check-label" style="font-weight: bold"
                                for="flexRadioDefault2">
                                <i class="fa-solid fa-truck-fast"></i>
                                Phí Ship: ' . number_format(Session::get('fee'), 0, ',', '.') . ' đ' . '
                            </label>';
                }
                $output .= '
                    </td>
                </tr>
                <tr class="m-1">
                    <td colspan="6" class="border border-0">
                        <input class="form-check-input" type="radio" value="1" name="payment_method"
                            id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Thanh toán khi nhận hàng
                        </label>
                    </td>
                </tr>
                <tr class="m-1">
                    <td colspan="6">
                        <input class="form-check-input" type="radio" value="2"
                            name="payment_method" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Thanh toán trực tuyến
                        </label>
                    </td>
                </tr>';
            } else {
            }

            // Kiểm tra coupon, mã giảm 
            // 1: %
            // 2: Tiền
            if (Session::get('coupon')) {
                foreach (Session::get('coupon') as $key => $cou) {
                    if ($cou['coupon_condition'] == 1) {
                        $output .= '
            <tr>
                <td colspan="6">
                    <p style="border-style: dotted; " class="p-2 text-center">
                        <i class="fa-solid fa-tags"></i>
                        ' . $cou['coupon_code'] . '<span> --- Giảm ' . number_format($cou['coupon_number'], 0, ',', '.') . ' %</span>
                    </p>';
                        $total_coupon = ($total  * $cou['coupon_number']) / 100;
                        if (Session::get('fee')) {
                            $fee_ship = Session::get('fee');
                            $total_final = ($total - $total_coupon) + $fee_ship;
                            // $total_final = $total + $fee_ship - $total_coupon;
                        }
                        $output .= '
                </td>
                <tr class="cart-total">
                    <td colspan="2" class="cart-total-title">Tổng cuối:
                        <span style="color: #9c9c9c; font-size: 1rem; font-weight: 400"></span>
                    </td>
                    <td colspan="4" class="cart-total-price">
                        ' . number_format($total_final, 0, ',', '.') . ' ' . 'đ' . '
                    </td>
                </tr>';
                    } elseif ($cou['coupon_condition'] == 2) {
                        $output .= '
                    <td colspan="6">
                        <p style="border-style: dotted;" class="p-2 text-center">
                            <i class="fa-solid fa-tags text-danger"></i> 
                            ' . $cou['coupon_code'] . '<span>  -' . number_format($cou['coupon_number'], 0, ',', '.') . 'đ' . '</span>
                        </p>';
                        if (Session::get('fee') && Session::get('coupon')) {
                            $total_coupon = $total - $cou['coupon_number'];
                            $fee_ship = Session::get('fee');
                            $total_final = $total_coupon + $fee_ship;
                        } else {
                            $total_final = $total + Session::get('fee');
                        }
                        $output .= '
                        <p class="cart-total-title">Tổng cuối:
                            <span style="color: red">' . number_format($total_final, 0, ',', '.') . ' đ</span>
                        </p>
                    </td>';
                        $output .= '
            </tr>';
                    }
                }
            }

            $output .= '    
        </tr>';
        } else {
            $output .= '
            <tr>
                <td colspan="5">
                    <img src="https://bizweb.dktcdn.net/100/368/281/themes/739953/assets/empty-cart.png?1661855650057" style="display: block; margin: auto" width="310px">
                </td>
            </tr>
        ';
        }
        echo $output;
    }

    public function select_delivery_home(Request $request)
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

    public function dat_hang(Request $request)
    {
        $data = $request->all();

        $shipping = Session::get('shipping');
        $shipping_id = Shipping::insertGetId($shipping);

        // Thêm vô pt thanh toán
        $payment = new Payment();
        $payment->payment_method = $data['payment_method'];
        $payment->payment_status = 0;
        $payment->save();

        // Thêm vô order
        $customer = Session::get('customer');
        $order_code = 'TAT' . rand(00001, 99999);
        $order = new Order();
        $order->order_code = $order_code;
        if (Session::get('coupon')) { //Tồn tại coupon
            $coupon = Session::get('coupon');
            foreach ($coupon as $key => $v_coupon) {
                $coupon_code = $v_coupon['coupon_code'];
                $coupon_price = $v_coupon['coupon_number'];
            }
            $order->order_coupon = $coupon_code;
            $order->coupon_price = $coupon_price;
        } else { //Không tồn tại coupon
            $order->order_coupon = 0;
            $order->coupon_price = 0;
        }
        $order->order_feeship = Session::get('fee');
        if ($customer) {
            $order->customer_id = $customer['customer_id'];
        } else {
            $order->customer_id = 0; // 0: Khách vãn lai
        }
        $order->shipping_id = $shipping_id;
        $order->payment_id = $payment->payment_id;
        $order->order_status = 0; //Chưa duyệt đơn
        $order->save();

        // Thêm vô order detail
        $carts = Session::get('cart');
        if ($carts) {
            foreach ($carts as $cart) {
                $order_detail = new OrderDetail();
                $order_detail->order_code = $order_code;
                $order_detail->food_id = $cart['food_id'];
                $order_detail->food_name = $cart['food_name'];
                $order_detail->food_price = $cart['food_price'];
                $order_detail->food_sales_quantity = $cart['food_qty'];
                $order_detail->save();
            }
        }
        if ($data['payment_method'] == 1) {
            $coupon = Session::get('coupon');
            if ($coupon) {
                foreach ($coupon as $key => $v_coupon) {
                    $coupon_code = $v_coupon['coupon_code'];
                    $coupon_qty = $v_coupon['coupon_qty'];
                }
                $coupon = Coupon::where('coupon_code', $coupon_code)->first();
                $coupon->update(['coupon_qty' => $coupon_qty - 1]); // Giảm đi số lượng mã giảm giá
                Session::forget('cart');
                Session::forget('coupon');
                $config_web_logo = ConfigWeb::where('config_type', 0)->first();
                $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

                // return view('pages.Checkout.handcash')->with(compact('config_web_logo', 'config_web'));
            } else {
                Session::forget('cart');
                $config_web_logo = ConfigWeb::where('config_type', 0)->first();
                $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
                // return view('pages.Checkout.handcash')->with(compact('config_web_logo', 'config_web'));
            }
        } else {
            echo 'ATM';
        }
        $this->sendMail();
        return view('pages.Checkout.handcash')->with(compact('config_web_logo', 'config_web'));
    }

    public function sendMail()
    {
        $shipping = Shipping::orderBy('shipping_id', 'DESC')->first();
        $name = $shipping->shipping_name;
        $order = Order::orderBy('order_id', 'desc')->first();
        $order_detail = OrderDetail::where('order_code', $order->order_code)->get();
        $code = $order->order_code;
        $type = "Đơn Của Bạn Đang Chờ Duyệt";
        $to_name = "TAT - Xin Chào";
        $to_email = $shipping->shipping_email;

        $data = array(
            "name" => $name,
            "code" => $code,
            "type" => $type,
            "order" => $order,
            "orderdetail" => $order_detail,
        ); // send_mail of mail.blade.php

        Mail::send('pages.Order.mailToAdmin', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject("Xin Chào ! TAT Gửi Thông Tin Đơn Hàng"); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });
    }

    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        if ($data['matp']) {
            $fee_ship = FeeShip::where('fee_matp', $data['matp'])
                ->where('fee_maqh', $data['maqh'])
                ->where('fee_xaid', $data['xaid'])->get();
            if ($fee_ship) {
                $count_feeship = $fee_ship->count();
                if ($count_feeship > 0) {
                    foreach ($fee_ship as $key => $v_fee) {
                        Session::put('fee',  $v_fee->fee_feeship);
                        Session::save();
                    }
                } else {
                    Session::put('fee', 25000);
                    Session::save();
                }
            }
        }
        $address_shipping = array(
            'matp' => $data['matp'],
            'maqh' => $data['maqh'],
            'xaid' => $data['xaid'],
        );
        Session::put('address_shipping', $address_shipping);
    }

    public function message($type, $content)
    {
        $message = array(
            "type" => "$type",
            "content" => "$content",
        );
        session()->flash('message', $message);
    }
}
