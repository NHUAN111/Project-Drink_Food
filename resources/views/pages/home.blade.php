@extends('user_layout')
@section('user_main')

<div class="kham-pha-thuc-don-title ">
    <h4>KHÁM PHÁ THỰC ĐƠN</h4>
</div>
<div class="row g-2 g-lg-3 row-cols-2 row-cols-lg-5" style="position: relative" id="all-food">
    
    <div class="w-100 text-lg-center text-md-center text-center" id="dvloader" style="display: none; position: absolute; bottom: -44px;">  
        <img src="{{ asset('/public/frontend/assets/img/Gif Load/load.gif') }}"  style="height: 40px" alt="LOAD-MORE" srcset="">
    </div>
</div>


 {{-- Bán chạy nhất --}}
 <div class="mt-3">
    <div class="d-flex">
        {{-- <img class="align-self-center mx-2" width="120" src="http://file.hstatic.net/200000295622/collection/giphy_596deb0ff53a4be487f4419c91035fd4.gif" alt=""> --}}
        <h4 class="fs-5 fw-bold" style="color: #53382c;
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 80px;">BÁN CHẠY NHẤT</h4>
    </div>
    <div class="row g-2 g-lg-3">
        @foreach($bestseller_food as $key => $v_all_food)
        <div class="col-6 col-md-4 col-lg-3 flex justify-content-center">
            <div class="card kham-pha-thuc-don-link item-food">
                <form>
                    @csrf
                    <input type="hidden" class="cart_food_id_{{ $v_all_food->food_id }} "
                        value="{{ $v_all_food->food_id }}">
                    <input type="hidden" class="cart_food_name_{{ $v_all_food->food_id }}"
                        value="{{  $v_all_food->food_name }}">
            
                    <?php if ($v_all_food->food_condition == 0) { ?>
                        <input type="hidden" class="cart_food_price_{{ $v_all_food->food_id }}"
                            value="{{ $v_all_food->food_price }}">
                    <?php } else { ?>
                        <?php if ($v_all_food->food_condition == 1) { 
                            $food_sale = ($v_all_food->food_price * $v_all_food->food_number) / 100;
                            $food_price = $v_all_food->food_price  - $food_sale;
                        ?>
                            <input type="hidden" class="cart_food_price_{{  $v_all_food->food_id }}"
                            value="{{  $food_price }}">
                        <?php } else if ($v_all_food->food_condition == 2) {
                            $food_price = $v_all_food->food_price  - $v_all_food->food_number;
                        ?>
                            <input type="hidden" class="cart_food_price_{{ $v_all_food->food_id }}"
                            value="{{ $food_price }}">
                        <?php
                            }
                        ?>    
                    <?php 
                        }
                    ?>    
                    <input type="hidden" class="cart_food_img_{{ $v_all_food->food_id }}"
                        value="{{  $v_all_food->food_img }}">
                    <input type="hidden" class="cart_food_qty_{{ $v_all_food->food_id }}" 
                        value="1">
                </form>
            <a class="text-decoration-none"  href="{{ url('/chi-tiet-mon?food_id='.$v_all_food->food_id) }}">
                <img src="public/upload/MonAn/{{ $v_all_food->food_img }}" style="height: 230px; object-fit: cover; " class="card-img-top " alt="... ">
            </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $v_all_food->food_name }}</h5>
                    <p class="card-text" style="font-weight: 400; color: #000" name="price ">{{ number_format($v_all_food->food_price,0,',','.').' đ' }}</p>
                </div>
                <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="{{ $v_all_food->food_id }}">Chọn mua</button>
                <div class="promotion_img-icon">
                    <img src="https://uploads.documents.cimpress.io/v1/uploads/81901466-1a04-40fc-bbb5-40c7d1c7e57f~110/original?tenant=vbu-digital" alt="" style="border-bottom: 0" width="45px" srcset="">
                </div>
                </div>
        </div>
        @endforeach
    </div>
</div>



     <div id="new-food">
        <div class="row g-2 g-lg-3 ">
            <div class="khuyen-mai-title">
                <h4>MÓN MỚI NHẤT</h4>
            </div>
            @foreach($new_food as $key => $v_new_food)
            <div class="col-6 col-md-4 col-lg-3 flex justify-content-center">
                <div class="card kham-pha-thuc-don-link item-food">
                    {{-- Dữ liệu để thêm sản phẩm vào giỏ hàng --}}
                <form>
                    @csrf
                    <input type="hidden" class="cart_food_id_{{ $v_new_food->food_id }} "
                        value="{{ $v_new_food->food_id }}">
                    <input type="hidden" class="cart_food_name_{{ $v_new_food->food_id }}"
                        value="{{  $v_new_food->food_name }}">
            
                    <?php if ($v_new_food->food_condition == 0) { ?>
                        <input type="hidden" class="cart_food_price_{{ $v_new_food->food_id }}"
                            value="{{ $v_new_food->food_price }}">
                    <?php } else { ?>
                        <?php if ($v_new_food->food_condition == 1) { 
                            $food_sale = ($value_food->food_price * $v_new_food->food_number) / 100;
                            $food_price = $v_new_food->food_price  - $food_sale;
                        ?>
                            <input type="hidden" class="cart_food_price_{{  $v_new_food->food_id }}"
                            value="{{ $food_price }}">
                        <?php } else if ($value_food->food_condition == 2) {
                            $food_price = $v_new_food->food_price  - $v_new_food->food_number;
                        ?>
                            <input type="hidden" class="cart_food_price_{{ $v_new_food->food_id }}"
                            value="{{ $food_price }}">
                        <?php
                            }
                        ?>    
                    <?php 
                        }
                    ?>    
                    <input type="hidden" class="cart_food_img_{{ $v_new_food->food_id }}"
                        value="{{  $v_new_food->food_img }}">
                    <input type="hidden" class="cart_food_qty_{{ $v_new_food->food_id }}" 
                        value="1">
                </form>
                <a class="text-decoration-none"  href="{{ url('/chi-tiet-mon?food_id='.$v_new_food->food_id) }}">
                    <img src="public/upload/MonAn/{{ $v_new_food->food_img }}" style="height: 230px; object-fit: cover; " class="card-img-top " alt="... ">
                </a>
                    <div class="card-body ">
                        <h5 class="card-title">{{ $v_new_food->food_name }}</h5>
                        <p class="card-text" style="font-weight: 400; color: #000" name="price ">{{ number_format($v_new_food->food_price,0,',','.').' đ' }}</p>
                    </div>
                    <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="{{ $v_new_food->food_id }}">Chọn mua</button>
                    <div class="promotion_img-icon">
                        <img src="https://static.wixstatic.com/media/2e960e_fa7140c43f3743ce8e4ccaddf860f47f~mv2.gif" alt="" style="border-bottom: 0" width="45px" srcset="">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <!-- Đang khuyến mãi -->
    <div id="food-sale">
        <div class="row g-2 g-lg-3 ">
            <div class="khuyen-mai-title">
                <h4 class="khuyen-mai-title-h4">ĐANG KHUYẾN MÃI</h4>
            </div>
            @foreach($all_food_sale as $key => $v_all_food)
            <div class="col-6 col-md-4 col-lg-3 flex justify-content-center">
                <div class="card kham-pha-thuc-don-link item-food">
                    <form>
                        @csrf
                        <input type="hidden" class="cart_food_id_{{ $v_all_food->food_id }} "
                            value="{{ $v_all_food->food_id }}">
                        <input type="hidden" class="cart_food_name_{{ $v_all_food->food_id }}"
                            value="{{  $v_all_food->food_name }}">
                
                        <?php if ($v_all_food->food_condition == 0) { ?>
                            <input type="hidden" class="cart_food_price_{{ $v_all_food->food_id }}"
                                value="{{ $v_all_food->food_price }}">
                        <?php } else { ?>
                            <?php if ($v_all_food->food_condition == 1) { 
                                $food_sale = ($v_all_food->food_price * $v_all_food->food_number) / 100;
                                $food_price = $v_all_food->food_price  - $food_sale;
                            ?>
                                <input type="hidden" class="cart_food_price_{{  $v_all_food->food_id }}"
                                value="{{  $food_price }}">
                            <?php } else if ($v_all_food->food_condition == 2) {
                                $food_price = $v_all_food->food_price  - $v_all_food->food_number;
                            ?>
                                <input type="hidden" class="cart_food_price_{{ $v_all_food->food_id }}"
                                value="{{ $food_price }}">
                            <?php
                                }
                            ?>    
                        <?php 
                            }
                        ?>    
                        <input type="hidden" class="cart_food_img_{{ $v_all_food->food_id }}"
                            value="{{  $v_all_food->food_img }}">
                        <input type="hidden" class="cart_food_qty_{{ $v_all_food->food_id }}" 
                            value="1">
                    </form>
                    <a class="text-decoration-none" href="{{ url('/chi-tiet-mon?food_id='.$v_all_food->food_id) }}">
                        <img src="public/upload/MonAn/{{ $v_all_food->food_img }}" style="height: 230px; object-fit: cover;" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $v_all_food->food_name }}</h5>
                        @if($v_all_food->food_condition == 1)
                            @php
                                $food_sale = ($v_all_food->food_price * $v_all_food->food_number) / 100;
                                $food_price = $v_all_food->food_price  - $food_sale;
                            @endphp
                            <p class="card-text text-decoration-line-through text-danger" style="font-weight: 400; color: #000" name="price ">{{ number_format($v_all_food->food_price,0,',','.').' đ' }}</p>
                            <p class="card-text" style="font-weight: 400; color: #000" name="price ">{{ number_format($food_price,0,',','.').' đ' }}</p>
                        @elseif($v_all_food->food_condition == 2)
                            @php
                                $food_price = $v_all_food->food_price  - $v_all_food->food_number;
                            @endphp
                        <p class="card-text text-decoration-line-through text-danger" style="font-weight: 400; color: #000" name="price">{{ number_format($v_all_food->food_price,0,',','.').' đ' }}</p>
                        <p class="card-text"  style="font-weight: 400; color: #000" name="price">{{ number_format($food_price,0,',','.').' đ' }}</p>
                        @endif
                    </div>
                    <button type="button" class="btn btn-danger add-to-cart d-block m-auto" data-id_food="{{ $v_all_food->food_id }}">Chọn mua</button>
                    <div class="promotion_img-icon">
                        @if($v_all_food->food_condition == 1)
                            <span> -{{ $v_all_food->food_number }} %</span>
                        @elseif($v_all_food->food_condition == 2)
                            <span> -{{ number_format($v_all_food->food_number,0,',','.') }} đ</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        load_more_food();
        function load_more_food(id = ' '){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/load-more-food') }}',
                method: 'GET',
                data: {
                    id: id,
                    _token:  _token
                },
                success: function(data) {
                    $("#btn-load").remove();
                    $('#btn-load-more').remove();
                    $('#all-food').append(data);
                },
                error: function(){
                    alert('Error Load More');
                }
            });
        }

        $(document).on('click','#btn-load-more', function(){
            var id = $(this).data('id');
            $("#dvloader").show();
            $('#dvloader').delay(1).fadeOut('fade'); /* fade fast/400/slow */
            load_more_food(id);
        });
    </script>

    <script>
        load_count_cart();
        function load_count_cart() {
            $.ajax({
                url: '{{ url('/count-cart') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">0</span>'
                        );
                    } else {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">' +
                            data + '</span>');
                    }
                },
                error: function() {
                    // alert("Bug Huhu :<<");
                }
            })
        }
    </script>



    
@endsection
