@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Thêm bài viết </h3>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" id="form-category" action="{{ URL::to('/admin/news/save-news') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tiêu đề bài viết</label>
                  <input  name="news_title" type="text" class="form-control" id="title_news" placeholder="Điền tiêu đề bài viết">
                  <span class="form-message text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Hình ảnh</label>
                  <input name="news_image" type="file" class="form-control" id="image_news" >
                  <span class="form-message text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Nội dung bài viết</label>
                  <textarea name="news_content" rows="10" type="text" class="form-control" id="content_news"
                      placeholder="Điền nội dung bài viết"></textarea>
                      <span class="form-message text-danger"></span>
              </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Hiển thị</label>
                  <div>
                    <select name="news_status" id="" class="form-control" id="exampleInputUsername1">
                        <option value="0">Hiển thị</option>
                        <option value="1">Ẩn</option>
                      </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2 add-category">Thêm</button>
                <button class="btn btn-light">Thoát</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection