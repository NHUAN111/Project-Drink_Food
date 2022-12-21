<!doctype html>
<html lang="en">

<head>
    <title>{{ $meta['title'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/responive.css') }}">

    {{-- SEO --}}
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="{{ $meta['canonical'] }}">
    <meta name="author" content="Nhuận Báo Thủ Và Những Người Bạn">
    <link rel="icon" href="{{ asset('public/frontend/assets/img/banner/logo.jpg') }}" sizes="32x32">

    {{-- Library Slider  --}}
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/owlcarousel/assets/owl.carousel.min.css') }}">

    <!-- Icons -->
    <link rel="stylesheet"
        href="{{ asset('public/frontend/assets/fonts/fontawesome-free-6.2.0-web/css/all.min.css') }}">

    {{-- Toastr --}}
    {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> --}}

    {{-- Toastr Css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    {{-- Js Toast  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- Thông Báo Toastr --}}
    <script>
        function message_toastr(type, title, content) {
            Command: toastr[type](title, content)
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
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
                <a href="{{ url('/dang-xuat') }}">
                    <button type="submit" class="btn btn-danger">Đăng xuất</button>
                </a>
                <?php        
                    }else{
                ?>
                <a href="{{ url('/dang-nhap') }}">
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


    {{-- Img main --}}
    <div id="carouselExampleCaptions " class="carousel slide" data-bs-ride="carousel " style="margin-top: 90px; ">
        <div class="carousel-inner ">
            <div class="carousel-item active ">
                <img src="{{ asset('public/frontend/assets/img/banner/banner1.jpg') }} "
                    class="d-block w-100 banner-shop" alt="... ">
                <div class="carousel-caption d-md-block ">
                    <div class="caption-title">
                        <span class="caption-title-top"> ĐẶT MÓN NÀO</span> <br>
                        <span class="caption-title-bottom">CŨNG FREESHIP</span>
                    </div>
                    {{-- <h1 style="color: red; font-weight: 800; font-size: 2.8rem; ">CŨNG FREESHIP</h1> --}}
                    <form class="d-flex " style="justify-content: center; ">
                        <input class="input-search-food" type="search "
                            placeholder="Tìm món ăn, đồ uống yêu thích nào " aria-label="Search ">
                        {{-- <button class="btn btn-outline-drak" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                <a href="#main">
                    <i class="fa-solid fa-house" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-"> Trang Chủ</span>
                </a>
            </li>
            <li>
                <a type="button" class="navbar-item-link text-start" href="{{ url('/chi-tiet-gio-hang') }}">
                    <i class="fa-solid fa-cart-shopping shopping-cart" style="color: rgb(144, 143, 143);"></i>
                    <span class="fs-6 px-">Giỏ Hàng</span>
                    <div id="list-cart">
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
                <a href="#about__me">
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


    {{-- Slider --}}
    <div class="container " style="margin-top: 20px;">
        <div class="slider ">
            <div class="slider-box ">
                <div class="slider-js owl-carousel owl-theme ">
                    @foreach ($all_slider as $key => $v_slider)
                        <div class="item ">
                            <img width="465px " height="220px " style="object-fit: cover;border-radius: 8px; "
                                src="{{ URL::to('public/upload/slider/' . $v_slider->slider_img) }}" alt=" ">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <!-- Thể loại -->
    <div class="container ">
        <div class="the-loai-title pt-4">
            <h4>CHỌN THEO THỂ LOẠI</h4>
        </div>
        <div class="row">
            @foreach ($all_category as $key => $value_category)
                <div class="col-6 col-md-4 col-lg-2 d-flex justify-content-center">
                    <div class="the-loai-link border border-0">
                        <div class="the-loai-img">
                            <img src="public/upload/TheLoai/{{ $value_category->category_img }}" width="120"
                                height="120" alt=" ">
                        </div>
                        <h5>{{ $value_category->category_name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal deatil food-->
    {{-- <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Chi Tiết Món</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loading-food-modal">

                </div>
            </div>
        </div>
    </div> --}}
    <!-- End modal detail food -->

    <!-- Khám phá món mới -->
    <div class="container mt-5">
        <div class="row overflow-hidden">
            <h2 class="fs-5 fw-bold text-uppercase" style="color: #53382c">Mã giảm giá dành cho bạn</h2>
            @foreach ($coupon_time as $coupons)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-2 rounded-3">
                        <div class="card mb-3" style="border-color: #dc3545; position: relative; border-left: 0;">
                            <div class="row g-0">
                                <div
                                    style="position: absolute;
                            width: 34px;
                            height: 34px;
                            border-radius: 50%;
                            background-color: #f6f6f6; 
                            top: 50%;
                            transform: translateY(-50%);
                            left: -18px">
                                </div>
                                <div class="col-4 col-md-4 col-lg-4 rounded-start d-flex justify-content-center align-items-center"
                                    style=" background-image: linear-gradient(#de1c2f, #da6b76);">
                                    <div class="" style="color: #fff">
                                        @if ($coupons->coupon_condition == 1)
                                            <h4 class="card-text d-flex justify-content-center">
                                                {{ $coupons->coupon_number }}% </h4>
                                        @else
                                            <h4 class="card-text">
                                                {{ number_format($coupons->coupon_number, 0, ',', '.') }}đ </h4>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8 col-md-8 col-lg-8">
                                    <div class="card-body">
                                        <p class="card-text" style="font-weight: 600">
                                            {{ $coupons->coupon_name }}
                                        </p>
                                        <h5 class="card-title p-2 rounded-3 text-center"
                                            style="background-image: linear-gradient(#de1c2f, #da6b76); color: #fff">
                                            {{ $coupons->coupon_code }}</h5>
                                        <p class="card-text"><small class=" text-muted ">Từ
                                                {{ $coupons->coupon_start }} Đến {{ $coupons->coupon_end }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>

            @yield('user_main')
        </div>
    </div>

    {{-- <div class="container mt-5">
        <h3 class="fs-5 fw-bold text-uppercase " style="color: #53382c">Về Chúng Tôi</h3>
        <div class="row g-3 g-lg-5">
            <div class="col-lg-6 col-md-12 col-12 about-us-left">
                <a href="">
                    <div class="img-main">
                        <img src="https://file.hstatic.net/1000075078/article/z3663478710700_0f36930c9ad300ade688f7ed1ddbd4f8_ceb536831696441fa7e8d9a2ad990c44_grande.jpg"
                            alt="" width="100%" height="360px" class="rounded">
                    </div>
                    <div class="img-main-title">
                        <span>Tiêu Đề</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-12 col-12 about-us-right">
                <a href="" class="pb-4 px-2 col-lg-6 col-md-12 col-12">
                    <div class="img-item " >
                        <img src="https://file.hstatic.net/1000075078/article/z3663478710700_0f36930c9ad300ade688f7ed1ddbd4f8_ceb536831696441fa7e8d9a2ad990c44_grande.jpg"
                            alt="" class="rounded" width="285px" height="152px">
                    </div>
                    <div class="img-main-title">
                        <span>Tiêu Đề</span>
                    </div>
                </a>
                <a href="" class="pb-4 px-2 col-lg-6 col-md-12 col-12">
                    <div class="img-item " >
                        <img src="https://file.hstatic.net/1000075078/article/z3663478710700_0f36930c9ad300ade688f7ed1ddbd4f8_ceb536831696441fa7e8d9a2ad990c44_grande.jpg"
                            alt="" class="rounded" width="285px" height="152px">
                    </div>
                    <div class="img-main-title">
                        <span>Tiêu Đề</span>
                    </div>
                </a>
                <a href="" class="pb-4 px-2 col-lg-6 col-md-12 col-12">
                    <div class="img-item " >
                        <img src="https://file.hstatic.net/1000075078/article/z3663478710700_0f36930c9ad300ade688f7ed1ddbd4f8_ceb536831696441fa7e8d9a2ad990c44_grande.jpg"
                            alt="" class="rounded" width="285px" height="152px">
                    </div>
                    <div class="img-main-title">
                        <span>Tiêu Đề</span>
                    </div>
                </a>
                <a href="" class="pb-4 px-2 col-lg-6 col-md-12 col-12">
                    <div class="img-item " >
                        <img src="https://file.hstatic.net/1000075078/article/z3663478710700_0f36930c9ad300ade688f7ed1ddbd4f8_ceb536831696441fa7e8d9a2ad990c44_grande.jpg"
                            alt="" class="rounded" width="285px" height="152px">
                    </div>
                    <div class="img-main-title">
                        <span>Tiêu Đề</span>
                    </div>
                </a>
            </div>
        </div>
    </div> --}}


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

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js "
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk " crossorigin="anonymous ">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js "
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK " crossorigin="anonymous ">
    </script>

    {{-- Slider --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('public/frontend/assets/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>

    {{-- Captcha --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    {{-- Toastr --}}
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}

    {{-- Thư viện add to cart --}}
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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
    {{-- <script>
        $(document).ready(function() {
            $('.btn-category').click(function() {
                var category_id = $(this).data('id_category');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/chi-tiet-danh-muc') }}',
                    method: 'GET',
                    data: {
                        category_id: category_id,
                        _token: _token,
                    },
                    success: function(data) {
                        $('#loading-category').html(data);
                    },
                    error: function() {
                        alert('Lỗi ');
                    },
                });
            });
        });
    </script> --}}

    {{-- Không dùng modal nữa --}}
    {{-- <script>
        $(document).on('click', '.btn-food', function() {
            var food_id = $(this).data('id_food');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/chi-tiet-mon') }}',
                method: 'GET',
                data: {
                    food_id: food_id,
                    _token: _token,
                },
                success: function(data) {
                    $('#loading-food-modal').html(data);
                },
                error: function() {
                    alert('Lỗi ');
                },
            });
        });
    </script> --}}

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
                    // alert('Lỗi ạ');
                },
            });
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
                    loading_cart();
                    load_count_cart();
                },
                error: function() {
                    // alert('Lỗi ạ');
                },
            });
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

</body>

</html>
