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
                <h1 class="card-title">Liệt kê món ăn</h1>
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #STT </th>
                            <th style="font-weight: bold;"> Tên món ăn </th>
                            <th style="font-weight: bold;"> Hình ảnh </th>
                            <th style="font-weight: bold;"> Giá </th>
                            <th style="font-weight: bold;"> Danh mục </th>
                            <th style="font-weight: bold;"> Hiển thị </th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody id="load-food">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Phân Trang Bằng Paginate + Boostraps , Apply Boostrap trong Provider --}}
    <nav aria-label="Page navigation example">
        {!! $all_food->links('Admin.pagination') !!}
    </nav>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var notePage = 1;
        load_food(notePage);
        // load_count_bin();
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            load_food(page);
        });
        function load_food(page) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/admin/food/load-food?page=') }}' + page,
                method: 'GET',
                data: {
                    _token: _token
                },
                success: function(data) {
                    $('#load-food').html(data);
                },
                error: function() {
                    alert('Error Load food');
                }
            });
        }
    </script>

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
                    load_count_bin();
                    load_food(notePage);
                    message_toastr("success", "Món ID " + delete_id + " Đã Chuyển Vào Thùng Rác");
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
