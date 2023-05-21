<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\ConfigWeb;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\Slider;
use App\Models\Customers;
use App\Models\Order;
use App\Models\OrderDetail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function detail_food(Request $request){
        $food_id = $request->food_id;
        $detail_food = Food::where('food_id', $food_id)->first();

        $similarly_food = Food::where('category_id', $detail_food->category->category_id)->where('food_condition', 0)->whereNotIn('food_id', [$detail_food->food_id])->get();
        // dd($similarly_food);
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.Food.food_detail')->with(compact('config_web', 'config_web_logo', 'detail_food', 'similarly_food'));
    }
    

    public function index()
    {
        $meta = array(
            'title' => 'Trang Chủ',
            'description' => 'Trùm Ẩm Thực - Trang Tìm Kiếm Và Đặt Thức Uống Và Đồ Ăn Nhanh',
            'keywords' => 'Trùm Ẩm Thực, Đặt Món Ăn Nhanh',
            'canonical' => request()->url(),
            // 'sitename' => 'nhuandeptraivanhanbro.doancoso2.laravel.vn',
            'image' => '',
        );

        $category = new Category();
        $all_category = $category->all_category_hien();

        $food = new Food();
        $new_food = $food->where('food_status', 0)->where('food_condition', 0)->orderby('food_id', 'desc')->take(4)->get();
        $all_food_sale = $food->where('food_status', 0)->whereNotIn('food_condition', [0])->get();

        $slider = new Slider();
        $all_slider = $slider->orderBy('slider_id', 'asc')->take(6)->get();

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon_time = Coupon::where('coupon_end', '>=', $today)->where('coupon_qty', '>', 0)->take(3)->get();

        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

        $bestseller = OrderDetail::get();
        $array = array();
        foreach ($bestseller as $key => $v_bestseller){
            $array[$key] = $v_bestseller->food_id;
        }
        $result = array_count_values($array); // Lấy ra key của food_id và value = số lần xuất hiện trong bảng
        arsort($result); //Hàm sắp xếp giảm dần
        $keys = array_keys($result);
        $food_id = array_slice($keys, 0, 4);

        $bestseller_food = Food::whereIn('food_id', $food_id)->where('food_condition', 0)->get(); //Lấy ra 4 sản phẩm theo thứ tự giảm dần theo số lần xuất hiện trong bảng


        if (isset($_COOKIE['customer_email']) && isset($_COOKIE['customer_pass'])) {
            $customer_email = $_COOKIE['customer_email'];
            $customer_pass = $_COOKIE['customer_pass'];

            $result = Customers::check_login($customer_email, $customer_pass);
            if ($result) {
                $customer = array(
                    'customer_id' => $result->customer_id,
                    'customer_name' => $result->customer_name,
                    'customer_phone' => $result->customer_phone,
                );
                session()->put('customer', $customer);

                Toastr::success('Đăng nhập tự động bằng cookie thành công');
                return view('pages.home')->with(compact('all_category', 'all_slider', 'new_food', 'all_food_sale', 'meta', 'coupon_time', 'config_web_logo', 'config_web', 'bestseller_food'));
            } else {
                return Redirect::to('/trang-chu');
            }
        } else {
            return Redirect::to('/trang-chu');
        }
    }

    public function index_home()
    {
        $meta = array(
            'title' => 'Trang Chủ',
            'description' => 'Trùm Ẩm Thực - Trang Tìm Kiếm Và Đặt Thức Uống Và Đồ Ăn Nhanh',
            'keywords' => 'Trùm Ẩm Thực, Đặt Món Ăn Nhanh',
            'canonical' => request()->url(),
            // 'sitename' => 'nhuandeptraivanhanbro.doancoso2.laravel.vn',
            'image' => '',
        );
        $category = new Category();
        $all_category = $category->all_category_hien();

        $food = new Food();
        $new_food = $food->where('food_status', 0)->where('food_condition', 0)->orderby('food_id', 'desc')->take(4)->get();
        $all_food_sale = $food->where('food_status', 0)->whereNotIn('food_condition', [0])->get();

        $slider = new Slider();
        $all_slider = $slider->orderBy('slider_id', 'asc')->take(6)->get();

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon_time = Coupon::where('coupon_end', '>=', $today)->where('coupon_qty', '>', 0)->take(3)->get();

        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

        $bestseller = OrderDetail::get();
        $array = array();
        foreach ($bestseller as $key => $v_bestseller){
            $array[$key] = $v_bestseller->food_id;
        }
        $result = array_count_values($array); // Lấy ra key của food_id và value = số lần xuất hiện trong bảng
        arsort($result); //Hàm sắp xếp giảm dần
        $keys = array_keys($result);
        $food_id = array_slice($keys, 0, 4); //Lấy ra 4 sản phẩm

        $bestseller_food = Food::whereIn('food_id', $food_id)->where('food_condition', 0)->get(); //Lấy ra 4 sản phẩm theo thứ tự giảm dần theo số lần xuất hiện trong bảng

        return view('pages.home')->with(compact('all_category', 'all_slider', 'all_food_sale', 'new_food', 'meta', 'coupon_time', 'config_web_logo', 'config_web', 'bestseller_food'));
    }

    public function load_more_food(Request $request)
    {
        $data = $request->all();
        if ($data['id'] > 0) {
            $all_food = Food::where('food_status', 0)
            ->where('food_condition', 0)
            ->where('food_id', '<', $data['id'])
            ->orderBy('food_id', 'desc')->take(5)->get(); //Sản phẩm khi bấm load more
        } else {
            $all_food = Food::where('food_status', 0)
            ->where('food_condition', 0)
            ->orderBy('food_id', 'desc')->take(5)->get(); //Tất cả sản phẩm khi chưa load more
        }
        $output = '';
        if (!$all_food->isEmpty()) {
            foreach ($all_food as $key => $value_food) {
                $last_id = $value_food->food_id;
                $output .= '
        <div class="col-6 col-md-4">
            <div class="card">
                <a href="'.URL('/chi-tiet-mon?food_id='.$value_food->food_id).'" class="kham-pha-thuc-don-link item-food">
                    <form>
                        ' . csrf_field() . '
                        <input type="hidden" class="cart_food_id_' . $value_food->food_id . ' "
                            value="' . $value_food->food_id . '">
                        <input type="hidden" class="cart_food_name_' . $value_food->food_id . '"
                            value="' . $value_food->food_name . '">
                        <input type="hidden" class="cart_food_price_' . $value_food->food_id . '"
                            value="' . $value_food->food_price . '">
                        <input type="hidden" class="cart_food_img_' . $value_food->food_id . '"
                            value="' . $value_food->food_img . '">
                        <input type="hidden" class="cart_food_qty_' . $value_food->food_id . '" 
                            value="1">
                    </form>
                    <img src="public/upload/MonAn/' . $value_food->food_img . '" style="height: 230px; object-fit: cover;" class="card-img-top ">
                    </a>
                
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1rem;
                        line-height: 1rem;
                        color: #000;
                        font-weight: bold;
                        height: 36px;">' . $value_food->food_name . '</h5>
                        <p class="card-text" style="font-weight: 400; color: #000" name="price ">' . number_format($value_food->food_price, 0, ',', '.') . ' đ</p>
                        <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="' . $value_food->food_id . '" >Chọn mua</button>
                    </div>
            </div>
        </div>';
            }
            $output .= '
            <div class="col-12 col-md-12 text-center col-lg-12 text-md-center text-lg-center" id="btn-load">
                <button class="btn btn-danger px-5" data-id="' . $last_id . '" id="btn-load-more">
                    <span class="text-center">Tải thêm</span>
                </button>
            </div>';
        } else {
            $output .= '
            <div class="col-12 col-md-12 text-center col-lg-12 text-md-center text-lg-center" id="btn-load">
                <button class="btn btn-danger">
                    Thực Đơn Sẽ Cập Nhật Thêm
                </button>
            </div>';
        }
        return $output;
    }

    public function check_order()
    {
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.Order.check_order')->with(compact('config_web', 'config_web_logo'));
    }

    public function info_order()
    {
        $customer = Session::get('customer');
        if ($customer) {
            $order = Order::where('customer_id', $customer['customer_id'])->get();
            $order_info_latest = Order::where('customer_id', $customer['customer_id'])
                ->orderBy('order_id', 'desc')->first(); //Đơn mới đặt

            $all_order_info = Order::where('customer_id', $customer['customer_id'])
                ->whereNotIn('order_code', [$order_info_latest->order_code])
                ->orderBy('order_id', 'desc')->get(); //Đơn cũ

            $order_detail = OrderDetail::where('order_code', $order_info_latest->order_code)->get(); //Chi tiết đơn theo order_code

            $config_web_logo = ConfigWeb::where('config_type', 0)->first();
            $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

            return view('pages.Order.info_order')->with(compact('order_info_latest', 'all_order_info', 'order_detail', 'config_web_logo', 'config_web'));
        }else{            
            $order_info_latest = Order::orderBy('order_id', 'desc')->first();

            $order_detail = OrderDetail::where('order_code', $order_info_latest->order_code)->get(); //Chi tiết đơn theo order_code

            $config_web_logo = ConfigWeb::where('config_type', 0)->first();
            $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

            return view('pages.Order.info_order')->with(compact('order_info_latest', 'order_detail', 'config_web_logo', 'config_web'));
        }
    }

    public function order_empty()
    {
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.Order.order_empty')->with(compact('config_web_logo', 'config_web'));
    }

    public function check_info_order(Request $request)
    {
        $data = $request->all();
        $order_info = Order::where('order_code', $data['order_code'])->first();
        if ($order_info) {
            Toastr::success('Tìm thấy đơn hàng của bạn');
            return redirect()->to('/thong-tin-don-hang?order_code=' . $order_info->order_code);
        } else {
            Toastr::error('Không tìm thấy đơn hàng của bạn');
            return redirect()->back();
        }
    }

    public function update_order(Request $request)
    {
        Order::where('order_id', $request->order_id)
            ->update(['order_status' => 2]);
        Toastr::success('Bạn Đã Huỷ Đơn', 'Thành công');
        return redirect()->back();
    }

    public function view_order_old(Request $request)
    {
        $order_code = $request->order_code;
        $order_detail = OrderDetail::where('order_code', $order_code)->get(); //Chi tiết đơn theo order_code
        $output = $this->load_view_order($order_detail);
        echo $output;
    }

    public function load_view_order($order_detail)
    {
        $output = '';
        $fee_ship = 0;
        $total = 0;
        $order_code = '';
        foreach ($order_detail as $key => $v_order_detail) {
            $subtotal = $v_order_detail->food_price * $v_order_detail->food_sales_quantity;
            $total += $subtotal;
            $output .= '
            <tr>
                <td class="align-middle">
                    <img src="' . URL('public/upload/MonAn/' . $v_order_detail->food->food_img) . '" height="40" alt="' . $v_order_detail->food->food_name . '">
                </td>
                <td class="align-middle">' . $v_order_detail->food->food_name . '</td>
                <td class="align-middle">' . $v_order_detail->food_sales_quantity . '</td>
                <td class="align-middle">' . number_format($v_order_detail->food_price,0,',','.') . ' đ</td>';
            $output .= '
                <td class="align-middle">' . number_format($subtotal, 0, ',', '.') . ' đ</td>
            </tr>';
            $order_code = $v_order_detail->order_code;
        }
        // Kiểm Tra Coupon
        $order = Order::where('order_code', $order_code)->first();
        if ($order->order_coupon == 0) {
            $fee_ship = $order->order_feeship;
            $total = $total + $fee_ship;
            $output .= '
                <tr>
                    <th colspan=5>Mã Giảm: Không Có </th>
                </tr>
                <tr>
                    <th colspan=5 >Phí Vận Chuyển: ' . number_format($fee_ship, 0, ',', '.') . ' đ</th>
                </tr>
                <tr>
                    <th colspan=5 class="border-bottom-0">Tổng Đơn: ' . number_format($total, 0, ',', '.') . ' đ</th>
                </tr>';
        } else {
            $fee_ship = $order->order_feeship;
            $coupon_price = $order->coupon_price; // Số tiền giảm
            if ($coupon_price <= 100) { // Theo %
                $total_coupon = ($total * $coupon_price) / 100; //Số Tiền Giảm %
                $total = ($total - $total_coupon) + $fee_ship;
                $output .= '
                <tr>
                    <th colspan=5 >Mã Đơn: ' . $order_code . '</th>
                </tr>
                <tr>
                    <th colspan=2>Mã Giảm: ' . $order->order_coupon . ' </th>
                    <th colspan=3>Số Giảm: ' . $order->coupon_price . ' %</th>
                </tr>
                <tr>
                    <th colspan=5 >Phí Vận Chuyển: ' . number_format($fee_ship, 0, ',', '.') . ' đ</th>
                </tr>
                <tr>
                    <th colspan=5 class="border-bottom-0">Tổng Đơn: ' . number_format($total, 0, ',', '.') . ' đ</th>
                </tr>';
            } else if ($coupon_price > 100) { // Theo Tiền
                $total_coupon = $total - $coupon_price; //Số Tiền Giảm Theo Tiền
                $total = $total_coupon + $fee_ship;
                $output .= '
                <tr>
                    <th colspan=5 >Mã Đơn: ' . $order_code . '</th>
                </tr>
                <tr>
                    <th colspan=2>Mã Giảm: ' . $order->order_coupon . ' </th>
                    <th colspan=3>Số Giảm: ' . number_format($order->coupon_price, 0, ',', '.') . ' đ</th>
                </tr>
                <tr>
                    <th colspan=5 >Phí Vận Chuyển: ' . number_format($fee_ship, 0, ',', '.') . ' đ</th>
                </tr>
                <tr>
                    <th colspan=5 class="border-bottom-0">Tổng Đơn: ' . number_format($total, 0, ',', '.') . ' đ</th>
                </tr>';
            }
        }
        return $output;
    }

    public function load_order_old(Request $request)
    {
        $customer = Session::get('customer');
        if ($customer) {
            $output = '';
            $data = $request->all();
            if ($data['id'] > 0) {
                $all_order_info = Order::where('customer_id', $customer['customer_id'])
                    ->where('order_id', '<', $data['id'])
                    ->orderBy('order_id', 'desc')->take(2)->get(); //Khi bấm load more
            } else {
                $all_order_info = Order::where('customer_id', $customer['customer_id'])
                    ->orderBy('order_id', 'desc')->take(1)->get(); //Dữ liệu khi chưa load more
            }

            // $last_id = 0;
            if (!$all_order_info->isEmpty()) {
                foreach ($all_order_info as $key => $v_order_info) {
                    $last_id = $v_order_info->order_id;
                    $output .= '
                        <tr class="order_old">
                            <th class="align-middle btn-view-order" style="cursor: pointer" data-id="' . $v_order_info->order_code . '" scope="row">
                                <i class="fa-solid fa-eye"></i>
                                ' . $v_order_info->order_code . ' 
                            </th>
                            <td class="align-middle text-address-ship">' . $v_order_info->shipping->shipping_address . '</td>';
                    if ($v_order_info->order_status == 1) {
                        $output .= '<td class="align-middle text-success fw-bold">Đã Duyệt Đơn</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($v_order_info->order_status == 0) {
                        $output .= ' <td class="align-middle text-info fw-bold">Đang Chờ Duyệt</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-cancel-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Huỷ Đơn</a>
                            </td>';
                    } else if ($v_order_info->order_status == 2) {
                        $output .= '<td class="align-middle text-danger fw-bold">Đã Huỷ Đơn</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($v_order_info->order_status == 3) {
                        $output .= '<td class="align-middle text-danger fw-bold">Đơn Bị Từ Chối</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($v_order_info->order_status == 4) {
                        $output .= ' <td class="align-middle text-info fw-bold">Đơn Đã Nhận</td>
                        <td class="align-middle" style=" cursor: pointer;">
                           <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                           <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Xoá Đơn</a>
                        </td>';
                    } 
                    $output .= '
                    </tr>';
                }
                $output .= '
                    <td colspan=5 class="text-center border-bottom-0" id="btn-load-order">
                        <button class="btn btn-danger btn-load-order" data-id="' . $last_id . '" style="background-color: #dc3545; color: #fff">
                            Tải Thêm
                        </button>
                    </td>';
            } else {
                $output .= '
                <tr>
                    <td colspan=5 class="text-center border-bottom-0" id="btn-load-order">
                        <button class="btn btn-danger" style="background-color: #dc3545; color: #fff">
                            Không Còn Dữ Liệu
                        </button>
                    </td>
                </tr>';
            }
            return $output;
        } else {
            $output = ''; 
            $order_info_latest =  Order::orderBy('order_id', 'desc')->first();
            $output .= '
                        <tr class="order_old">
                            <th class="align-middle btn-view-order" style="cursor: pointer" data-id="' . $order_info_latest->order_code . '" scope="row">
                                <i class="fa-solid fa-eye"></i>
                                ' . $order_info_latest->order_code . ' 
                            </th>
                            <td class="align-middle text-address-ship">' . $order_info_latest->shipping->shipping_address . '</td>';
                    if ($order_info_latest->order_status == 1) {
                        $output .= '<td class="align-middle text-success fw-bold">Đã Duyệt Đơn</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $order_info_latest->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($order_info_latest->order_status == 0) {
                        $output .= ' <td class="align-middle text-info fw-bold">Đang Chờ Duyệt</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-cancel-order text-danger fw-bold" data-id="' . $order_info_latest->order_id . '" >Huỷ Đơn</a>
                            </td>';
                    } else if ($order_info_latest->order_status == 2) {
                        $output .= '<td class="align-middle text-danger fw-bold">Đã Huỷ Đơn</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $order_info_latest->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($order_info_latest->order_status == 3) {
                        $output .= '<td class="align-middle text-danger fw-bold">Đơn Bị Từ Chối</td>
                            <td class="align-middle" style=" cursor: pointer;">
                               <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                               <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $order_info_latest->order_id . '" >Xoá Đơn</a>
                            </td>';
                    } else if ($v_order_info->order_status == 4) {
                        $output .= ' <td class="align-middle text-info fw-bold">Đơn Đã Nhận</td>
                        <td class="align-middle" style=" cursor: pointer;">
                           <i class="fa-solid fa-circle-xmark fw-border text-danger"></i>
                           <a style="color: #fff; text-decoration: none;" class="btn-delete-order text-danger fw-bold" data-id="' . $v_order_info->order_id . '" >Xoá Đơn</a>
                        </td>';
                    } 
            return $output;
        }
    }

    public function cancel_order(Request $request)
    {
        $order_id = $request->order_id;
        Order::where('order_id', $order_id)->update(['order_status' => 2]);
    }

    public function delete_order(Request $request)
    {
        $order_id = $request->id;
        $order = Order::find($order_id);
        $order->delete();
    }
}
