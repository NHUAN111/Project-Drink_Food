<?php

namespace App\Http\Controllers;

use App\Models\ConfigWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;

class ConfigWebController extends Controller
{
    public function add_configweb(){
        $config_web = ConfigWeb::where('config_type', 1)->first();
        return view('admin.configweb.add_configweb')->with(compact('config_web'));
    }

    public function add_configweb_logo(Request $request){
        $data = $request->all();
        $config_web = new ConfigWeb();
        $config_web->config_title = 0;
        $config_web->config_type = 0; // 0 là logo web
        $get_image = $request->file('config_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/LogoWeb', $new_image);
            $data['config_image'] = $new_image;
            $config_web['config_image'] = $data['config_image'];
        }
        $config_web->save();
        Toastr::success('Thêm Logo Thành Công', 'Thành công !');
        return Redirect::to('/admin/configweb/add-configweb-logo');
    }

    public function load_configweb_logo(){
        $logo = ConfigWeb::where('config_type', 0)->first();
        $output = '';
        if($logo){
            $output .= 
                '<form>' 
                    . csrf_field() . '
                    <input hidden id="up_load_file'.$logo->config_id.'" class="up_load_file"  type="file" name="file_image" accept="image/*" data-id="'.$logo->config_id.'">
                    <label class="up_load_file" for="up_load_file'.$logo->config_id.'" > 
                        <img style="border-radius: 50%; object-fit: cover;width: 100px;height:auto;" src="' . URL('public/upload/LogoWeb/' . $logo->config_image) . '" alt="">
                    </label>
                </form>';
                echo $output;
        }else{
            $output .= 'Không có Logo';
            echo $output;
        }
    }


    public function insert_configweb_footer(Request $request){
        $data = $request->all();
        $config_web = new ConfigWeb();
        $config_web->config_type = $data['config_type'];
        $config_web->config_title = $data['config_title']; 
        $config_web->config_image = 0; 
        $config_web->save();
    }

    public function edit_configweb_footer(Request $request){
        $data = $request->all();
        $config_web = ConfigWeb::find($data['config_id']);
        $config_web->config_title = $data['config_title'];
        $config_web->save();
    }

    public function delete_configweb_footer(Request $request){
        $config_id = $request->config_id;
        $config = ConfigWeb::find($config_id);
        $config->delete();
    }

    public function load_configweb_footer(Request $request){
        $config_web = ConfigWeb::where('config_type', $request->config_type)->get();
        $output = '';
        $i = 0;
        foreach($config_web as $key => $v_config_web){
            $output .='
                <tr>
                    <td>'.++$i.'</td>';
                    if($v_config_web->config_type == 1){
                        $output .='<td>Về chúng tôi</td>';
                    }else if($v_config_web->config_type == 2){
                        $output .='<td>Dịch vụ</td>';
                    }else if($v_config_web->config_type == 3){
                        $output .='<td>Hợp tác</td>';
                    }else if($v_config_web->config_type == 4){
                        $output .='<td>Khu vực</td>';
                    }else if($v_config_web->config_type == 5){
                        $output .='<td>Media</td>';
                    }
                    $output.='
                    <td contenteditable class="edit_config_title"  data-config_id = "' . $v_config_web->config_id . '"> '.$v_config_web->config_title.'  </td>
                    <td>
                        <a data-id = "' . $v_config_web->config_id . '" class="btn btn-gradient-danger btn-delete-footer">
                            <i class="mdi mdi-delete-sweep"></i>
                            Xóa 
                        </a>
                    </td>
                </tr>';
        }
        echo $output;
    }

    public function update_configweb_logo(Request $request){
        $get_img = $request->file('file');
        $config_id = $request->config_id;
        if ($get_img) {
            $get_image_name = $get_img->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_img->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_img->move('public/upload/LogoWeb', $new_image);

            $config_web = ConfigWeb::find($config_id);
            unlink('public/upload/LogoWeb/'.$config_web->config_image);
            $config_web->config_image = $new_image;
            $config_web->save();
        }
    }

}