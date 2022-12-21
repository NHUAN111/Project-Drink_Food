<!doctype html>
<html lang="en">

<head>
    <title>Chi tiết sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('public/frontend/assets/img/banner/logo.jpg') }}" sizes="32x32">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/responive.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/owlcarousel/assets/owl.carousel.min.css') }}">

    {{-- icons --}}
    <link rel="stylesheet"
        href="{{ asset('public/frontend/assets/fonts/fontawesome-free-6.2.0-web/css/all.min.css') }}">

    {{-- Thư viện  --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    {{-- Toastr --}}
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>

<body class="main">
    <?php
    if(session()->get('message')!=null){
       $message = session()->get('message');
       $type = $message['type'];
       $content = $message['content'];
    ?>
    <script>
        message_toastr("{{ $type }}", "{{ $content }}");
    </script>
    <?php
        }
    ?>
    <div id="header">
        <ul id="nav">
            <li class="">
                <a href="{{ URL::to('/trang-chu') }}">
                    <img src="{{ asset('public/upload/LogoWeb/' . $config_web_logo->config_image) }}" alt=""
                        class="img__about-logo">
                </a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link" href="{{ URL::to('/trang-chu') }}">Trang Chủ</a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link" href={{ URL::to('/tat-ca-mon') }}>Thực Đơn</a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link" href="#food-sale">Đang Khuyến Mãi</a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link" href="#new-food">Món Mới </a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link" href="{{ url('/ve-chung-toi') }}">Về Chúng Tôi </a>
            </li>
            <li class="list-group-item">
                <a type="button" class="navbar-item-link btn btn-outline-light"
                    href="{{ url('/chi-tiet-gio-hang') }}">
                    <i class="fa-solid fa-cart-shopping shopping-cart" style="color: rgb(144, 143, 143);"></i>
                    <div id="list-cart"
                        style="position: relative;
                            display: inline-block;
                            padding: 0 12px;
                            cursor: pointer;">

                    </div>
                </a>
            </li>
            <li class="list-group-item">
                <a class="navbar-item-link">
                    <?php 
                        $customer = session()->get('customer');
                        if($customer){
                    ?>
                    <i class="fa-solid fa-user" style="color: rgb(144, 143, 143);"></i>
                    <?php
                        }else{
                    ?>
                    <i class="fa-solid fa-user-slash" style="color: rgb(144, 143, 143);"></i>
                    <?php
                        }
                    ?>
                </a>
            </li>
            <li class="list-group-item">
                <?php 
                    if(Session::get('customer')){    
                ?>
                <a class="navbar-item-link" href="{{ url('/thong-tin-don-hang') }}">
                    <svg width="20" height="20" style="color: rgb(144, 143, 143);" fill="none">
                        <path d="M9.2 1.6v3.022a.756.756 0 00.755.755h3.022" stroke="#1A202C" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M11.467 15.2H3.91A1.511 1.511 0 012.4 13.689V3.11A1.511 1.511 0 013.91 1.6H9.2l3.778 3.777v8.311a1.511 1.511 0 01-1.511 1.512zM5.422 6.133h.756M5.422 9.155h4.534M5.422 12.178h4.534"
                            stroke="#1A202C" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>Đơn Hàng</span>
                </a>
                <?php }else{ ?>
                <a class="navbar-item-link" href="{{ url('/kiem-tra-don-hang') }}">
                    <svg width="20" height="20" style="color: rgb(144, 143, 143);" fill="none">
                        <path d="M9.2 1.6v3.022a.756.756 0 00.755.755h3.022" stroke="#1A202C" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M11.467 15.2H3.91A1.511 1.511 0 012.4 13.689V3.11A1.511 1.511 0 013.91 1.6H9.2l3.778 3.777v8.311a1.511 1.511 0 01-1.511 1.512zM5.422 6.133h.756M5.422 9.155h4.534M5.422 12.178h4.534"
                            stroke="#1A202C" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span>Đơn Hàng</span>
                </a>
                <?php 
                    }    
                ?>
            </li>
            <li class="">
                <?php 
                        $customer = session()->get('customer');
                        if($customer){
                    ?>
                <a class="" href="{{ url('/dang-xuat') }}">
                    <button type="submit" class="btn btn-danger">Đăng xuất</button>
                </a>
                <?php        
                        }else{
                    ?>
                <a class="" href="{{ url('/dang-nhap') }}">
                    <button type="submit" class="btn btn-danger">Đăng nhập</button>
                    {{-- <button class="btn btn-danger" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Đăng Nhập</button> --}}
                </a>
                <?php 
                        }
                    ?>
            </li>
        </ul>
        <ul class="d-flex justify-content-between align-items-center flex-grow-1 p-5 nav-menu-icon">
            <li class="nav__responive">
                <a href="{{ URL::to('/trang-chu') }}">
                    <img src="{{ asset('public/frontend/assets/img/banner/logo.jpg') }}" alt=""
                        class="img__about-logo" style="text-align: start">
                </a>
            </li>
            <li class="nav__responive" id="modal__nav-bar">
                <label for="nav-input" style="cursor: pointer">
                    <i class="fa-solid fa-bars" style="color: #dc3545"></i>
                </label>
            </li>
        </ul>
    </div>

    {{-- Nav bar --}}
    <input type="checkbox" hidden class="nav-input-select" name="" id="nav-input">
    <label for="nav-input" class="nav-overlay">
    </label>
    <div class="nav-menu" id="modal__nav">
        <ul class="modal__nav-li">
            {{-- <li> --}}
            <label for="nav-input" style="cursor: pointer; padding: 20px 0; font-size: 1.4rem; color: red"
                class="nav-menu-close">
                <i class="fa-solid fa-xmark nav-menu-close"></i>
            </label>
            {{-- </li> --}}
            <li>
                <a href="#main">
                    <?php 
                        $customer = session()->get('customer');
                        if($customer){
                    ?>
                    <i class="fa-solid fa-user" style="color: rgb(144, 143, 143);"></i>
                    <?php
                    echo '<span>' . $customer['customer_name'] . '</span>';
                    ?>

                    <?php
                        }else{
                    ?>
                    <i class="fa-solid fa-user-slash" style="color: rgb(144, 143, 143);"></i>
                    <?php
                        }
                    ?>
                </a>
            </li>
            <li>
                <a href="{{ url('/') }}">
                    <i class="fa-solid fa-house" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Trang Chủ</span>
                </a>
            </li>
            <li>
                <a type="button" class="navbar-item-link text-start" href="{{ url('/chi-tiet-gio-hang') }}">
                    <i class="fa-solid fa-cart-shopping shopping-cart" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-">Giỏ Hàng</span>
                    <div id="list-cart"
                        style="position: relative;
                    display: inline-block;
                    padding: 0 12px;
                    cursor: pointer;">
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ url('/tat-ca-mon') }}">
                    <i class="fa-solid fa-list" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Thực Đơn</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fa-solid fa-sun" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Món Mới</span>
                </a>
            </li>
            <li>
                <a href="#resume__me">
                    <i class="fa-solid fa-percent" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Đang Khuyến Mãi</span>
                </a>
            </li>
            <li>
                <a href="#photo__me">
                    <i class="fa-solid fa-users" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Về Chúng Tôi</span>
                </a>
            </li>
            <li>
                <?php 
                    $customer = session()->get('customer');
                    if($customer){
                ?>
                <a href="{{ url('/dang-xuat') }}">
                    <i class="fa-solid fa-right-to-bracket" style="color: rgb(144, 143, 143);"></i>
                    <span type="submit" class="border border-0">Đăng Xuất</s>
                </a>
                <?php        
                    }else{
                ?>
                <a href="{{ url('/dang-nhap') }}">
                    <i class="fa-solid fa-right-to-bracket" style="color: rgb(144, 143, 143);"></i>
                    <span type="submit" class="border border-0">Đăng Nhập</s>
                </a>
                <?php 
                    }
                ?>
            </li>
        </ul>
    </div>

    <!-- Chi tiết -->
    <div class="container" style="margin-top: 100px">

        @yield('user_main2')
    </div>

    <!-- Thành viên -->
    <div class="container  box-register-members">
        <div class="thanh-vien ">
            <h4>TRỞ THÀNH THÀNH VIÊN NGAY HÔM NAY!</h4>
        </div>
        <div class="row ">
            <div class="col-md-12 ">
                <div class="thanh-vien-img ">
                    <div class="linear-bg "></div>
                    <div class="thanh-vien-content ">
                        <h3>Đăng ký để trở thành thành viên - nhanh và miễn phí</h3>
                        <p>Giao trà sữa, đồ ăn nhanh chóng - với Trùm Ẩm Thực.</p>
                    </div>
                    <div>
                        <button class="btn btn-danger btn-banner " href="http://chienbinhloship.com "
                            target="_blank ">Đăng ký ngay!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #fff">
        <div class="container" style="margin-top: 80px">
            <div class="row ">
                <div class="col-12 col-md-12 col-lg-6 ">
                    <div class="download-app-sms ">
                        <h4>NHẬP SỐ ĐIỆN THOẠI ĐỂ NHẬN CÁC ƯU ĐÃI MỚI NHẤT</h4>
                    </div>
                    <div class="input-group mb-3 ">
                        <span class="input-group-text " id="basic-addon1 ">
                            <img src="https://tea-3.lozi.vn/v1/statics/resized/country-flag-vn-1570251233 "
                                style="height: 28px; margin: -4px 8px -4px 0; " alt=" ">+84
                        </span>
                        <input type="text " class="form-control " placeholder="Nhập số điện thoại... "
                            aria-label="Username " aria-describedby="basic-addon1 ">
                        <span class="input-group-text ">
                            <button type="submit " class="btn btn-danger ">Gửi</button>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6 ">
                    <div class="download-app ">
                        <h4>TẢI ỨNG DỤNG NGAY TRÊN</h4>
                        <div class="row ">
                            <div class="col-6 col-md-6 col-lg-6 ">
                                <a href=" ">
                                    <img src="https://loship.vn/dist/images/app-ios.png " alt=" ">
                                </a>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6 ">
                                <a href=" ">
                                    <img src="https://loship.vn/dist/images/app-android.png " alt=" ">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->
            <section class="footer">
                <div class="row ">
                    <div class="col-12 col-md-12 col-lg-4">
                        <ul class="list-group">
                            <li class="list-group fs-5">
                                <b>Về Chúng Tôi</b>
                            </li>
                            @foreach ($config_web as $v_config_web)
                                @if ($v_config_web->config_type == 1)
                                    <li class="list-group pb-3 pt-2">{{ $v_config_web->config_title }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="col-12 ">
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <ul class="list-group ">
                                        <li class="list-group fs-5">
                                            <b>Dịch vụ</b>
                                        </li>
                                        @foreach ($config_web as $v_config_web)
                                            @if ($v_config_web->config_type == 2)
                                                <li class="list-group pb-3 pt-2">{{ $v_config_web->config_title }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <ul class="list-group ">
                                        <li class="list-group fs-5">
                                            <b>Hợp tác</b>
                                        </li>
                                        @foreach ($config_web as $v_config_web)
                                            @if ($v_config_web->config_type == 3)
                                                <li class="list-group pb-3 pt-2">{{ $v_config_web->config_title }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <ul class="list-group ">
                                        <li class="list-group fs-5">
                                            <b>Khu vực</b>
                                        </li>
                                        @foreach ($config_web as $v_config_web)
                                            @if ($v_config_web->config_type == 4)
                                                <li class="list-group pb-3 pt-2">{{ $v_config_web->config_title }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <ul class="list-group ">
                                        <li class="list-group fs-5">
                                            <b>Media</b>
                                        </li>
                                        @foreach ($config_web as $v_config_web)
                                            @if ($v_config_web->config_type == 5)
                                                <li class="list-group pb-3 pt-2">{{ $v_config_web->config_title }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </footer>

    
</body>

</html>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js "
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk " crossorigin="anonymous ">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js "
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK " crossorigin="anonymous ">
</script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.js "></script>
<script src="{{ asset('public/frontend/assets/js/main.js') }} "></script> --}}

    {{-- Slider --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('public/frontend/assets/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>

{{-- Captcha --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{{-- Thư viện add to cart --}}
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

{{-- Toastr --}}
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

<script>
    function message_toastr(type, content) {
        Command: toastr[type](content)
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>

{{-- Thông tin vận chuyển --}}
<script>
    Validator({
        form: '.form-info-shipping',
        errorSelector: '.form-message',
        rules: [
            Validator.isRequired('#name_user', 'Vui lòng nhập tên của bạn'),
            Validator.isRequired('#phone_user', 'Vui lòng nhập số điện thoại của bạn'),
            Validator.minLength('#phone_user', 10),
            Validator.maxLength('#phone_user', 10),
            Validator.isRequired('#email', 'Vui lòng nhập email của bạn'),
            Validator.isRequired('#city', 'Vui lòng chọn thông tin'),
            Validator.isRequired('#province', 'Vui lòng chọn thông tin'),
            Validator.isRequired('#wards', 'Vui lòng chọn thông tin'),
            Validator.isRequired('#address', 'Vui lòng điền địa điểm của bạn'),
        ]
    });

    // $(':input[type="submit"]').prop('disabled', true);
    //     $('.form-control').change(function() {
    //         if ($('#name_user').val() != '' && $('#phone_user').val() != '' && $('#city').val() != '' && $('#province').val() != '' && $('#wards').val() != '' && $('#address').val() != '') {
    //         $(':input[type="submit"]').prop('disabled', false);
    //     }
    // });
</script>

{{-- Đăng ký --}}
<script>
    Validator({
        form: '.form-register',
        errorSelector: '.form-message',
        rules: [
            Validator.isRequired('#fullname', 'Vui lòng nhập tên đầy đủ của bạn'),
            Validator.isRequired('#email', 'Vui lòng nhập email của bạn'),
            Validator.isRequired('#phonenumber', 'Vui lòng nhập số điện thoại của bạn'),
            // Validator.isNumber('#phonenumber', 'Số điện thoại không hợp lệ'),
            Validator.isEmail('#email'),
            Validator.minLength('#password', 6),
            Validator.minLength('#phonenumber', 10),
            Validator.maxLength('#phonenumber', 10),
            Validator.isRequired('#password_confirmation'),
            Validator.isConfirmed('#password_confirmation', function() {
                return document.querySelector('#form-register #password').value;
            }, 'Mật khẩu nhập lại không chính xác')
        ]
    });
    // $(':input[type="submit"]').prop('disabled', true);
    //     $('.form-control').change(function() {
    //         if ($('#fullname').val() != '' && $('#email').val() != '' && $('#phonenumber').val() != '' && $('#email').val() != '' && $('#password').val() != '' && $('#password_confirmation').val() != '') {
    //         $(':input[type="submit"]').prop('disabled', false);
    //     }
    // });
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

{{-- <script>
    var mainImg = document.getElementById('mainImg');
    var smalling = document.getElementsByClassName('small-img');
    smalling[0].onclick = function() {
        mainImg.src = smalling[0].src;
    }
    smalling[1].onclick = function() {
        mainImg.src = smalling[1].src;
    }
    smalling[2].onclick = function() {
        mainImg.src = smalling[2].src;
    }
</script> --}}


