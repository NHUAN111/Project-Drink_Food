@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper ">
      <div class="page-header">
        <h3 class="page-title"> Sữa thể loại </h3>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" action="{{ URL::to('/admin/category/update-category?category_id='.$edit_category->category_id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tên thể loại</label>
                  <input name="category_name" type="text" value="{{ $edit_category->category_name }}" class="form-control" id="exampleInputUsername1" placeholder="Điền tên thể loại">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Hình ảnh sản phẩm</label>
                    <input name="category_img" type="file" class="form-control" id="exampleInputUsername1" >
                    <img src="{{ URL::to('public/upload/TheLoai/'.$edit_category->category_img)  }}" style="width: 100px; height: 100px; object-fit: cover" alt="">
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
                <button class="btn btn-gradient-primary me-2">Cập nhật</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection