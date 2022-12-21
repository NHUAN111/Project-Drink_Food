@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Thêm món ăn </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Quản lý món ăn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm món ăn</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              {{-- <h1 class="card-title">Điền thông tin danh mục</h1> --}}
              <form class="forms-sample" action="{{ URL::to('/admin/food/update-food?food_id='.$edit_food->food_id )}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tên món ăn</label>
                  <input data-validation="length" value="{{ $edit_food->food_name }}" data-validation-length="min3" data-validation-error-msg="Bạn chưa điền thông tin" name="food_name" type="text" class="form-control" id="exampleInputUsername1" placeholder="Điền tên món ăn">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Giá món ăn</label>
                    <input name="food_price" type="text" value="{{ $edit_food->food_price }}" class="form-control" id="exampleInputUsername1" placeholder="Điền giá món ăn">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Hình ảnh món ăn</label>
                    <input name="food_img" type="file" class="form-control" id="exampleInputUsername1" >
                    <img src="{{ URL::to('public/upload/MonAn/'.$edit_food->food_img)  }}" style="width: 100px; height: 100px; object-fit: cover" alt="">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Mô tả món ăn</label>
                  <textarea name="food_desc" rows="10" type="text" class="form-control" id="ckeditor1" placeholder="Điền mô tả món ăn">{{ $edit_food->food_desc }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Nội dung món ăn</label>
                    <textarea name="food_content" rows="5" type="text" class="form-control" id="ckeditor2" placeholder="Điền nội dung món ăn">{{ $edit_food->food_content }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Thể loại món ăn</label>
                    <select name="food_category" class="form-control" id="exampleInputUsername1">
                        @foreach ($all_category as $key => $value_category)
                            @if($value_category->category_id == $edit_food->category_id)
                                <option selected value="{{ $value_category->category_id }}">{{ $value_category->category_name }}</option>
                            @else
                                <option value="{{ $value_category->category_id }}">{{ $value_category->category_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Giảm giá</label>
                  <select name="food_condition" class="form-control btn-food-sale" id="exampleInputUsername1">
                    @if($edit_food->food_condition == 0)
                      <option value="0">Không giảm giá</option>
                    @elseif($edit_food->food_condition == 1)
                      <option value="1">Giảm giá theo %</option>
                    @else
                      <option value="2">Giảm giá theo tiền</option>
                    @endif
                  </select>
              </div>

              @if($edit_food->food_condition == 0)
                <div class="form-group form-group-sale" style="display: none">
                    <label for="exampleInputUsername1">Số giảm</label>
                    <input name="food_number" value={{ $edit_food->food_number }} class="form-control" id="exampleInputUsername1">
                </div>
              @else
              <div class="form-group form-group-sale">
                <label for="exampleInputUsername1">Số giảm</label>
                <input name="food_number" value={{ $edit_food->food_number }} class="form-control" id="exampleInputUsername1">
              </div>
              @endif

                <div class="form-group">
                  <label for="exampleInputEmail1">Hiển thị</label>
                  <div>
                    <select name="food_status" id="" class="form-control" id="exampleInputUsername1">
                        <option value="0">Hiển thị</option>
                        <option value="1">Ẩn</option>
                      </select>
                  </div>
                </div>
                <button class="btn btn-gradient-primary me-2">Cập nhật</button>
                <button type="button" class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection