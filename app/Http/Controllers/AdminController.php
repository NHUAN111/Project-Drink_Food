<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Order;
use App\Models\OrderDetail;

class AdminController extends Controller
{
    public function index(){
        if(isset($_COOKIE['admin_email']) && isset($_COOKIE['admin_pass'])){
            $admin_email = $_COOKIE['admin_email'];
            $admin_pass = $_COOKIE['admin_pass'];

            $result = Admin::check_login($admin_email, $admin_pass);
            if($result){
                Session::put('admin_name', $result->admin_name);
                Session::put('admin_id', $result->admin_id);
                Toastr::success('Đăng nhập bằng cookie thành công', 'Thông báo !');
                return view('Admin.dashboard');
            }else{
                return Redirect::to('/login-admin');
            }
        }else{
            return Redirect::to('/login-admin');
        }
    }

    public function login_admin(){
        return view('Admin.login_admin');
    }

    public function login_check(Request $request){
        $data = $request->all();

        $admin_email = $data['admin_email'];
        $admin_pass = md5($data['admin_pass']);
        $remember = $request->remember;

        // $login = Login::where('admin_email', $admin_email)->where('admin_pass', $admin_pass)->first();
        $login = Admin::check_login($admin_email, $admin_pass);
        if($login){
            if(isset($remember)){
                if($remember == 'on'){
                    setcookie("admin_email", $admin_email, time() + (60*60*24*7));
                    setcookie("admin_pass", $admin_pass, time() + (60*60*24*7));
                }
            }
            Session::put('admin_name', $login->admin_name);
            Session::put('admin_id', $login->admin_id);
            return Redirect::to('/admin');
        }else{
            Toastr::warning('Email hoặc mật khẩu không đúng', 'Thông báo');
            return Redirect::to('/login-admin');
        }
    }

    
    public function signout_admin(){
        Session::forget('admin_password');
        Session::forget('admin_email');
        // Session::flush();
        setcookie("admin_email", null, time() + -100);
        setcookie("admin_pass", null, time() + -100);
        return view('Admin.login_admin');
    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $order = OrderDetail::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_details_id', 'DESC')->get();
        foreach($order as $key => $v_order){
            
            $order_code = $v_order->order_code;
        }

    }
}
