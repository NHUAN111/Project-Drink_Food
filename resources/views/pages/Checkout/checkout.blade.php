@extends('user_layout2')
@section('user_main2')
    <div class="row gx-lg-5 gx-md-4 gx-2 justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 p-3 p-md-5 p-lg-5 card">
            <div class=" ">
                     <form class="form-info-shipping" action="{{ url('/thong-tin-van-chuyen') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <h4 class="form-title text-center">Nhập Thông Tin Của Bạn</h4>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <input type="text" class="form-control p-2" id="name_user" aria-describedby="emailHelp"
                                    name="shipping_name" placeholder="Tên của quý khách" value="" required>
                                <span class="form-message text-danger"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <input type="text" class="form-control p-2" id="phone_user" aria-describedby="emailHelp"
                                    name="shipping_phone" placeholder="Số điện thoại của quý khách" value="" required>
                                <span class="form-message text-danger"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="email" aria-describedby="emailHelp"
                                name="shipping_email" placeholder="Nhập Email để xem đơn hàng" required>
                            <span class="form-message text-danger"></span>
                        </div>
                        {{-- Thông tin vận chuyển --}}
                        <div class="form-group mb-3">
                            <div>
                                <select name="city" id="city" class="form-control choose city p-2"
                                    id="exampleInputUsername1" required>
                                    <option value>--Chọn tỉnh thành phố--</option>
                                    @foreach ($city as $key => $v_city)
                                        <option value="{{ $v_city->matp }}">{{ $v_city->name_city }}</option>
                                    @endforeach
                                </select>
                                <span class="form-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div>
                                <select name="province" id="province" class="form-control choose province p-2"
                                    id="exampleInputUsername1" required>
                                    <option value="">--Chọn quận huyện--</option>
                                </select>
                                <span class="form-message text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div>
                                <select name="wards" id="wards" class="form-control wards p-2 calculate_delivery"
                                    id="exampleInputUsername1" required> 
                                    <option>--Chọn xã phường--</option>
                                </select>
                                <span class="form-message text-danger"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control p-2" id="address" aria-describedby="emailHelp"
                                name="shipping_address" placeholder="Địa chỉ, số nhà..." required>
                            <span class="form-message text-danger"></span>
                        </div>
    
                        <div class="mb-3">
                            <textarea type="text" rows="5" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                name="shipping_notes" placeholder="Ghi chú của khách hàng *"></textarea>
                        </div>
                        <input type="submit" class="btn btn-danger w-100 p-2" id="submit-info-shipping"
                            value="Xác nhận đơn hàng">
                    </form>
                    <div class="mb-3 text-center mt-3">
                        Bạn có tài khoản. Đăng nhập
                        <a type="submit" class="text-decoration-none" href="{{ url('/dang-nhap') }}">tại đây</a>
                    </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Đếm số lượng trong giỏ --}}
    <script>
        load_count_cart();

        function load_count_cart() {
            $.ajax({
                url: '{{ url('/count-cart') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">' +
                            data + '</span>');
                    } else {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">' +
                            data + '</span>');
                    }
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
    </script>

    <script>
        $('.choose').on('change', function() {
            var action = $(this).attr('id');
            var matp = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if (action == 'city') {
                result = 'province';
            } else {
                result = 'wards';
            }
            $.ajax({
                url: '{{ url('/select-delivery-home') }}',
                method: 'POST',
                data: {
                    action: action,
                    matp: matp,
                    _token: _token
                },
                success: function(data) {
                    $('#' + result).html(data);
                },
                error: function() {
                    alert('lỗi 4');
                }
            });
        });
    </script>

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
                    loading_cart();
                },
                error: function() {
                    alert('lôi');
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
        loading_cart();
        $(document).ready(function() {
            $('.calculate_delivery').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/calculate-fee') }}',
                    method: 'get',
                    data: {
                        matp: matp,
                        maqh: maqh,
                        xaid: xaid,
                        _token: _token,
                    },
                    success: function(data) {
                        // alert('ok');
                        // location.reload();
                    },
                    error: function() {
                        alert('lỗi 122');
                    }
                });
            });
        });
    </script>
@endsection
