<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ConfigWeb;

class CartController extends Controller     
{
    public function them_gio_hang(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_avaiable = 0;
            foreach ($cart as $key => $val) {
                if ($val['food_id'] == $data['cart_food_id']) {
                    $is_avaiable++;
                    $qty = $cart[$key]['food_qty'];
                    $cart[$key]['food_qty'] = ($qty+1);
                    Session::put('cart', $cart);
                    break;
                }
            }
            if ($is_avaiable == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'food_name' => $data['cart_food_name'], 
                    'food_id' => $data['cart_food_id'],
                    'food_img' => $data['cart_food_img'],
                    'food_qty' => $data['cart_food_qty'],
                    'food_price' => $data['cart_food_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'food_name' => $data['cart_food_name'],
                'food_id' => $data['cart_food_id'],
                'food_img' => $data['cart_food_img'],
                'food_qty' => $data['cart_food_qty'],
                'food_price' => $data['cart_food_price'],
            );
            Session::put('cart', $cart);
        }
        Session::save();
    }

    public function count_cart(){
        $cart = Session::get('cart');
        if($cart){
            $count_cart = count($cart);
            return $count_cart;
        }else{
            $count_cart = 0;
            return $count_cart;
        }
    }

    public function loading_cart(){
        $output = '';
        $output .= '';
        if (Session::get('cart')) {
            $total = 0;
            foreach (Session::get('cart') as $key => $cart) {
                $subtotal = $cart['food_price'] * $cart['food_qty'];
                $total += $subtotal;
                $output .= '
            <tr class="cart-items-info">
                <input type="hidden" value="'. $cart['food_id'].'">
                <td class="cart-item-img">
                    <img src="' . asset('public/upload/MonAn/' . $cart['food_img']) . '" alt="">
                </td>
                <td class="cart-item-name ">' . $cart['food_name'] . '</td>
                <td class="cart-item-price">
                    ' . number_format($cart['food_price'], 0, ',', '.') . ' ' . 'đ' . '
                </td>
                <td class="cart-item-qty">
                    <input type="number" class="btn-update-cart" data-session_id="'.$cart['session_id'].'" value="'.$cart['food_qty'].'" min="1">
                    <input type="hidden" name="rowId_cart" class="btn btn-sm">
                </td>
                <td colspan="" class="cart-total-price">' . number_format($subtotal, 0, ',', '.') . ' ' . 'đ' . '</td>
                <td class="cart-item-close">
                    <a>
                        <i class="fa-regular fa-circle-xmark delete-cart" data-id='.$cart['session_id'].'></i>
                    </a>
                </td>
            </tr>
        ';
            }
        $output .= '
        <tr class="cart-total">
            <td colspan="2" class="cart-total-title">Tổng:
                <span style="color: #9c9c9c; font-size: 1rem; font-weight: 400">(Tạm tính)</span>
            </td>';
            $output .= '<td colspan="4" class="cart-total-price">' . number_format($total, 0, ',', '.') . ' ' . 'đ' . '</td>
        </tr>';

            if (Session::get('coupon')) {
                foreach (Session::get('coupon') as $key => $cou) {
                    if ($cou['coupon_condition'] == 1) {
                        $output .= '
            <tr>
                <td colspan="6">
                    <p style="border-style: dotted;" class="p-2 text-center">
                    <i class="fa-solid fa-tags"></i>
                    ' . $cou['coupon_code'] . '  -<span>'.number_format($cou['coupon_number'], 0, ',', '.').' %</span></p>';
                        $total_coupon = $total * $cou['coupon_number'] / 100;
                        $output .= '
                    <p>Tổng giảm: ' . number_format($total_coupon, 0, ',', '.') . 'đ</p>
                </td>
                <tr class="cart-total">
                    <td colspan="2" class="cart-total-title">Tổng sau giảm:
                        <span style="color: #9c9c9c; font-size: 1rem; font-weight: 400"></span>
                    </td>
                    <td colspan="4" class="cart-total-price">
                        ' . number_format($total - $total_coupon, 0, ',', '.') . ' ' . 'đ' . '
                    </td>
                </tr>';
                    } else if ($cou['coupon_condition'] == 2) {
                        $output .= '
                    <td colspan="6">
                        <p style="border-style: dotted;" class="p-2 text-center">
                        <i class="fa-solid fa-tags"></i>
                        ' . $cou['coupon_code']. ' -<span>'.number_format($cou['coupon_number'],0,',','.').' đ'.'</span> </p>';
                        $total_coupon = $total - $cou['coupon_number'];
                        $output .= '
                        <p class="cart-total-title">Tổng sau giảm: ' . number_format($total_coupon, 0, ',', '.') . ' đ</p>
                    </td>';
                        $output .= '
                </tr>';
                    }
                }
            }

            $output .= '
        <tr>';
            $customer = Session::get('customer');
            if ($customer) {
                $output .= '
                <td colspan="6">
                    <a class="btn btn-danger check_out w-100 p-2"  href="' . url('/thu-tuc-thanh-toan') . '"> Thanh toán</a> 
                </td>';
            } else {
                $output .= '
                <td colspan="6">
                    <a class="btn btn-danger check_out w-100 p-2"  href="' . url('/thu-tuc-thanh-toan') . '"> Thanh toán</a> 
                </td>';
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

    public function xoa_gio_hang(Request $request)
    {
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $request->delete_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
        }
    }

    public function cap_nhat_gio_hang(Request $request){
        $session_id = $request->session_id;
        $qty = $request->qty;
        $carts = Session::get('cart');
        foreach ($carts as $key => $cart) {
            if ($session_id == $cart['session_id']) {
                $carts[$key]['food_qty'] = $qty;
            }
        }
        Session::put('cart', $carts);
    }

    public function chi_tiet_gio_hang(){
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        return view('pages.Cart.cart_user')->with(compact('config_web_logo', 'config_web'));
    }

}
