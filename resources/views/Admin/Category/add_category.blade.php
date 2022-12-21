@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Thêm thể loại </h3>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              {{-- <h1 class="card-title">Điền thông tin thể loại</h1> --}}
              <form class="forms-sample" id="form-category" action="{{ URL::to('/admin/category/save-category') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tên thể loại</label>
                  <input  name="category_name" type="text" class="form-control" id="name_category" placeholder="Điền tên thể loại">
                  <span class="form-message text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Hình ảnh sản phẩm</label>
                  <input name="category_img" type="file" class="form-control" id="image_category" >
                  <span class="form-message text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Hiển thị</label>
                  <div>
                    <select name="category_status" id="" class="form-control" id="exampleInputUsername1">
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