<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('public/backend/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/css/style.css') }}">
    <script src="{{ asset('/public/backend/ckeditor/ckeditor.js') }}"></script>
    {{-- <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script> --}}
    <script src="{{ asset('/public/backend/js/jquery.form-validator.min.js') }}"></script>
    <!-- End layout styles -->
    {{-- <link rel="shortcut icon" href="{{ asset('public/backend/images/') }}" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Toastr --}}
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container-scroller">
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
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html"><img
                        src="{{ asset('/public/backend/images/logo.svg') }}" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img
                        src="{{ asset('/public/backend/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <div class="search-field d-none d-md-block">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search projects">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href=""
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{ asset('public/backend/images/faces/face1.jpg') }}" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">
                                    <?php
                                    $name = Session::get('admin_name');
                                    if ($name) {
                                        echo $name;
                                    }
                                    ?>
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ URL::to('/signout-admin') }}">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block full-screen-link">
                        <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-logout d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-format-line-spacing"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="{{ asset('/public/backend/images/faces/face1.jpg') }}" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2">
                                    <?php
                                    $name = Session::get('admin_name');
                                    if ($name) {
                                        echo $name;
                                    }
                                    ?>
                                </span>
                                <span class="text-secondary text-small">Qu???n l?? d??? ??n</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    {{-- @test() --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('/admin') }}">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    {{-- @endtest --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-order" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? ????n h??ng</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-clipboard-text menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-order">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/order/manager-order') }}">????n h??ng </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-customers"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? kh??ch h??ng</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-account-multiple menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-customers">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/customer/all-customers') }}">Danh s??ch kh??ch h??ng</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/customer/send-mail-customers') }}">G???i Mail kh??ch
                                        h??ng</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-order-gallery"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? Slider</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-image-multiple menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-order-gallery">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/slider/add-slider') }}">Th??m
                                        Slider</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-order-feeship"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Ph?? v???n chuy???n</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-truck-delivery menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-order-feeship">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/admin/feeship/delivery') }}">Qu???n l??
                                        v???n chuy???n </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-brand" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? th??? lo???i</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-seal menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-brand">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/category/add-category') }}">Th??m
                                        th??? lo???i</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/category/all-category') }}">Li???t
                                        k?? th??? lo???i</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-food" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? c??c m??n ??n</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi mdi-food menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-food">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/food/add-food') }}">Th??m c??c
                                        m??n ??n</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/food/all-food') }}">Li???t k??
                                        c??c m??n ??n</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/food/all-food-sale') }}">C??c m??n
                                        khuy???n m??i &nbsp;<i class="mdi mdi-sale"></i> </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-2" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">M?? gi???m gi?? </span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-sale menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-2">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/coupon/insert-coupon') }}">Th??m m?? gi???m gi??</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/coupon/list-coupon') }}">Li???t k?? m?? gi???m gi??</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-news" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Qu???n l?? b??i vi???t</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-newspaper menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-news">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/news/add-news') }}">Th??m b??i vi???t</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/news/all-news') }}">Li???t k?? b??i vi???t</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-configweb" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">C???u h??nh web</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-table-edit menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-configweb">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/admin/configweb/add-configweb') }}">C???u h??nh trang web</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    {{-- <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                        </span> Dashboard
                    </h3>
                </div> --}}
                    @yield('main_admin')

                    <footer class="footer">
                        <div class="container-fluid d-flex justify-content-between">
                            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">
                                Hu???nh Nhu???n
                            </span>
                            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">C??ng ngh??? v?? l???p tr??nh
                                web</span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('/public/backend/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('/public/backend/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('/public/backend/js/jquery.cookie.js') }}" type="text/javascript"></script>
    {{-- JQUERY DATE --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('/public/backend/js/off-canvas.js') }}"></script>
    <script src="{{ asset('/public/backend/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('/public/backend/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('/public/backend/js/dashboard.js') }}"></script>
    <script src="{{ asset('/public/backend/js/todolist.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/main.js') }} "></script>

    <!-- End custom js for this page -->

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

    {{-- Category --}}
    <script>
        Validator({
            form: '#form-category',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#name_category', 'Vui l??ng nh???p t??n t??n danh m???c'),
                Validator.isRequired('#image_category', 'Vui l??ng ch???n ???nh'),
            ]
        });

        $(':input[type="submit"]').prop('disabled', true);
        $('.form-control').change(function() {
            if ($('#name_category').val() != '' && $('#image_category').val() != '') {
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
    </script>

    {{-- Food --}}
    <script>
        Validator({
            form: '#form-food',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#name_food', 'Vui l??ng nh???p t??n t??n m??n'),
                Validator.isRequired('#price_food', 'Vui l??ng ??i???n gi?? m??n'),
                Validator.isRequired('#image_food', 'Vui l??ng ch???n ???nh'),
                Validator.isRequired('#desc_food', 'Vui l??ng ??i???n m?? t??? m??n'),
                Validator.isRequired('#content_food', 'Vui l??ng ??i???n n???i dung m??n'),
                Validator.isRequired('#number_food', 'Vui l??ng ??i???n s??? gi???m'),
            ]
        });

        $(':input[type="submit"]').prop('disabled', true);
        $('.form-control').change(function() {
            if ($('#name_food').val() != '' && $('#price_food').val() != '' && $('#image_food').val() != '' && $(
                    '#desc_food').val() != '' && $('#number_food').val() != '') {
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
    </script>

    {{-- Coupon --}}
    <script>
        Validator({
            form: '#form-coupon',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#name_coupon', 'Vui l??ng nh???p t??n m?? gi???m gi??'),
                Validator.isRequired('#code_coupon', 'Vui l??ng ??i???n m?? gi???m gi??'),
                Validator.isRequired('#qty_coupon', 'Vui l??ng ??i???n s??? l?????ng m?? gi???m gi??'),
                Validator.isRequired('#number_coupon', 'Vui l??ng ??i???n s??? gi???m'),
            ]
        });

        $(':input[type="submit"]').prop('disabled', true);
        $('.form-control').change(function() {
            if ($('#name_coupon').val() != '' && $('#code_coupon').val() != '' && $('#time_coupon').val() != '' &&
                $('#number_coupon').val() != '') {
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
    </script>

    {{-- Set up ng??y gi???m gi?? --}}
    <script>
    $("#datepicker_start").datepicker({
        numberOfMonths: 1,
        dateFormat: 'yy/m/dd',
        onSelect: function(selectdate) {
            var dt = new Date(selectdate);
            dt.setDate(dt.getDate() + 1)
            $("#datepicker_end").datepicker("option", "minDate", dt);
        }
    });
  
    $("#datepicker_end").datepicker({
        numberOfMonths: 1,
        dateFormat: 'yy/m/dd',
        onSelect: function(selectdate) {
            var dt = new Date(selectdate);
            dt.setDate(dt.getDate() - 1)
            $("#datepicker_start").datepicker("option", "maxDate", dt);
        }
    });
    </script>


</body>

</html>
