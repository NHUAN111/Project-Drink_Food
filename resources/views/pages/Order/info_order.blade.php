@extends('user_layout2')
@section('user_main2')
    <div class="row g-lg-3 g-md-4 g-2">
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card pt-4 p-lg-2 p-md-2 p-2">
                <div class="mb-3">
                    <h4 class="form-title text-center fs-4 text-dark">Đơn Hàng Của Bạn</h4>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên Món</th>
                            <th scope="col">SL</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Tổng</th>
                        </tr>
                    </thead>
                    <tbody id="load-info-order">

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
            <div class="card pt-4 p-lg-2 p-md-2 p-2">
                <div class="mb-3">
                    <h4 class="form-title text-center fs-4 text-dark">Lịch Sử Đặt Hàng</h4>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Mã Đơn</th>
                            <th scope="col">Địa Chỉ Giao Hàng</th>
                            <th scope="col">Tình Trạng</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="load-order-old">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    {{-- Huỷ đơn hàng --}}
    <script>
        $(document).on('click', '.btn-cancel-order', function() {
            var order_id = $(this).data('id');
            message_toastr("success", 'Xác Nhận Huỷ Đơn ' + order_id + '?<br/><br/><button style="background: linear-gradient(to right, #90caf9, #047edf 99%); color: #fff" type="button" class="btn border-0 text-white p-2  confirm-delete" data-id="' +order_id + '">Xác Nhận</button>');
        });

        $(document).on('click', '.confirm-delete', function() {
            $(".loading").css({
                "display": "block"
            });
            $(".overlay-loading").css({
                "display": "block"
            });
            var order_id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/cancel-order') }}',
                method: 'get',
                data: {
                    order_id: order_id,
                },
                success: function(data) {
                    load_order_old();
                    message_toastr("success", "Đã Huỷ Đơn " + order_id + " Thành Công");
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        });
    </script>

    {{-- Load more --}}
    <script>
        load_order_old(id='');
        function load_order_old(id = ' ') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/load-order-old') }}',
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    _token: _token,
                },
                success: function(data) {
                    $("#btn-load-order").remove();
                    $('.btn-load-order').remove();
                    $('#load-order-old').append(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        }

        $(document).on('click','.btn-load-order', function(){
            var id = $(this).data('id');
            load_order_old(id);
        });

        $(document).on('click', '.btn-delete-order', function() {
            var id = $(this).data('id');
            // load_view_order(order_code);
            $.ajax({
                url: '{{ url('/delete-order') }}',
                method: 'get',
                data: {
                    id: id,
                },
                success: function(data) {
                    load_order_old(id);
                    message_toastr("success", "Đã Xoá Đơn " + order_id + " Thành Công");
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        });
    </script>


    <script>
        var order_code = '{{ $order_info_latest->order_code }}';
        load_view_order(order_code);
        function load_view_order(order_code) {
            $.ajax({
                url: '{{ url('/view-order-old') }}',
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    order_code: order_code,
                },
                success: function(data) {
                    $('#load-info-order').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            });
        }
        $(document).on('click', '.btn-view-order', function() {
            order_code = $(this).data('id');
            load_view_order(order_code);
        });
    </script>
@endsection
