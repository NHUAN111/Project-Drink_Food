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
                                <button type="submit" class="input-group-text btn-primary" id="basic-addon2">Tìm kiếm</button>
                            </div>
                        </span>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Liệt kê mã giảm giá </h1>
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> Tên mã giảm giá </th>
                            <th style="font-weight: bold;"> Mã giảm giá </th>
                            <th style="font-weight: bold;"> Số lượng </th>
                            <th style="font-weight: bold;"> Số giảm</th>
                            <th style="font-weight: bold;"> Tình trạng</th>
                            <th style="font-weight: bold;"> Ngày bắt đầu</th>
                            <th style="font-weight: bold;"> Ngày kết thúc</th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody id="load-coupon">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        load_coupon();
        function load_coupon(){
            $.ajax({
                url: '{{ url('/admin/coupon/load-coupon') }}',
                method: 'get',
                data: {
                },
                success: function(data) {
                    $('#load-coupon').html(data);
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        }
    </script>

    <script>
        $(document).on('click', '.delete-coupon', function() {
            var delete_id = $(this).data('coupon_id');
            message_toastr("success", 'Xác Nhận Xóa Mã Giảm ID ' + delete_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-coupon_id="' +
                delete_id + '">Xóa</button>');
        });

        $(document).on('click', '.confirm-delete', function() {
            var delete_id = $(this).data('coupon_id');
            $.ajax({
                url: '{{ url('/admin/coupon/delete-coupon') }}',
                method: 'get',
                data: {
                    delete_id: delete_id,
                },
                success: function(data) {
                    message_toastr("success", "Mã Giảm Giá ID " + delete_id + " đã xoá thành công");
                    load_coupon();
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });
    </script>
@endsection
