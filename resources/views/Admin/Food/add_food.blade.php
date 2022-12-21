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
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span style="color: green">', $message, '</span>';
                    Session::put('message', null);
                }
                ?>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h1 class="card-title">Điền thông tin danh mục</h1> --}}
                            <form class="forms-sample" id="form-food" action="{{ URL::to('/admin/food/save-food') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Tên món ăn</label>
                                    <input data-validation="length" data-validation-length="min3"
                                        data-validation-error-msg="Bạn chưa điền thông tin" name="food_name" type="text"
                                        class="form-control" id="name_food" placeholder="Điền tên món ăn">
                                        <span class="form-message text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Giá món ăn</label>
                                    <input name="food_price" type="text" class="form-control" id="price_food"
                                        placeholder="Điền giá món ăn">
                                    <span class="form-message text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Hình ảnh món ăn</label>
                                    <input name="food_img" type="file" class="form-control" id="image_food">
                                    <span class="form-message text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Mô tả món ăn</label>
                                    <textarea name="food_desc" rows="10" type="text" class="form-control" id="desc_food"
                                        placeholder="Điền mô tả món ăn"></textarea>
                                        <span class="form-message text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Nội dung món ăn</label>
                                    <textarea name="food_content" rows="5" type="text" class="form-control" id="content_food"
                                        placeholder="Điền nội dung món ăn"></textarea>
                                        <span class="form-message text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Thể loại món ăn</label>
                                    <select name="food_category" class="form-control" id="exampleInputUsername1">
                                        @foreach ($all_category as $key => $value_category)
                                            <option value="{{ $value_category->category_id }}">{{ $value_category->category_name }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputUsername1">Cấu hình cho món ăn</label>
                                    <select name="food_condition" class="form-control btn-food-sale" id="exampleInputUsername1">
                                        <option value="0">Không giảm giá</option>
                                        <option value="1">Giảm giá theo %</option>
                                        <option value="2">Giảm giá theo tiền</option>
                                    </select>
                                </div>

                                <div class="form-group form-group-sale" style="display: none">
                                    <label for="exampleInputUsername1">Số giảm</label>
                                    <input name="food_number" class="form-control" id="number_food">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hiển thị</label>
                                    <div>
                                        <select name="food_status" id="" class="form-control" id="exampleInputUsername1">
                                            <option value="0">Hiển thị</option>
                                            <option value="1">Ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-gradient-primary me-2 add-food">Thêm</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.btn-food-sale').click(function() {
            var food_condition = $(this).val();
            if (food_condition == 0) {
                $('.form-group-sale').hide();
            } else {
                $('.form-group-sale').show();
            }
        });
        </script>
@endsection
