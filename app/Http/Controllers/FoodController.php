<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ConfigWeb;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;

class FoodController extends Controller
{
    public function add_food()
    {
        $category = new Category();
        $all_category = $category->all_category();

        return view('Admin.Food.add_food')
            ->with('all_category', $all_category);
    }

    public function save_food(Request $request)
    {
        $data = $request->all();
        $food = new Food();

        $food->food_name = $data['food_name'];
        $food->category_id = $data['food_category'];
        $food->food_desc = $data['food_desc'];
        $food->food_content = $data['food_content'];
        $food->food_price = $data['food_price'];
        $food->food_img = $data['food_img'];
        $food->food_status = $data['food_status'];
        $food->food_condition = $data['food_condition'];
        if ($food->food_condition == 0) {
            $food->food_number = 0;
        } else {
            $food->food_number = $data['food_number'];
        }

        $get_image = $request->file('food_img');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/MonAn', $new_image);
            $data['food_img'] = $new_image;
            $food['food_img'] = $data['food_img'];
        } else {
            $food['food_img'] = '';
        }
        $data['food_img'] = '';
        $food->save();
        Toastr::success('Thêm món thành công', 'Thành công');
        return Redirect::to('/admin/food/all-food');
    }

    public function all_food()
    {
        $all_food = Food::paginate(8);

        $manager_all_food = view('Admin.Food.all_food')
            ->with('all_food', $all_food);

        return view('admin.admin_layout')
            ->with('all_food', $manager_all_food);
    }

    public function all_food_sale()
    {
        $all_food_sale = Food::whereNotIn('food_condition', [0])->get();

        $manager_all_food_sale = view('Admin.FoodSale.all_food_sale')
            ->with('all_food_sale', $all_food_sale);

        return view('admin.admin_layout')
            ->with('all_food_sale', $manager_all_food_sale);
    }

    public function all_food_combo(){
        $all_food_sale = Food::whereNotIn('food_condition', [0])->get();

        $manager_all_food_sale = view('Admin.FoodSale.all_food_sale')
            ->with('all_food_sale', $all_food_sale);

        return view('admin.admin_layout')
            ->with('all_food_sale', $manager_all_food_sale);
    }

    public function hien_mon_an(Request $request)
    {
        Food::where('food_id', $request->food_id)
            ->update(['food_status' => 0]);
        Toastr::success('Kích hoạt hiển thị thành công', 'Thành công');
        return Redirect::to('/admin/food/all-food');
    }

    public function an_mon_an(Request $request)
    {
        Food::where('food_id', $request->food_id)
            ->update(['food_status' => 1]);
        Toastr::success('Không hiển thị món thành công', 'Thành công');
        return Redirect::to('/admin/food/all-food');
    }

    public function delete_food(Request $request)
    {
        $data = $request->delete_id;
        $food = Food::find($data);
        $food->delete();
    }

    public function edit_food(Request $request)
    {
        $category = new Category();
        $all_category = $category->all_category();

        $edit_food = Food::find($request->food_id);
        $manager_food = view('Admin.Food.edit_food')
            ->with('edit_food', $edit_food)
            ->with('all_category', $all_category);

        return view('admin.admin_layout')
            ->with('edit_food', $manager_food);
    }

    public function update_food(Request $request)
    {
        $data = $request->all();
        $food = Food::find($data['food_id']);

        $food->food_name = $data['food_name'];
        $food->category_id = $data['food_category'];
        $food->food_desc = $data['food_desc'];
        $food->food_content = $data['food_content'];
        $food->food_price = $data['food_price'];
        $food->food_status = $data['food_status'];
        $food->food_condition = $data['food_condition'];
        if ($food->food_condition == 0) {
            $food->food_number = 0;
        } else {
            $food->food_number = $data['food_number'];
        }

        $get_image = $request->file('food_img');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/MonAn', $new_image);
            $data['food_img'] = $new_image;
            $food['food_img'] = $data['food_img'];
        }
        $food->save();
        Toastr::success('Cập nhật món thành công', 'Thành công !');
        return Redirect::to('/admin/food/all-food');
    }

    public function load_food(){
        $output = '';
        $all_food = Food::orderBy('food_id', 'desc')->paginate(8);
        $i = 0;
        foreach ($all_food as $key => $value_food){
            if($value_food->food_condition == 0){
                $output .= '
                    <tr class="table">
                        <td scope="row">'.++$i.'</td>
                        <td>'. $value_food->food_name.'</td>
                        <td>
                            <img src="'. URL('public/upload/MonAn/'. $value_food->food_img).'" alt="'.$value_food->food_name.'"
                                style="width: 50px; height: 50px; object-fit: cover">
                        </td>
                        <td>'.number_format($value_food->food_price, 0, ',', '.').'đ</td>
                        <td>'.$value_food->category->category_name.'</td>
                        <td>';
                            if($value_food->food_status == 0){    
                        $output .='
                            <a href="'.URL('/admin/food/unactive-food?food_id=' .$value_food->food_id).'"><i class="mdi mdi-lock-open" style="color: #46c35f; font-size: 1.2rem;"></i></a>';
                            }else{
                        $output .='
                            <a href="'.URL('/admin/food/active-food?food_id='. $value_food->food_id) .'"><i class="mdi mdi-lock" style="color: #f96868; font-size: 1.2rem"></i></a>';
                            }
                        $output .='
                        </td>
                        <td>
                            <div>
                                <a class="delete-food" data-food_id='.$value_food->food_id.'>
                                    <i class="mdi mdi-delete"
                                        style="color: #f96868; margin-right: 10px; font-size: 1.2rem"></i>
                                </a>
                                <a href="'.URL('/admin/food/edit-food?food_id=' . $value_food->food_id).'">
                                    <i class="mdi  mdi-open-in-new" style="color: #1bcfb4;  margin-right: 10px; font-size: 1.2rem"></i>
                                </a>
                                <a href="'. URL('/admin/food/detail-food?food_id=' . $value_food->food_id).'">
                                    <i class="mdi mdi-information" style="color: #57c7d4; font-size: 1.2rem;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>';
                }
            }
        return $output;
    }
    
    public function all_food_home()
    {
        $meta = array(
            'title' => 'Thực Đơn Quán',
            'description' => 'Trùm Ẩm Thực - Trang Tìm Kiếm Và Đặt Thức Uống Và Đồ Ăn Nhanh',
            'keywords' => 'Trùm Ẩm Thực, Đặt Món Ăn Nhanh',
            'canonical' => request()->url(),
            // 'sitename' => 'nhuandeptraivanhanbro.doancoso2.laravel.vn',
            'image' => '',
        );

        $min_price = Food::min('food_price');
        $max_price = Food::max('food_price');

        $min_price_range = $min_price + 5000;
        $max_price_range = $max_price - 10000;

        $all_category = Category::where('category_status', 0)->orderBy('category_id', 'desc')->take(6)->get();
        $all_food = Food::where('food_status', 0)->where('food_condition', 0)->orderBy('food_id', 'asc')->get();

        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();

        return view('pages.Food.all_food')->with(compact('all_category', 'all_food', 'min_price', 'max_price', 'min_price_range', 'max_price_range', 'meta', 'config_web_logo', 'config_web'));
    }

    public function list_deleted_food(){
        return view('Admin.food.soft_deleted_food');
    }

    public function load_bin_food(){
        $items = Food::onlyTrashed()->get();
        $output = '';
        foreach ($items as $key => $food) {
            $output .= '
            <tr>
            <td>'.$food->food_id.'</td>
            <td>
                <img src="'. URL('public/upload/MonAn/'. $food->food_img).'" alt="Ảnh sản phẩm" style="width: 50px; height: 50px; object-fit: cover">
            </td>
            <td>'.$food->food_name.'</td> 
            <td>'.number_format($food->food_price, 0, ',','.').' đ</td>';
            if($food->food_condition == 0){
                $output .='<td>Không Giảm</td>';
            }else{
                if($food->food_condition == 1){
                    $output .='<td>'.$food->food_number.' %</td>';
                }else{
                    $output .='<td>'.number_format($food->food_number,0,',',',').' đ</td>';
                }
            }

            if($food->food_condition == 0){
                $output .='<td>'.number_format($food->food_price,0,',','.').' đ</td>';
            }else{
                if($food->food_condition == 1){
                    $food_sale = ($food->food_price * $food->food_number) / 100;
                    $food_price = $food->food_price - $food_sale;
                    $output .='<td>'.number_format($food_price,0,',','.').' đ</td>';
                }else{
                    $food_price = $food->food_price - $food->food_number;
                    $output .='<td>'.number_format($food_price,0,',',',').' đ</td>';
                }
            }
            $output.='
            <td>
                <button type="button" class="btn-sm btn-gradient-success btn-icon-text btn-restore-item" data-item_id = "'. $food->food_id.'">
                <i class="mdi mdi-backup-restore btn-icon-prepend"></i> Khôi Phục </button>
                </br>
                <button type="button" class="btn-sm btn-gradient-danger btn-icon-text mt-3 btn-delete-item" data-item_id = "'. $food->food_id.'">
                <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Xóa </button>
            </td>
        </tr>';
        }
        return $output;
    }

    public function restore_food(Request $request){
        $food = Food::withTrashed()->find($request->food_id);
        $food->restore();
    }

    public function delete_trash_food(Request $request){
        $food = Food::withTrashed()->find($request->food_id);
        $food->forceDelete();
    }

    public function count_bin_food(){
        $food = Food::onlyTrashed()->count();
        echo $food;
    }

}
