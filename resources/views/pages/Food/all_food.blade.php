@extends('user_layout2')
@section('user_main2')
    <div class="row g-lg-3">
        <div class="col-12 col-md-12 col-lg-3">
            <div class="list-group card p-2 mb-3 mt-5" id="list-tab" role="tablist">
                <h5 class="text-center"
                    style="color: #53382c;
                        font-size: 1.2rem;
                        font-weight: bold;">
                    TÌM KIẾM </h5>
                <div class="input-group">
                    <input id="search" type="text" class="form-control" name="search"
                        placeholder="Tìm Kiếm Món Ăn, Đồ Uống...">
                    <button type="button" class="btn-md btn-inverse-success btn-icon border border-0 p-2 rounded-end">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
            <div class="list-group card p-2 mb-3">
                <p>
                <h5 class="text-center"
                    style="color: #53382c;
                            font-size: 1.2rem;
                            font-weight: bold;">
                    TÌM KIẾM THEO GIÁ</h5>
                <input type="text" id="amount" readonly style="border: 0; color: #dc3545; font-weight:bold;">
                </p>
                <input type="hidden" name="start_price" id="start_price">
                <input type="hidden" name="end_price" id="end_price">
                <div id="slider-range"></div> {{-- Thanh Trượt --}}
            </div>
            <div class="list-group card p-2" id="list-tab" role="tablist">
                <h5 class="text-center"
                    style="color: #53382c;
                        font-size: 1.2rem;
                        font-weight: bold;">
                    DANH MỤC CÁC MÓN</h5>
                @foreach ($all_category as $v_category)
                    <div class="m-2">

                        {{-- <input type="radio" class="id-category-checked" data-id_category="{{ $v_category->category_id }}"
                            name="id-category-checked{{ $v_category->category_id }}" value="{{ $v_category->category_id }}"> --}}
                            <i class="fa-solid fa-jar"></i>
                        <span style="cursor: pointer" class="btn-category" data-id_category="{{ $v_category->category_id }}" >{{ $v_category->category_name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-9">
            <div style="margin-bottom: 20px">
                <h4 class="text-center fw-bolder" style="font-size: 26px; color: #53382c">KHÁM PHÁ THỰC ĐƠN</h4>
            </div>
            <div class="row g-2 g-lg-3 row-cols-2 row-cols-lg-5" id="loading-category-menu">
                @foreach ($all_food as $key => $value_food)
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="card">
                            <form>
                                @csrf
                                <input type="hidden" class="cart_food_id_{{ $value_food->food_id }} "
                                    value="{{ $value_food->food_id }}">
                                <input type="hidden" class="cart_food_name_{{ $value_food->food_id }}"
                                    value="{{ $value_food->food_name }}">

                                <?php if ($value_food->food_condition == 0) { ?>
                                <input type="hidden" class="cart_food_price_{{ $value_food->food_id }}"
                                    value="{{ $value_food->food_price }}">
                                <?php } else { ?>
                                <?php if ($value_food->food_condition == 1) { 
                                                $food_sale = ($value_food->food_price * $value_food->food_number) / 100;
                                                $food_price = $value_food->food_price  - $food_sale;
                                            ?>
                                <input type="hidden" class="cart_food_price_{{ $value_food->food_id }}"
                                    value="{{ $food_price }}">
                                <?php } else if ($value_food->food_condition == 2) {
                                                $food_price = $value_food->food_price  - $value_food->food_number;
                                            ?>
                                <input type="hidden" class="cart_food_price_{{ $value_food->food_id }}"
                                    value="{{ $food_price }}">
                                <?php
                                                }
                                            ?>
                                <?php 
                                            }
                                        ?>
                                <input type="hidden" class="cart_food_img_{{ $value_food->food_id }}"
                                    value="{{ $value_food->food_img }}">
                                <input type="hidden" class="cart_food_qty_{{ $value_food->food_id }}" value="1">
                            </form>
                            <a class="kham-pha-thuc-don-link item-food">
                                <img src="public/upload/MonAn/{{ $value_food->food_img }}"
                                    style="height: 230px; object-fit: cover; " class="card-img-top" alt="... ">
                                <div class="card-body ">
                                    <h5 class="card-title ">{{ $value_food->food_name }}</h5>
                                    <p class="card-text" name="price" style="font-weight: 400; color: #000">
                                        {{ number_format($value_food->food_price, 0, ',', '.') . 'đ' }}</p>
                                </div>
                                <button type="button" class="btn btn-danger add-to-cart d-block m-auto"
                                    data-id_food="{{ $value_food->food_id }}">Chọn mua</button>
                            </a>
                        </div>
                    </div>
                @endforeach
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

    <script>
        var price_min = {{ $min_price }};
        var price_max = {{ $max_price }};
        $(document).ready(function() {
            $('#search').keyup(function() {
                var key_search = $(this).val();
                $.ajax({
                    url: '{{ url('/tim-kiem-mon') }}',
                    method: 'GET',
                    data: {
                        key_search: key_search,
                        price_min: price_min,
                        price_max: price_max,
                    },
                    success: function(data) {
                        $('#loading-category-menu').html(data);
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
            });

            $("#slider-range").slider({
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                values: [{{ $min_price_range }}, {{ $max_price_range }}],
                step: 5000,
                slide: function(event, ui) {
                    $("#amount").val(ui.values[0] + " đ" + " - " + ui.values[1] + " đ");
                    // $("#start_price" ).val(ui.values[ 0 ]);
                    // $("#end_price" ).val(ui.values[ 1 ]);         
                    var start_price = ui.values[0];
                    var end_price = ui.values[1];
                    var key_search = $('#search').val();
                    price_min = ui.values[0];
                    price_max = ui.values[1];
                    $.ajax({
                        url: '{{ url('/tim-kiem-mon') }}',
                        method: 'GET',
                        data: {
                            key_search: key_search,
                            price_min: price_min,
                            price_max: price_max,
                        },
                        success: function(data) {
                            $('#loading-category-menu').html(data);
                        },
                        error: function() {
                            alert('Lỗi ');
                        },
                    });
                },
            });
            $("#amount").val($("#slider-range").slider("values", 0) + "đ  -  " + $("#slider-range").slider("values", 1) + "đ");
            
            $('.btn-category').click(function() {
                var category_id = $(this).data('id_category');
                $.ajax({
                    url: '{{ url('/danh-muc') }}',
                    method: 'GET',
                    data: {
                        category_id: category_id,
                    },
                    success: function(data) {
                        $('#loading-category-menu').html(data);
                    },
                    error: function() {
                        alert('Lỗi ');
                    },
                });
            });
        });
    </script>

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

    {{-- Hiệu ứng thêm vào giỏ hàng --}}
    {{-- <script>
        $(document).on('click', '.add-to-cart', function() {
            var cart = $('.shopping-cart');
            var imgtodrag = $(this).parent('.item-food').find("img").eq(0);
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left,
                    })
                    .css({
                        'opacity': '0.8',
                        'position': 'absolute',
                        'height': '100px',
                        'width': '100px',
                        'z-index': '100',
                        'border-radius': '50%'
                    })
                    .appendTo($('.main'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                    }, 1000, 'easeInOutExpo');

                setTimeout(function() {
                    cart.effect("shake", {
                        times: 2
                    }, 200);
                }, 1500);

                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function() {
                    $(this).detach()
                });
            }
        });
    </script> --}}

@endsection
