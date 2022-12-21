@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Thống Kê
        </h3>
        <?php
        $today = date('d/m/Y');
        echo '<span><i class="mdi mdi-calendar"></i>' . $today . '</span>';
        
        ?>
    </div>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('/public/backend/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Doanh Thu Hàng Tuần <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">$ 15,0000</h2>
                    <h6 class="card-text">Increased by 60%</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('/public/backend/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Đơn Đặt Hàng Tuần<i
                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">45,6334</h2>
                    <h6 class="card-text">Decreased by 10%</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('/public/backend/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Khách Hàng Đang Online <i
                            class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">95,5741</h2>
                    <h6 class="card-text">Increased by 5%</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h4 class="card-title float-left">Thống Kê Doanh Số</h4>
                        <div id="visit-sale-chart-legend"
                            class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <input name="order_start" type="text" class="form-control" id="datepicker_start" placeholder="Ngày Bắt Đầu">
                            <span class="form-message text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <input name="order_end" type="text" class="form-control" id="datepicker_end" placeholder="Ngày Kết Thúc">
                            <span class="form-message text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-danger btn-filter">
                            <i class="mdi mdi-magnify"></i> Lọc
                            </button>
                        </div>
                    </div>
                    <div id="myfirstchart" ></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Huỳnh Nhuận, Thành Tiến và Hoàng
                Phố</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">Công Nghệ Và Lập Trình Web 2022</span>
        </div>
    </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Biểu Đồ Cột --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        new Morris.Bar({
            element: 'myfirstchart',
            data: [{
                    year: '2008',
                    value: 20
                },
                {
                    year: '2009',
                    value: 10
                },
                {
                    year: '2010',
                    value: 5
                },
                {
                    year: '2011',
                    value: 5
                },
                {
                    year: '2012',
                    value: 20
                }
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'year',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value']
        });
    </script>
    <script>
        $(document).on('click', '.btn-filter', function(){
            var from_date = $('#datepicker_start').val();
            var to_date = $('#datepicker_end').val();
            $.ajax({
                url: '{{ url('/admin/dashboard/filter-by-date') }}',
                method: 'get',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                },
                success: function(data) {
                    
                },
                error: function() {
                    alert('lỗi Dashboard');
                }
            });
        });
    </script>
@endsection
