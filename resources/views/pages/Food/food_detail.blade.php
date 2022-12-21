@extends('user_layout2')
@section('user_main2')
        <!-- Chi tiết -->
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 hidden-imgs">
                    <div class="card mb-3">
                        <div class="d-flex border-2 border-bottom border-danger">
                            <img src="{{ asset('public/frontend/assets/img/AnhChiTiet/logo-png-01.png') }}" style="width: 25%; height: 130px; object-fit: cover;" class="card-img-top" alt="...">
                            <img src="https://virama.vn/wp-content/uploads/2021/02/mok-6-scaled.jpg" style="width: 25%; height: 130px; object-fit: cover;" class="card-img-top" alt="...">
                            <img src="https://virama.vn/wp-content/uploads/2021/02/mok-2-scaled.jpg" style="width: 25%; height: 130px; object-fit: cover;" class="card-img-top" alt="...">
                            <img src="{{ asset('public/frontend/assets/img/AnhChiTiet/mok-4-scaled.jpg') }}" style="width: 25%; height: 130px; object-fit: cover;" class="card-img-top" alt="...">
                        </div>
                        <div class="d-flex">
                            <div class="card-body">
                                <h3 class="card-title">Trùm Ẩm Thực</h3>
                                <div class="d-inline-flex align-items-center">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p class="card-text" style="color: #7ed321; padding-left: 8px;"> Đang mở cửa</p>
                                </div>
                                <p class="card-text">470 Đường Trần Đại Nghĩa, Khu đô thị, Ngũ Hành Sơn, Đà Nẵng</p>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title fs-5">Thanh Toán Trực Tuyến</h4>
                                <div class="row">
                                    <div class="col-lg-3"><img src="http://mauweb.monamedia.net/donghohaitrieu/wp-content/uploads/2018/10/logo-ninja-van.jpg" alt="" style="width: 52px;"></div>
                                    <div class="col-lg-3"><img src="http://mauweb.monamedia.net/donghohaitrieu/wp-content/uploads/2018/10/logo-techcombank.jpg" alt="" style="width: 52px;"></div>
                                    <div class="col-lg-3"><img src="http://mauweb.monamedia.net/donghohaitrieu/wp-content/uploads/2018/10/logo-paypal.jpg" alt="" style="width: 52px;"></div>
                                    <div class="col-lg-3"><img src="http://mauweb.monamedia.net/donghohaitrieu/wp-content/uploads/2018/10/logo-mastercard.jpg" alt="" style="width: 52px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card mb-3">
                        <div class="row gx-0">
                            <div class="col-lg-6 col-md-12 col-12">
                                <img src="public/upload/MonAn/{{ $detail_food->food_img }}" class="img-food" style="width: 279px; object-fit: cover; border-radius: 6px; " alt="">
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="card-body lh-lg">
                                    <form>
                                        @csrf
                                        <input type="hidden" class="cart_food_id_{{ $detail_food->food_id }} "
                                            value="{{ $detail_food->food_id }}">
                                        <input type="hidden" class="cart_food_name_{{ $detail_food->food_id }}"
                                            value="{{  $detail_food->food_name }}">
                                
                                        <?php if ($detail_food->food_condition == 0) { ?>
                                            <input type="hidden" class="cart_food_price_{{ $detail_food->food_id }}"
                                                value="{{ $detail_food->food_price }}">
                                        <?php } else { ?>
                                            <?php if ($detail_food->food_condition == 1) { 
                                                $food_sale = ($detail_food->food_price * $detail_food->food_number) / 100;
                                                $food_price = $detail_food->food_price  - $food_sale;
                                            ?>
                                                <input type="hidden" class="cart_food_price_{{  $detail_food->food_id }}"
                                                value="{{  $food_price }}">
                                            <?php } else if ($detail_food->food_condition == 2) {
                                                $food_price = $detail_food->food_price  - $detail_food->food_number;
                                            ?>
                                                <input type="hidden" class="cart_food_price_{{ $detail_food->food_id }}"
                                                value="{{ $food_price }}">
                                            <?php
                                                }
                                            ?>    
                                        <?php 
                                            }
                                        ?>    
                                        <input type="hidden" class="cart_food_img_{{ $detail_food->food_id }}"
                                            value="{{  $detail_food->food_img }}">
                                        <input type="hidden" class="cart_food_qty_{{ $detail_food->food_id }}" 
                                            value="1">
                                    </form>
                                    <h5 class="card-title lh-lg">{{ $detail_food->food_name }}</h5>
                                    <?php 
                                        if($detail_food->food_condition==0){
                                    ?>
                                        <h6 class="card-title lh-lg">Giá: {{ number_format($detail_food->food_price,0,',','.') }} đ</h6>
                                    <?php 
                                        }else{
                                    ?>
                                        <?php if ($detail_food->food_condition == 1) { 
                                            $food_sale = ($detail_food->food_price * $detail_food->food_number) / 100;
                                            $food_price = $detail_food->food_price  - $food_sale;
                                        ?>
                                            <h6 class="card-title text-decoration-line-through lh-lg"><span>Giá Cũ: </span>{{ number_format($detail_food->food_price,0,',','.') }} đ</h6>
                                            <h6 class="card-title lh-lg">Giá Khuyến Mãi: {{ number_format($food_price,0,',','.') }} đ</h6>
                                        <?php } else if ($detail_food->food_condition == 2) {
                                            $food_price = $detail_food->food_price  - $detail_food->food_number;
                                        ?>
                                             <h6 class="card-title text-decoration-line-through lh-lg"><span>Giá Cũ: </span>{{ number_format($detail_food->food_price,0,',','.') }} đ</h6>
                                             <h6 class="card-title lh-lg">Giá Khuyến Mãi: {{ number_format($food_price,0,',','.') }} đ</h6>
                                        <?php
                                            }
                                        ?>    
                                    <?php 
                                        }
                                    ?>
                                    <p class="card-text lh-lg">{{ $detail_food->food_content }}</p>
                                <button type="button" class="btn btn-danger add-to-cart  w-100 d-block m-auto" data-id_food="{{ $detail_food->food_id }}">Chọn mua</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h4 class="my-3">Mô Tả Sản Phẩm</h4>
                    <div class="col-12 ">
                        <p class="card-text lh-lg">{{ $detail_food->food_desc }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5" style="margin-top: 20px;">
            <h4 class="fs-4">Sản Phẩm Liên Quan</h4>
            <div class="slider ">
                <div class="slider-box ">
                    <div class="food-deatil-js owl-carousel owl-theme ">
                        @foreach ($similarly_food as $key => $v_similarly_food)
                            <div class="item card">
                                <form>
                                    @csrf
                                    <input type="hidden" class="cart_food_id_{{ $v_similarly_food->food_id }} "
                                        value="{{ $v_similarly_food->food_id }}">
                                    <input type="hidden" class="cart_food_name_{{ $v_similarly_food->food_id }}"
                                        value="{{  $v_similarly_food->food_name }}">
                            
                                    <?php if ($v_similarly_food->food_condition == 0) { ?>
                                        <input type="hidden" class="cart_food_price_{{ $v_similarly_food->food_id }}"
                                            value="{{ $v_similarly_food->food_price }}">
                                    <?php } else { ?>
                                        <?php if ($v_similarly_food->food_condition == 1) { 
                                            $food_sale = ($v_similarly_food->food_price * $v_similarly_food->food_number) / 100;
                                            $food_price = $v_similarly_food->food_price  - $food_sale;
                                        ?>
                                            <input type="hidden" class="cart_food_price_{{  $v_similarly_food->food_id }}"
                                            value="{{  $food_price }}">
                                        <?php } else if ($v_similarly_food->food_condition == 2) {
                                            $food_price = $v_similarly_food->food_price  - $v_similarly_food->food_number;
                                        ?>
                                            <input type="hidden" class="cart_food_price_{{ $v_similarly_food->food_id }}"
                                            value="{{ $food_price }}">
                                        <?php
                                            }
                                        ?>    
                                    <?php 
                                        }
                                    ?>    
                                    <input type="hidden" class="cart_food_img_{{ $v_similarly_food->food_id }}"
                                        value="{{  $v_similarly_food->food_img }}">
                                    <input type="hidden" class="cart_food_qty_{{ $v_similarly_food->food_id }}" 
                                        value="1">
                                </form>
                                <a class="text-decoration-none"  href="{{ url('/chi-tiet-mon?food_id='.$v_similarly_food->food_id) }}">
                                    <img width="465px " height="220px " style="height: 230px; object-fit: cover; border-radius: 6px" src="public/upload/MonAn/{{ $v_similarly_food->food_img }}" alt=" ">
                                </a>
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: #000">{{ $v_similarly_food->food_name }}</h5>
                                        <p class="card-text" style="font-weight: 400; color: #000" name="price ">{{ number_format($v_similarly_food->food_price,0,',','.').' đ' }}</p>
                                        <button type="button"  class="btn btn-danger add-to-cart d-block m-auto" data-id_food="{{ $v_similarly_food->food_id }}">Chọn mua</button>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    
        <script>
            $(document).on('click', '.add-to-cart', function() {
                var id = $(this).data('id_food');
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
                        message_toastr("success", 'Thêm món thành công vào giỏ');
                        load_count_cart();
                    },
                    error: function() {
                        alert('Lỗi ạ');
                    },
                });
            });
        </script>
@endsection
