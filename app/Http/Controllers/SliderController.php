<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;

class SliderController extends Controller
{
    public function add_slider()
    {
        return view('Admin.Slider.add_slider');
    }

    public function select_slider()
    {
        $slider = Slider::orderBy('slider_id', 'desc')->get();
        $slider_count = $slider->count();
        $output = '';
        $output .= '
        <table class="table table-bordered">
        <thead>
          <tr>
            <th  style="font-weight: bold;"> STT </th>
            <th  style="font-weight: bold;"> Tên hình ảnh</th>
            <th  style="font-weight: bold;"> Ảnh  </th>
            <th  style="font-weight: bold;"> Thời gian tạo </th>
            <th  style="font-weight: bold;"> Chức năng </th>
          </tr>
        </thead>
        <tbody>';
        if ($slider_count > 0) {
            $i = 0;
            foreach ($slider as $key => $v_slider) {
                $i++;
                $output .= '
                <tr>
                    <td>' . $i . '</td>
                    <td contenteditable class="edit_slider_name" data-id="' . $v_slider->slider_id . '">' . $v_slider->slider_name . ' </td>
                    <td>
                        <form>
                        ' . csrf_field() . '
                            <input hidden id="up_load_file'. $v_slider->slider_id.'" class="up_load_file"  type="file"  name="file_image" accept="image/*" data-id = "' . $v_slider->slider_id . '">
                            <label class="up_load_file" for="up_load_file'.$v_slider->slider_id.'" > 
                                <img style="object-fit: cover" width="40px" height="20px" src="'.URL('public/upload/slider/' . $v_slider->slider_img). '" alt="">
                            </label>
                        </form>
                    </td>
                    <td>' . $v_slider->created_at. '</td>
                    <td>
                        <button type="button" data-id="'. $v_slider->slider_id . '" class="btn btn-gradient-danger delete-slider">Xóa</button>
                    </td>
                </tr>';
            }
        } else {
            $output .= '
                <tr>
                    <td>Không có Slider nào được thêm</td>
                </tr>';
        }
        return $output;
    }

    public function insert_slider(Request $request)
    {
        $get_img = $request->file('file');
        if ($get_img) {
            foreach ($get_img as $images) {
                $get_image_name = $images->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $images->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $images->move('public/upload/slider', $new_image);

                $slider = new Slider();
                $slider->slider_name = $new_image;
                $slider->slider_img = $new_image;
                $slider->save();
            }
        }
        Toastr::success('Thêm slider thành công', 'Thành công');
        return redirect()->back();
    }

    public function delete_slider(Request $request) {
        $delete_id = $request->delete_id;
        $slider = Slider::find($delete_id);
        unlink('public/upload/slider/'.$slider->slider_img);
        $slider->delete();
    }

    public function update_slider_name(Request $request){
        $slider_id = $request->slider_id;
        $slider_text = $request->slider_text;
        $slider = Slider::find($slider_id);
        $slider->slider_name = $slider_text;
        $slider->save();
        // Toastr::success('Cập nhật ảnh thành công', 'Thành công');
    }

    public function update_slider(Request $request){
        $get_img = $request->file('file');
        $slider_id = $request->slider_id;
        if ($get_img) {
                $get_image_name = $get_img->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $get_img->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $get_img->move('public/upload/slider', $new_image);

                $slider = Slider::find($slider_id);
                unlink('public/upload/slider/'.$slider->slider_img);
                $slider->slider_img = $new_image;
                $slider->save();
            }
        // Toastr::success('Cập nhật slider thành công', 'Thành công');
        // return redirect()->back();
    }
}
