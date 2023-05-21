<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Slider;
use App\Models\City;
use App\Models\FeeShip;
use App\Models\Pronvice;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Wards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;


class ReponsitoryAPIController extends Controller
{
    public function getAll_customer()
    {
        $customers = Customers::get();
        if ($customers->count() > 0) {
            foreach ($customers as $key => $value) {
                $all_customer[] = array(
                    "customer_id" => $value->customer_id,
                    "customer_name" => $value->customer_name,
                    "customer_email" => $value->customer_email,
                    "customer_pass" => $value->customer_pass
                );
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_customer
            ]);
        }
    }

    public function getAll_category()
    {
        $category = Category::get();
        if ($category->count() > 0) {
            foreach ($category as $key => $value) {
                $all_category[] = array(
                    "category_id" => $value->category_id,
                    "category_name" => $value->category_name,
                    "category_img" => "http://192.168.43.45/DACN-Web/public/upload/TheLoai/" . $value->category_img,
                    "category_status" => $value->category_status
                );
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_category
            ]);
        }
    }

    public function getAll_food()
    {
        $new_food = Food::where('food_condition', 0)->orderBy('food_id', 'desc')->take(4)->get();
        $id_new_food = $new_food->pluck('food_id')->toArray();


        $foods = Food::where('food_condition', 0)->whereNotIn('food_id', $id_new_food)->take(10)->get();
        $foodIds = $foods->pluck('food_id')->toArray();
        $order_detail = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->whereIn('food_id', $foodIds)
            ->groupBy('food_id')
            ->limit(10)
            ->orderBy('total_orders', 'DESC')
            ->get();
        $orders = 0;

        if ($foods->count() > 0) {
            foreach ($foods as $key => $value) {
                $orders = 0;
                foreach ($order_detail as $key => $v_order_detail) {
                    if ($v_order_detail->food_id == $value->food_id) {
                        $orders = $v_order_detail->total_orders;
                    }
                }
                $all_food[] = array(
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_desc" => $value->food_desc,
                    "food_content" => $value->food_content,
                    "food_price" => $value->food_price,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_condition" => $value->food_condition,
                    "food_number" => $value->food_number,
                    "food_status" => $value->food_status,
                    "total_orders" => $orders
                );
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_food
            ]);
        }
    }



    public function getNew_food()
    {
        $new_food = Food::where('food_condition', 0)->orderBy('food_id', 'desc')->take(4)->get();
        $foodIds = $new_food->pluck('food_id')->toArray();
        $best = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->whereIn('food_id', $foodIds)
            ->groupBy('food_id')
            ->orderBy('total_orders', 'DESC')
            ->limit(4)
            ->get();
        $all_food = [];

        $orders = 0;
        if ($new_food->count() > 0) {
            foreach ($new_food as $key => $value) {
                $orders = 0;
                foreach ($best as $bestKey => $bestValue) {
                    if ($bestValue->food_id == $value->food_id) {
                        $orders = $bestValue->total_orders;
                        break;
                    }
                }
                $all_food[] = [
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_price" => $value->food_price,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_status" => $value->food_status,
                    "total_orders" => $orders
                ];
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_food
            ]);
        }
    }

    // public function getBestseller_food()
    // {
    //     $bestsellers = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
    //         ->groupBy('food_id')
    //         ->orderBy('total_orders', 'DESC')
    //         ->get();

    //     $foodIds = $bestsellers->pluck('food_id')->toArray();
    //     $totalOrders = $bestsellers->pluck('total_orders', 'food_id')->toArray();

    //     $bestseller_food = Food::whereIn('id', $foodIds)
    //         ->orderByRaw("FIELD(id, " . implode(",", $foodIds) . ")")
    //         ->get();

    //     $all_bestseller_food = [];

    //     foreach ($bestseller_food as $key => $value) {
    //         $all_bestseller_food[] = array(
    //             "food_id" => $value->id,
    //             "category_id" => $value->category_id,
    //             "food_name" => $value->food_name,
    //             "food_price" => $value->food_price,
    //             "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
    //             "food_status" => $value->food_status,
    //             "total_orders" => $totalOrders[$value->id]
    //         );
    //     }

    //     return response()->json([
    //         "message" => "ok",
    //         "status_code" => 200,
    //         "data" => $all_bestseller_food
    //     ]);
    // }




    public function getBestseller_food()
    {
        $bestsellers = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->groupBy('food_id')
            ->orderBy('total_orders', 'DESC')
            ->get();

        $foodIds = $bestsellers->pluck('food_id')->toArray();
        $totalOrders = $bestsellers->pluck('total_orders', 'food_id')->toArray();

        $bestseller_food = Food::whereIn('food_id', $foodIds)
            ->where('food_condition', 0)
            ->limit(4)
            ->get();

        $all_bestseller_food = [];
        foreach ($bestseller_food as $key => $value) {
            $all_bestseller_food[] = array(
                "food_id" => $value->food_id,
                "category_id" => $value->category_id,
                "food_name" => $value->food_name,
                "food_price" => $value->food_price,
                "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                "food_status" => $value->food_status,
                "total_orders" => $totalOrders[$value->food_id]
            );
        }

        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_bestseller_food
        ]);
    }



    public function getDiscount_food()
    {
        $discount_food = Food::whereIn('food_condition', [1, 2])->get();
        $foodIds = $discount_food->pluck('food_id')->toArray();
        $order_detail = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->whereIn('food_id', $foodIds)
            ->groupBy('food_id')
            ->orderBy('total_orders', 'DESC')
            ->limit(4)
            ->get();


        $orders = 0;
        foreach ($discount_food as $key => $value) {
            $food_price = 0;
            if ($value->food_condition == 1) {
                $food_sale = ($value->food_price * $value->food_number) / 100;
                $food_price = $value->food_price - $food_sale;
            } else {
                $food_price = $value->food_price - $value->food_number;
            }

            foreach ($order_detail as $key => $totalOrder) {
                $orders = 0;
                if ($value->food_id == $totalOrder->food_id) {
                    $orders = $totalOrder->total_orders;
                    break;
                }
            }
            if ($discount_food->count() > 0) {
                $all_food[] = array(
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_price" =>  $food_price,
                    "food_condition" => $value->food_condition,
                    "food_number" => $value->food_number,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_status" => $value->food_status,
                    "total_orders" => $orders
                );
            }
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_food
        ]);
    }

    public function getDetail_Food()
    {
        $food = Food::get();
        foreach ($food as $key => $value) {
            $food_price = 0;
            if ($value->food_condition == 1) {
                $food_sale = ($value->food_price * $value->food_number) / 100;
                $food_price = $value->food_price - $food_sale;
            } else {
                $food_price = $value->food_price - $value->food_number;
            }
            if ($food->count() > 0) {
                $all_food[] = array(
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_price" =>  $food_price,
                    "food_condition" => $value->food_condition,
                    "food_number" => $value->food_number,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_status" => $value->food_status
                );
            }
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_food
        ]);
    }

    public function get_coupon()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon_time = Coupon::where('coupon_end', '>=', $today)->where('coupon_qty', '>', 0)->take(3)->get();
        foreach ($coupon_time as $key => $value) {
            if ($coupon_time->count() > 0) {
                $all_coupon[] = array(
                    "coupon_name" => $value->coupon_name,
                    "coupon_code" => $value->coupon_code,
                    "coupon_number" => $value->coupon_number,
                    "coupon_condition" => $value->coupon_condition,
                    "coupon_start" => $value->coupon_start,
                    "coupon_end" => $value->coupon_end
                );
            }
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_coupon
        ]);
    }

    public function same_Food(Request $request)
    {
        $detail_food = Food::where('food_id', $request->food_id)->first();

        $similarly_food = Food::where('category_id', $detail_food->category_id)
            ->where('food_condition', 0)
            ->whereNotIn('food_id', [$detail_food->food_id])
            ->get();

        $foodIds = $similarly_food->pluck('food_id')->toArray();
        $order_detail = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->whereIn('food_id', $foodIds)
            ->groupBy('food_id')
            ->orderBy('total_orders', 'DESC')
            ->get();


        $orders = 0;
        if ($similarly_food->count() > 0) {
            foreach ($similarly_food as $key => $value) {
                $orders = 0;
                foreach ($order_detail as $v_order_detail) {
                    if ($v_order_detail->food_id == $value->food_id) {
                        $orders = $v_order_detail->total_orders;
                        break;
                    }
                }
                $all_food[] = array(
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_price" =>   $value->food_price,
                    "food_condition" => $value->food_condition,
                    "food_number" => $value->food_number,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_status" => $value->food_status,
                    "total_orders" => $orders
                );
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_food
            ]);
        } else {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }
    }


    public function getCategoryById(Request $request)
    {
        $food_by_category = Food::where('category_id', $request->category_id)
            ->where('food_condition', 0)
            ->get();


        $foodIds = $food_by_category->pluck('food_id')->toArray();
        $order_detail = OrderDetail::select('food_id', DB::raw('count(*) as total_orders'))
            ->whereIn('food_id', $foodIds)
            ->groupBy('food_id')
            ->orderBy('total_orders', 'DESC')
            ->get();

        $orders = 0;
        if ($food_by_category->count() > 0) {
            foreach ($food_by_category as $key => $value) {
                $orders = 0;
                foreach ($order_detail as $v_order_detail) {
                    if ($v_order_detail->food_id == $value->food_id) {
                        $orders = $v_order_detail->total_orders;
                        break;
                    }
                }
                $all_food[] = array(
                    "food_id" => $value->food_id,
                    "category_id" => $value->category_id,
                    "food_name" => $value->food_name,
                    "food_price" =>   $value->food_price,
                    "food_condition" => $value->food_condition,
                    "food_number" => $value->food_number,
                    "food_img" => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $value->food_img,
                    "food_status" => $value->food_status,
                    "total_orders" => $orders
                );
            }
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $all_food
            ]);
        } else {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }
    }


    public function register(Request $request)
    {
        $result = Customers::where('customer_email', $request->customer_email)->first();
        if ($result) {
            return response()->json([
                "message" => "email already exist",
                "status_code" => 202,
                "data" => null
            ]);
        } else {
            $customer = new Customers();
            $customer->customer_name = $request->customer_name;
            $customer->customer_pass =  md5($request->customer_pass);
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->save();
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => null
            ]);
        }
    }

    public function login(Request $request)
    {
        $result = Customers::where('customer_name', $request->customer_name)->where('customer_pass', md5($request->customer_pass))->first();
        if ($result) {
            $info_customer[] = array(
                "customer_id" => $result->customer_id,
                "customer_name" => $result->customer_name,
                "customer_email" => $result->customer_email,
                "customer_pass" => $result->customer_pass,
                "customer_phone" => $result->customer_phone
            );
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $result
            ]);
        } else {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }
    }

    public function get_slider()
    {
        $slider = Slider::get();
        foreach ($slider as $value) {
            if ($slider->count() > 0) {
                $all_slider[] = array(
                    "slider_img" => "http://192.168.43.45/DACN-Web/public/upload/slider/" . $value->slider_img,
                );
            }
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_slider
        ]);
    }

    public function get_city()
    {
        $name_tp = City::whereIn('matp', [48, 49])->get("name_city");
        $name_city = $name_tp->toArray();

        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $name_city
        ]);
    }

    public function get_pronvice(Request $request)
    {
        $id_city = City::where('name_city', $request->name_city)->pluck('matp')->first();

        if (!$id_city) {
            return response()->json([
                "message" => "City not found",
                "status_code" => 404,
            ]);
        }

        $name_qh = Pronvice::where('matp', $id_city)->get('name_quanhuyen');
        $name_province = $name_qh->toArray();

        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $name_province
        ]);
    }

    public function get_ward(Request $request)
    {
        $id_pronvice = Pronvice::where("name_quanhuyen", $request->name_province)->pluck('maqh')->first();

        if (!$id_pronvice) {
            return response()->json([
                "message" => "Province not found",
                "status_code" => 404,
            ]);
        }

        $name_xa = Wards::where('maqh', $id_pronvice)->get("name_xaphuong");
        $name_wards = $name_xa->toArray();

        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $name_wards
        ]);
    }


    public function info_orders(Request $request)
    {
        $order = Order::where("customer_id", $request->customer_id)->orderBy('order_id', 'DESC')->get();
        if ($order->count() === 0) {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }

        foreach ($order as $value) {
            $data_order_detail = null;
            // Get order detail
            $order_detail = OrderDetail::where('order_code', $value->order_code)->get();
            $food = Food::get();
            foreach ($order_detail as $v_order_detail) {
                $total = 0;
                $subtotal = $v_order_detail->food_price * $v_order_detail->food_sales_quantity;
                $total += $subtotal;
                $food_img = null;
                foreach ($food as $v_food) {
                    if ($v_food->food_id == $v_order_detail->food_id) {
                        $food_img = $v_food->food_img;
                        break;
                    }
                }

                if ($v_order_detail->order_code == $value->order_code) {
                    $data_order_detail[] = array(
                        'order_code' => $v_order_detail->order_code,
                        'food_name' => $v_order_detail->food_name,
                        'food_price' => $v_order_detail->food_price,
                        'food_sales_quantity' => $v_order_detail->food_sales_quantity,
                        'food_img' => "http://192.168.1.6/DACN-Web/public/upload/MonAn/".$food_img,
                        'total_price' => $total
                    );
                }
            }

            // Get shipping 
            $data_shipping = null;
            $shipping_detail = Shipping::where('shipping_id', $value->shipping_id)->get();
            foreach ($shipping_detail as $v_shipping_detail) {
                if ($v_shipping_detail->shipping_id == $value->shipping_id) {
                    $data_shipping = array(
                        'shipping_id' => $v_shipping_detail->shipping_id,
                        'shipping_name' => $v_shipping_detail->shipping_name,
                        'shipping_phone' => $v_shipping_detail->shipping_phone,
                        'shipping_address' => $v_shipping_detail->shipping_address
                    );
                }
            }

            // Get payment
            $data_payment = null;
            $payment_detail = Payment::where('payment_id', $value->payment_id)->get();
            foreach ($payment_detail as $v_payment_detail) {
                if ($v_payment_detail->payment_id == $value->payment_id) {
                    $data_payment = array(
                        'payment_method' => $v_payment_detail->payment_method,
                        'payment_status' => $v_payment_detail->payment_status
                    );
                }
            }

            $all_order[] = array(
                "order_code" => $value->order_code,
                "order_coupon" => $value->order_coupon,
                "order_feeship" => $value->order_feeship,
                "coupon_price" => $value->order_price,
                "customer_id" => $value->customer_id,
                "shipping_id" => $value->shipping_id,
                "payment_id" => $value->payment_id,
                "order_status" => $value->order_status,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                "order_detail" => $data_order_detail,
                "shipping_detail" => $data_shipping,
                "payment_detail" => $data_payment
            );
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $all_order
        ]);
    }

    public function cancel_order(Request $request)
    {
        $order = Order::where("order_code", $request->order_code)->pluck('order_code')->first();

        if (!$order) {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }


        if ($order) {
            Order::where('order_code', $order)
                ->update(['order_status' => 2]);
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => null
            ]);
        }
    }

    public function get_order_detail(Request $request)
    {
        $order_detail = OrderDetail::where("order_code", $request->order_code)->get();
        if ($order_detail->count() === 0) {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }

        $order = Order::where("order_code", $request->order_code)->first();
        $data_order = array(
            'order_feeship' => $order->order_feeship,
            'coupon_price' => $order->coupon_price,
            'order_coupon' => $order->order_coupon,
            'created_at' => $order->created_at
        );

        $shipping = Shipping::where("shipping_id", $order->shipping_id)->first();
        $data_shipping = array(
            'shipping_id' => $shipping->shipping_id,
            'shipping_name' => $shipping->shipping_name,
            'shipping_phone' => $shipping->shipping_phone,
            'shipping_address' => $shipping->shipping_address
        );


        $food = Food::get();
        foreach ($order_detail as $v_order_detail) {
            $food_img = null;
            foreach ($food as $v_food) {
                if ($v_food->food_id == $v_order_detail->food_id) {
                    $food_img = $v_food->food_img;
                    break;
                }
            }
            $total = 0;
            $subtotal = $v_order_detail->food_price * $v_order_detail->food_sales_quantity;
            $total += $subtotal;
            $data_order_detail[] = array(
                'order_code' => $v_order_detail->order_code,
                'food_name' => $v_order_detail->food_name,
                'food_price' => $v_order_detail->food_price,
                'food_sales_quantity' => $v_order_detail->food_sales_quantity,
                'food_img' => "http://192.168.43.45/DACN-Web/public/upload/MonAn/" . $food_img,
                'total_price' => $total,
                'order' => $data_order,
                'data_shipping' => $data_shipping
            );
        }
        return response()->json([
            "message" => "ok",
            "status_code" => 200,
            "data" => $data_order_detail
        ]);
    }

    public function shipping_fee(Request $request)
    {
        $address = $request->shipping_address;
        // $address = 'An, Phường Hòa Hiệp Bắc, Quận Liên Chiểu, Thành phố Đà Nẵng';
        $array_address = explode(", ", $address);

        $ward = Wards::where('name_xaphuong', $array_address[1])->pluck('xaid')->first();
        $pronvice = Pronvice::where('name_quanhuyen', $array_address[2])->pluck('maqh')->first();
        $city = City::where('name_city', $array_address[3])->pluck('matp')->first();
        // echo $ward;
        // echo '<br>';
        // echo $pronvice;
        // echo '<br>';
        // echo $city;

        $fee_ship = FeeShip::where('fee_matp', $city)->where('fee_maqh', $pronvice)->where('fee_xaid', $ward)->pluck('fee_feeship')->first();

        if ($fee_ship == null) {
            $data_fee_ship = array(
                'fee_feeship' => 21000
            );
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => $data_fee_ship
            ]);
        } else {
            $data_fee_ship = array(
                'fee_feeship' => $fee_ship
            );
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $data_fee_ship
            ]);
        }
    }


    public function check_coupon(Request $request)
    {
        // 1 : %
        // 2 : đ
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        $coupon_code = Coupon::where('coupon_code', $request->coupon_code)
            ->where('coupon_end', '>=', $today)
            ->where('coupon_qty', '>', 0)->first();

        if ($coupon_code == null) {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        } else {
            $data_coupon[] = array(
                "coupon_name" => $coupon_code->coupon_name,
                "coupon_code" => $coupon_code->coupon_code,
                "coupon_number" => $coupon_code->coupon_number,
                "coupon_condition" => $coupon_code->coupon_condition,
                "coupon_start" => $coupon_code->coupon_start,
                "coupon_end" => $coupon_code->coupon_end
            );
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => $data_coupon
            ]);
        }
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


    public function order(Request $request)
    {
        $order_code = 'TAT' . rand(00001, 99999);
        // Save shipping
        $shipping = new Shipping();
        $shipping->shipping_name = $request->customer_name;
        $shipping->shipping_phone = $request->customer_phone;
        $shipping->shipping_address = $request->customer_address;
        $shipping->shipping_email = $request->customer_email;
        $shipping->shipping_notes = null;
        $shipping->save();

        // Save payment method
        $payment = new Payment();
        $payment->payment_method = $request->payment_method;
        $payment->payment_status = 0;
        $payment->save();

        // Save order
        $order = new Order();
        $order->order_code = $order_code;
        $order->order_coupon = $request->order_coupon;
        $order->coupon_price = $request->coupon_price;
        $order->order_feeship = $request->order_feeship;
        $order->customer_id = $request->customer_id;
        $order->shipping_id = $shipping->shipping_id;
        $order->payment_id = $payment->payment_id;
        $order->order_status = 0; //Chưa duyệt đơn
        $order->save();

        // Save order detail
        // $cartList = $request->input('cart');
        $cartList = $request->cart;
        $data = json_decode($cartList, true);
        foreach ($data  as $v_cartList) {
            $order_detail = new OrderDetail();
            $order_detail->order_code = $order_code;
            $order_detail->food_id = $v_cartList['idFood'];
            $order_detail->food_name = $v_cartList['nameFood'];
            $order_detail->food_price = $v_cartList['priceFood'];
            $order_detail->food_sales_quantity = $v_cartList['qtyFood'];
            $order_detail->save();
        }

        if ($request->order_coupon != null) {
            $coupon = Coupon::where('coupon_code', $request->order_coupon)->first(); // Lấy thông tin coupon từ mã giảm giá
            if ($coupon) {
                $coupon_qty = $coupon->coupon_qty; // Lấy số lượng hiện tại của coupon
                $coupon->update(['coupon_qty' => $coupon_qty - 1]); // Giảm số lượng coupon đi 1
            }
        }
        $this->sendMail();

        if ($request->customer_name) {
            return response()->json([
                "message" => "ok",
                "status_code" => 200,
                "data" => null
            ]);
        } else {
            return response()->json([
                "message" => "fail",
                "status_code" => 202,
                "data" => null
            ]);
        }
    }

}
