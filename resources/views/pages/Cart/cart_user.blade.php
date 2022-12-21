@extends('user_layout2')
@section('user_main2')
    <!-- Chi tiết -->
    <div class="row gx-5">
        <div class="col-12 col-md-12 col-lg-3">

        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <img src="{{ asset('public/frontend/assets/img/banner/banner1.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">GIỎ HÀNG CỦA BẠN</h5>
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
                                    <tbody id="loading-cart">

                                    </tbody>
                                </table>

                                @if (Session::get('cart'))
                                    <form method="post" action="{{ url('/check-coupon') }}">
                                        @csrf
                                        <div class="input-group mb-3 ">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa-solid fa-ticket"></i>
                                            </span>
                                            <input type="text " class="form-control" name="coupon"
                                                placeholder="Nhập mã giảm giá">
                                            <button type="submit" class="btn btn-danger ">Tính
                                            </button>
                                        </div>
                                    </form>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-3">

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        load_count_cart();
        function load_count_cart() {
            $.ajax({
                url: '{{ url('/count-cart') }}',
                method: 'GET',
                success: function(data) {
                    if (data) {
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
        loading_cart();
        function loading_cart() {
            $.ajax({
                url: '{{ url('/loading-cart') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('#loading-cart').html(data);
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
                    delete_id: delete_id
                },
                success: function(data) {
                    message_toastr("success", "Xoá món thành công");
                    loading_cart();
                    load_count_cart();
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '.btn-update-cart', function() {
            var session_id = $(this).data('session_id'); //Session
            var qty = $(this).val(); //qty
            $.ajax({
                url: '{{ url('/cap-nhat-gio-hang') }}',
                method: 'get',
                data: {
                    session_id: session_id,
                    qty: qty,
                },
                success: function(data) {
                    message_toastr("success", "Cập nhật món thành công");
                    loading_cart();
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });
    </script>
@endsection
