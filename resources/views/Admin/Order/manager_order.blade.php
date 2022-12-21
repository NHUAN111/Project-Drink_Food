@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
    </div>
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Liệt kê đơn hàng</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> STT </th>
                            <th style="font-weight: bold;"> Mã đơn hàng </th>
                            <th style="font-weight: bold;"> Tên người đặt</th>
                            <th style="font-weight: bold;"> Tình trạng </th>
                            <th style="font-weight: bold;"> Hình thức thanh toán </th>
                            <th style="font-weight: bold;"> Thời gian đặt </th>
                            <th style="font-weight: bold;"> Thời gian duyệt </th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody id="load-order">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Phân Trang Bằng Paginate + Boostraps , Apply Boostrap trong Provider --}}
    <nav aria-label="Page navigation example">
        {!! $all_order->links('admin.pagination') !!}
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var notePage = 1;
        load_order(notePage);
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            load_order(page);
        });

        function load_order(page) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/admin/order/load-order?page=') }}' + page,
                method: 'GET',
                data: {
                    _token: _token
                },
                success: function(data) {
                    $('#load-order').html(data);
                },
                error: function() {
                    alert('Error Load Or');
                }
            });
        }
    </script>


    <script>
        $(document).on('click', '.update-status', function() {
            var order_id = $(this).data('item_id');
            var order_status = $(this).data('item_status');
            $.ajax({
                url: '{{ url('/admin/order/confirm-order-status') }}',
                method: 'get',
                data: {
                    order_id: order_id,
                    order_status: order_status,
                },
                success: function(data) {
                    load_order();
                    message_toastr("success", 'Duyệt đơn ' + order_id + ' thành công!');
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        });

        // Từ chối đơn
        $(document).on('click', '.cancel-order', function() {
            var order_id = $(this).data('item_id');
            message_toastr("success", 'Xác Nhận Từ Chối Đơn Hàng ID ' + order_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-cancel" data-item_id="' +
                order_id + '" data-order_status="0" >Xác Nhận</button>');
        });
        $(document).on('click', '.confirm-cancel', function() {
            $(".loading").css({
                "display": "block"
            });
            $(".overlay-loading").css({
                "display": "block"
            });
            var order_id = $(this).data('item_id');
            var order_status = $(this).data('order_status');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/admin/order/cancel-order') }}',
                method: 'get',
                data: {
                    order_id: order_id,
                    order_status: order_status,
                },
                success: function(data) {
                    load_order();
                    message_toastr("success", "Đơn hàng " + order_id + " Đã Từ Chối Thành Công");
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        });


        // Xoá đơn
        $(document).on('click', '.btn-delete-order', function() {
            var item_id = $(this).data('item_id');
            message_toastr("success", 'Xác Nhận Xóa Đơn Hàng ID ' + item_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-item_id="' +
                item_id + '">Xóa</button>');
        });
        $(document).on('click', '.confirm-delete', function() {
            $(".loading").css({
                "display": "block"
            });
            $(".overlay-loading").css({
                "display": "block"
            });
            var item_id = $(this).data('item_id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/admin/order/delete-order') }}',
                method: 'get',
                data: {
                    order_id: item_id,
                },
                success: function(data) {
                    load_order();
                    message_toastr("success", "Đơn hàng" + item_id + " đã xoá thành công");
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        });
    </script>
@endsection
