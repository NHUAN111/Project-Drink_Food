@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <form action="{{ URL::to('/search-food-admin') }}" method="post">
                        {{ csrf_field() }}
                        <span>
                            <div class="input-group mb-3">
                                <input type="text" name="keywords_search" class="form-control"
                                    placeholder="Tìm kiếm món ăn" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <button type="submit" class="input-group-text btn-primary" id="basic-addon2">Tìm
                                    kiếm</button>
                            </div>
                        </span>
                    </form>
                    {{-- <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> --}}
                </li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-2" style="    float: right;
                margin-bottom: 33px;">
                    <div class="input-group">
                        <a style="text-decoration: none" href="{{ URL::to('admin/food/list-deleted-food') }}">
                            <button id="bin" type="button" class="btn btn-gradient-danger btn-icon-text">
                            </button>
                        </a>
                    </div>
                </div>
                <h1 class="card-title">Liệt kê món ăn khuyến mãi</h1>
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #ID </th>
                            <th style="font-weight: bold;"> Tên món ăn </th>
                            <th style="font-weight: bold;"> Hình ảnh </th>
                            <th style="font-weight: bold;"> Giá </th>
                            <th style="font-weight: bold;"> Danh mục </th>
                            <th style="font-weight: bold;"> Số giảm </th>
                            <th style="font-weight: bold;"> Giá cuối</th>
                            <th style="font-weight: bold;"> Hiển thị </th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_food_sale as $key => $value_food)
                            <tr class="table">
                                <td scope="row">{{ $value_food->food_id }}</td>
                                <td>{{ $value_food->food_name }}</td>
                                <td>
                                    <img src="{{ URL::to('public/upload/MonAn/' . $value_food->food_img) }}"
                                        alt="{{ $value_food->food_name }}"
                                        style="width: 50px; height: 50px; object-fit: cover">
                                </td>
                                <td>{{ number_format($value_food->food_price, 0, ',', '.') . ' ' . 'VNĐ' }}</td>
                                <td>{{ $value_food->category->category_name }}</td>

                                @if ($value_food->food_condition == 1)
                                    <td>{{ $value_food->food_number }}%</td>
                                @elseif($value_food->food_condition == 2)
                                    <td>{{ number_format($value_food->food_number, 0, ',', '.') }}đ</td>
                                @endif

                                @if ($value_food->food_condition == 1)
                                    @php
                                        $food_sale = ($value_food->food_price * $value_food->food_number) / 100;
                                        $food_price_sale = $value_food->food_price - $food_sale;
                                    @endphp
                                    <td>{{ number_format($food_price_sale, 0, ',', '.') }}đ</td>
                                @elseif($value_food->food_condition == 2)
                                    @php
                                        $food_price_sale = $value_food->food_price - $value_food->food_number;
                                    @endphp
                                    <td>{{ number_format($food_price_sale, 0, ',', '.') }}đ</td>
                                @endif

                                <td>
                                    <?php 
                                if($value_food->food_status==0){    
                            ?>
                                    <a href="{{ URL::to('/admin/food/unactive-food?food_id=' . $value_food->food_id) }}"><i
                                            class="mdi mdi-lock-open" style="color: #46c35f; font-size: 1.2rem;"></i></a>
                                    <?php 
                                }else{
                            ?>
                                    <a href="{{ URL::to('/admin/food/active-food?food_id=' . $value_food->food_id) }}"><i
                                            class="mdi mdi-lock" style="color: #f96868; font-size: 1.2rem"></i></a>
                                    <?php  
                                }
                            ?>
                                </td>
                                <td>
                                    <div>
                                        <a class="delete-food" data-food_id={{ $value_food->food_id }}>
                                            <i class="mdi mdi-delete"
                                                style="color: #f96868; margin-right: 10px; font-size: 1.2rem"></i>
                                        </a>
                                        <a href="{{ URL::to('/admin/food/edit-food?food_id=' . $value_food->food_id) }}">
                                            <i class="mdi  mdi-open-in-new"
                                                style="color: #1bcfb4;  margin-right: 10px; font-size: 1.2rem"></i>
                                        </a>
                                        <a href="{{ URL::to('/admin/food/detail-food?food_id=' . $value_food->food_id) }}">
                                            <i class="mdi mdi-information" style="color: #57c7d4; font-size: 1.2rem;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Phân Trang Bằng Paginate + Boostraps , Apply Boostrap trong Provider --}}
    {{-- <nav aria-label="Page navigation example">
        {!!  $all_food->links()  !!}
   </nav> --}}
    {{-- Món giảm giá --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        load_count_bin();
        $(document).on('click', '.delete-food', function() {
            var delete_id = $(this).data('food_id');
            message_toastr("success", 'Xác Nhận Xóa Món ID ' + delete_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-food_id="' +
                delete_id + '">Xóa</button>');
        });

        $(document).on('click', '.confirm-delete', function() {
            var delete_id = $(this).data('food_id');
            $.ajax({
                url: '{{ url('/admin/food/delete-food') }}',
                method: 'get',
                data: {
                    delete_id: delete_id,
                },
                success: function(data) {
                    message_toastr("success", "Món ID " + delete_id + " đã xoá thành công");
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });

        function load_count_bin() {
            $.ajax({
                url: '{{ url('/admin/food/count-bin-food') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#bin').html('<i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Thùng Rác');
                    } else {
                        $('#bin').html(
                            '<i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Thùng Rác <div style="width: 20px;height: 20px;background-color:red;display: flex;justify-content: center;align-items: center;position: absolute;border-radius: 10px;right: 10%;top:10%"><b>' +
                            data + '</b></div>');
                    }
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
    </script>
@endsection
