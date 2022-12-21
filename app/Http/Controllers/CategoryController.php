<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\URL;

class CategoryController extends Controller
{
    public function add_category()
    {
        return view('Admin.Category.add_category');
    }

    public function save_category(Request $request)
    {
        $data = $request->all();
        $category = new Category();
        $category->category_name = $data['category_name'];
        $category->category_status = $data['category_status'];

        $get_image = $request->file('category_img');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/TheLoai', $new_image);
            $data['category_img'] = $new_image;
            $category['category_img'] = $data['category_img'];
        }
        $category->save();
        Toastr::success('Thêm thể loại thành công', 'Thành công');
        return Redirect::to('/admin/category/all-category');
    }

    public function all_category()
    {
        $category = new Category();
        $all_category = $category->all_category();

        $manager_all_category = view('Admin.Category.all_category')
            ->with('all_category', $all_category);

        return view('admin.admin_layout')
            ->with('all_category', $manager_all_category);
    }

    public function delete_category(Request $request)
    {
        $data = $request->delete_id;
        $category = Category::find($data);
        $category->delete();
    }

    public function hien_danh_muc(Request $request)
    {
        Category::where('category_id', $request->category_id)
            ->update(['category_status' => 0]);
        Toastr::success('Kích hoạt thể loại sản phẩm thành công', 'Hiển thị');
        return Redirect::to('/admin/category/all-category');
    }

    public function an_danh_muc(Request $request)
    {
        Category::where('category_id', $request->category_id)
            ->update(['category_status' => 1]);
        Toastr::success('Không kích hoạt thể loại sản phẩm thành công', 'Ẩn ');
        return Redirect::to('/admin/category/all-category');
    }

    public function edit_category(Request $request)
    {
        $edit_category = Category::find($request->category_id);
        $manager_category = view('Admin.Category.edit_category')
            ->with('edit_category', $edit_category);
        return view('admin.admin_layout')->with('edit_category', $manager_category);
    }

    public function update_category(Request $request)
    {
        $data = request()->except(['_token']); //_token
        $category = Category::find($request->category_id);

        $category->category_name = $data['category_name'];
        $category->category_status = $data['category_status'];

        $get_image = $request->file('category_img');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/TheLoai', $new_image);
            $data['category_img'] = $new_image;
            $category['category_img'] = $data['category_img'];
        }
        $category->save();
        Toastr::success('Cập nhật thể loại thành công', 'Thành công');
        return Redirect::to('/admin/category/all-category');
    }

    public function category(Request $request)
    {
        $category_id = $request->category_id;
        $category_byId = Food::where('category_id', $category_id)->where('food_status', 0)->where('food_condition', 0)->get();
        $output = $this->loading_category_menu($category_byId);
        return $output;
    }

    public function loading_category_menu($category_byId)
    {
        $output = '';
        foreach ($category_byId as $key => $v_food) {
            $output .= '
                ' . csrf_field() . ' 
        <input type="hidden" class="cart_food_id_' . $v_food->food_id . '"
            value="' . $v_food->food_id . '">
        <input type="hidden" class="cart_food_name_' . $v_food->food_id . '"
            value="' . $v_food->food_name . '">';

            if ($v_food->food_condition == 0) {
                $output .= '
            <input type="hidden" class="cart_food_price_' . $v_food->food_id . '"
                value="' . $v_food->food_price . '">';
            } else {
                if ($v_food->food_condition == 1) {
                    $food_sale = ($v_food->food_price * $v_food->food_number) / 100;
                    $food_price = $v_food->food_price  - $food_sale;
                    $output .= '
                <input type="hidden" class="cart_food_price_' . $v_food->food_id . '"
                value="' . $food_price . '">';
                } else if ($v_food->food_condition == 2) {
                    $food_price = $v_food->food_price  - $v_food->food_number;
                    $output .= '
                <input type="hidden" class="cart_food_price_' . $v_food->food_id . '"
                value="' . $food_price . '">';
                }
            }

            $output .= '
        <input type="hidden" class="cart_food_img_' . $v_food->food_id . '"
            value="' . $v_food->food_img . '">
        <input type="hidden" class="cart_food_qty_' . $v_food->food_id . '" 
            value="1">';
            $output .='
            <div class="col-6 col-md-4 col-lg-4">
                    <div class="card">
                        <a class="kham-pha-thuc-don-link ">
                            <img src="public/upload/MonAn/' . $v_food->food_img . '" style="height: 230px; object-fit: cover; " class="card-img-top"  alt="... ">
                            <div class="card-body ">
                                <h5 class="card-title "> ' . $v_food->food_name . '</h5>
                                <p class="card-text" style="font-weight: 400; color: #000"  name="price "> ' . number_format($v_food->food_price, 0, ',', '.') . 'đ' . '</p>
                            </div>
                            <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="' . $v_food->food_id . '">Chọn mua</button>
                        </a>
                    </div>
            </div>';
        }
        return $output;
    }

    public function search_food(Request $request)
    {
        $data = $request->all();
        $result_search = Food::where('food_name', 'like', '%' . $data['key_search'] . '%')
            ->where('food_condition', 0)
            ->whereBetween('food_price', [$data['price_min'], $data['price_max']])
            ->get();
        if ($result_search) {
            $output = $this->loading_food($result_search);
            return $output;
        }
    }

    public function loading_food($result_search)
    {
        $output = '';
        foreach ($result_search as $key => $v_name_food) {
            $output .= '
                ' . csrf_field() . ' 
        <input type="hidden" class="cart_food_id_' . $v_name_food->food_id . '"
            value="' . $v_name_food->food_id . '">
        <input type="hidden" class="cart_food_name_' . $v_name_food->food_id . '"
            value="' . $v_name_food->food_name . '">';

            if ($v_name_food->food_condition == 0) {
                $output .= '
            <input type="hidden" class="cart_food_price_' . $v_name_food->food_id . '"
                value="' . $v_name_food->food_price . '">';
            } else {
                if ($v_name_food->food_condition == 1) {
                    $food_sale = ($v_name_food->food_price * $v_name_food->food_number) / 100;
                    $food_price = $v_name_food->food_price  - $food_sale;
                    $output .= '
                <input type="hidden" class="cart_food_price_' . $v_name_food->food_id . '"
                value="' . $food_price . '">';
                } else if ($v_name_food->food_condition == 2) {
                    $food_price = $v_name_food->food_price  - $v_name_food->food_number;
                    $output .= '
                <input type="hidden" class="cart_food_price_' . $v_name_food->food_id . '"
                value="' . $food_price . '">';
                }
            }

            $output .= '
        <input type="hidden" class="cart_food_img_' . $v_name_food->food_id . '"
            value="' . $v_name_food->food_img . '">
        <input type="hidden" class="cart_food_qty_' . $v_name_food->food_id . '" 
            value="1">';

            $output .= '
                <div class="col-6 col-md-4 col-lg-4">
                        <div class="card">
                            <a class="kham-pha-thuc-don-link item-food">
                                <img src="public/upload/MonAn/' . $v_name_food->food_img . '" style="height: 230px; object-fit: cover; " class="card-img-top"  alt="... ">
                                <div class="card-body ">
                                    <h5 class="card-title "> ' . $v_name_food->food_name . '</h5>
                                    <p class="card-text" style="font-weight: 400; color: #000" name="price "> ' . number_format($v_name_food->food_price, 0, ',', '.') . 'đ' . '</p>
                                </div>
                                <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="' . $v_name_food->food_id . '">Chọn mua</button>
                            </a>
                        </div>
                </div>';
        }
        return $output;
    }
 
    public function load_category(){
        $output = '';
        $all_category = Category::get();
        foreach ($all_category as $key => $value_category){
        $output .= '
        <tr class="table">
                <td>'.$value_category->category_id.'</td>
                <td>'.$value_category->category_name.'</td>
                <td>
                    <img src="'. URL('public/upload/TheLoai/'. $value_category->category_img).'" alt="Ảnh sản phẩm" style="width: 50px; height: 50px; object-fit: cover">
                </td>
                <td>';
                    if($value_category->category_status==0){    
                        $output .='
                        <a href="'. URL('/admin/category/unactive-category?category_id='.$value_category->category_id ).'"><i class="mdi mdi-lock-open" style="color: green; font-size: 1.2rem;"></i></a>';
                    }else{
                        $output .='
                        <a href="'. URL('/admin/category/active-category?category_id='.$value_category->category_id).'"><i class="mdi mdi-lock" style="color: red; font-size: 1.2rem"></i></a>';
                    }
                    $output .='
                </td>
                <td>
                    <div>
                        <a class="delete-category" data-category_id='.$value_category->category_id .'>
                            <i class="mdi mdi mdi-delete-forever" style="color: red; margin-right: 10px; font-size: 1.4rem"></i>
                        </a>
                        <a href="'.URL('/admin/category/edit-category?category_id='.$value_category->category_id).'">
                            <i class="mdi mdi-open-in-new" style="color: green; font-size: 1.2rem"></i>
                        </a>
                    </div>
                </td>';
                }
            $output .='
        </tr>';
        return $output;
    }   

    public function list_deleted_category(){
        return view('Admin.Category.soft_deleted_category');
    }

    public function load_bin_category(){
        $items = Category::onlyTrashed()->get();
        $output = '';
        foreach ($items as $key => $category) {
            $output .= '
            <tr>
            <td>'.$category->category_id.'</td>
            <td>
                <img src="'. URL('public/upload/TheLoai/'. $category->category_img).'" alt="Ảnh sản phẩm" style="width: 50px; height: 50px; object-fit: cover">
            </td>
            <td>'.$category->category_name.'</td> 
            <td>'.$category->deleted_at.'</td>
            <td>
                <button type="button" class="btn-sm btn-gradient-success btn-icon-text btn-restore-item" data-item_id = "'. $category->category_id.'">
                <i class="mdi mdi-backup-restore btn-icon-prepend"></i> Khôi Phục </button>
                </br>
                <button type="button" class="btn-sm btn-gradient-danger btn-icon-text mt-3 btn-delete-item" data-item_id = "'. $category->category_id.'">
                <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Xóa </button>
            </td>
        </tr>';
        }
        return $output;
    }

    public function restore_category(Request $request){
        $category = Category::withTrashed()->find($request->category_id); //Khôi Phục 
        $category->restore();
    }

    public function delete_trash_category(Request $request){
        $category = Category::withTrashed()->find($request->category_id);
        $category->forceDelete(); 
    }

    public function count_bin_category(){
        $category = Category::onlyTrashed()->count();
        echo $category; 
    }
}
