<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\News;
use App\Models\ConfigWeb;

class NewsController extends Controller
{
    public function add_news(){
        return view('admin.news.add_news');
    }

    public function save_news(Request $request){
        $data = $request->all();
        $news = new News();
        $news->news_title = $data['news_title'];
        $news->news_image = $data['news_image'];
        $news->news_content = $data['news_content'];
        $news->news_status = $data['news_status'];

        $get_image = $request->file('news_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/News', $new_image);
            $data['news_image'] = $new_image;
            $news['news_image'] = $data['news_image'];
        } else {
            $news['news_image'] = '';
        }
        $data['news_image'] = '';
        $news->save();
        Toastr::success('Thêm bài viết thành công', 'Thành công');
        return Redirect::to('/admin/news/all-news');
    }

    public function all_news(){
        $all_news = News::get();
        return view('Admin.News.all_news')->with(compact('all_news'));
    }

    public function load_news(){
        $all_news = News::get();
        $output ='';
        foreach ($all_news as $key => $v_news){
            $output .='
            <tr class="table">
                    <td>'.$v_news->news_id.'</td>
                    <td>'.$v_news->news_title .'</td>
                    <td>
                        <img src="'.URL('public/upload/news/'.$v_news->news_image).'" alt="Ảnh tin" style="width: 50px; height: 50px; object-fit: cover">
                    </td>
                    <td>';
                    if ($v_news->news_status == 0){
                        $output .= '
                        <span class = "update-status" data-item_id = "'.$v_news->news_id.'" data-item_status = "0">
                        <i style="color: rgb(52, 211, 52); font-size: 30px"
                        class="mdi mdi-toggle-switch"></i>
                        </span>';
                   }else{
                       $output .= '
                       <span class = "update-status" data-item_id = "'.$v_news->news_id.'" data-item_status = "1" >
                       <i style="color: rgb(196, 203, 196);font-size: 30px"
                       class="mdi mdi-toggle-switch-off"></i>
                       </span>';
                   }
                   $output .='
                    </td>

                    <td>
                        <a href="'.URL('/admin/news/edit-news?news_id='.$v_news->news_id).'">
                            <button type="button" class="btn-sm btn-gradient-info btn-icon-text">
                            <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Chỉnh Sửa </button>
                        </a>
                        <br>
                        <button type="button" class="btn-sm btn-gradient-danger btn-icon-text btn-delete-news mt-2" data-item_id = "'. $v_news->news_id.'">
                        <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Xóa </button>
                    </td>
            </tr>';
        }
        return $output;
    }

    public function update_status_news(Request $request){
        $data = $request->all();
        if($data['news_status'] == 1){
            News::where('news_id', $data['news_id'])->update(['news_status' => 0]);
        }else{
            News::where('news_id', $data['news_id'])->update(['news_status' => 1]);
        }   
        Toastr::success('Kích hoạt hiển thị thành công', 'Thành công');
    }

    public function delete_news(Request $request){
        $data = $request->news_id;
        $news = News::find($data);
        $news->delete();
    }

    public function edit_news(Request $request){
        $data = $request->news_id;
        $edit_news = News::find($data);
        return view('Admin.News.edit_news')->with(compact('edit_news'));
    }

    public function update_news(Request $request){
        $data = $request->all();
        $news = News::find($data['news_id']);
        $news->news_title = $data['news_title'];
        $news->news_content = $data['news_content'];
        $news->news_status = $data['news_status'];

        $get_image = $request->file('news_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/upload/News', $new_image);
            $data['news_image'] = $new_image;
            $news['news_image'] = $data['news_image'];
        }
        $news->save();
        Toastr::success('Chỉnh sữa tin '.$data['news_id'].' thành công', 'Thành công');
        return redirect('/admin/news/all-news');
    }


    // Trang chủ
    public function about_us(){
        $news = News::where('news_status', 0)->get();
        $config_web_logo = ConfigWeb::where('config_type', 0)->first();
        $config_web = ConfigWeb::whereNotIn('config_type', [0])->get();
        return view('pages.news.all_news')->with(compact('news', 'config_web_logo', 'config_web'));
    }


}