<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller     
{
    public function all_customers(){
        $all_customers = Customers::orderBy('customer_id', 'desc')->get();
        return view("Admin.Customer.all_customers")
        ->with(compact('all_customers'));
    }

    public function delete_customers(Request $request){
        $customer_id = Customers::find($request->customer_id);
        $customer_id->delete();
        return Redirect::to('/admin/customer/all-customers');
    }
}