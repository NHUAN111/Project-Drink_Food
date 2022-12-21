@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Sữa bài viết </h3>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" id="form-category" action="{{ URL::to('/admin/news/update-news?news_id='.$edit_news->news_id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tiêu đề bài viết</label>
                  <input  name="news_title" type="text"  value="{{ $edit_news->news_title }}" class="form-control" id="title_news" placeholder="Điền tiêu đề bài viết">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Hình ảnh</label>
                  <input name="news_image" type="file" class="form-control" id="image_news" >
                  <img src="{{ URL::to('public/upload/news/'.$edit_news->news_image)  }}" style="width: 100px; height: 100px; object-fit: cover" alt="">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Nội dung bài viết</label>
                  <textarea name="news_content" rows="10" type="text" class="form-control" id="content_news"
                      placeholder="Điền nội dung bài viết">{{ $edit_news->news_content }}</textarea>
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