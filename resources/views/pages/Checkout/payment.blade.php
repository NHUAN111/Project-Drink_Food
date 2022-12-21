@extends('user_layout2')
@section('user_main2')
    <form action="{{ url('/dat-hang') }}" method="post">
        @csrf
        <div class="row gx-lg-5 gx-md-4 gx-2 justify-content-center">
            <div class="col-12 col-md-10 col-lg-6 p-3 p-md-5 p-lg-5 pt-4">
                <div class="card">
                    <img src="{{ asset('public/frontend/assets/img/banner/banner1.jpg') }}" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center">XEM LẠI ĐƠN CỦA BẠN</h5>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Ảnh</th>
                                                <th>Tên món</th>
                                                <th>Giá</th>
                                                <th>SL</th>
                                                <th>Tổng</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dat-hang">

                                            @if (Session::get('fee'))
                                                <input type="hidden" name="order_fee" class="order_fee"
                                                    value="{{ Session::get('fee') }}">
                                            @else
                                                <input type="hidden" name="order_fee" class="order_fee" value="25000">
                                            @endif

                                            @if (Session::get('coupon'))
                                                @foreach (Session::get('coupon') as $key => $cou)
                                                    <input type="hidden" name="order_coupon" class="order_coupon"
                                                        value="{{ $cou['coupon_code'] }}">
                                                @endforeach
                                            @else
                                                <input type="hidden" name="order_coupon" class="order_coupon"
                                                    value="Không có mã khuyến mãi">
                                            @endif

                                            @if (Session::get('cart'))
                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="border border-0 text-center">
                                                    <input type="submit" class="btn btn-danger w-100 p-2" name="order"
                                                        value="Đặt món">
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        loading_cart();

        function loading_cart() {
            $.ajax({
                url: '{{ url('/payment') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('#dat-hang').html(data);
                },
                error: function() {
                    alert('Lỗi ạ');
                },
            });
        }
    </script>

    <script>
        loading_cart();
        $(document).on('click', '.delete-cart', function() {
            var delete_id = $(this).data('id');
            $.ajax({
                url: '{{ url('/xoa-gio-hang') }}',
                method: 'get',
                data: {
                    delete_id: delete_id,
                },
                success: function(data) {
                    message_toastr("warning", 'Xóa món thành công ');
                    loading_cart();
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '.btn-update-cart', function() {
            var session_id = $(this).data('session_id');
            var qty = $(this).val();
            $.ajax({
                url: '{{ url('/cap-nhat-gio-hang') }}',
                method: 'get',
                data: {
                    session_id: session_id,
                    qty: qty,
                },
                success: function(data) {
                    loading_cart();
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id');
                var cart_food_id = $('.cart_food_id_' + id).val();
                var cart_food_name = $('.cart_food_name_' + id).val();
                var cart_food_price = $('.cart_food_price_' + id).val();
                var cart_food_img = $('.cart_food_img_' + id).val();
                var cart_food_qty = $('.cart_food_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/them-gio-hang') }}',
                    method: 'POST',
                    data: {
                        cart_food_id: cart_food_id,
                        cart_food_name: cart_food_name,
                        cart_food_price: cart_food_price,
                        cart_food_img: cart_food_img,
                        cart_food_qty: cart_food_qty,
                        _token: _token
                    },
                    success: function(data) {
                        loading_cart();
                    },
                    error: function() {
                        alert('Lỗi ạ');
                    },
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var order_coupon = $('.order_coupon').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/dat-hang') }}',
                    method: 'POST',
                    data: {
                        order_fee: order_fee,
                        order_coupon: order_coupon,
                        _token: _token
                    },
                    success: function(data) {

                    },
                    error: function() {
                        alert('Lỗi ạ');
                    },
                });
            });
        });
    </script>

@endsection
