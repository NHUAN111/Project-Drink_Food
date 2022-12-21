@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Cấu Hình
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="mdi mdi-timetable"></i>
                    <span><?php
                    $today = date('d/m/Y');
                    echo $today;
                    ?></span>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/configweb/add-configweb-logo') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <h4 for="formFile" class="form-label">Thêm Logo Web</h4>
                                <input class="form-control" type="file" name="config_image">
                            </div>
                        </div>
                        <div>
                            <div class="row ml-2">
                                <button type="submit" class="btn btn-primary col-lg-3">Thêm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex;justify-content: space-between">
                        <div class="card-title col-sm-9">Logo Trang Web </div>
                        <div class="col-sm-3" style="display: flex;justify-content: center">
                        </div>
                    </div>
                    <div class="col-lg-7" id="load-logo">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Footer trang web </div>
                </div>
                <form>
                    @csrf
                    <div class="form-group mt-2">
                        <label for="">Chọn mục</label>
                        <select name="config_type" class="form-control config_type p-3" id="exampleInputUsername1">
                            <option value="1">Về Chúng Tôi</option>
                            <option value="2">Dịch vụ</option>
                            <option value="3">Hợp tác</option>
                            <option value="4">Khu vực</option>
                            <option value="5">Media</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nội dung</label>
                        <input name="config_title" type="text" class="form-control config_title" id="name_category"
                            placeholder="Điền tiêu đề">
                        <span class="form-message text-danger"></span>
                    </div>
                    <button type="button" class="btn btn-gradient-primary me-2 add-config-type">Thêm</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="form-group mt-2">
                    <h4 for="">Chọn Mục</h4>
                    <select name="config_type" class="form-control btn-choose-type p-3" id="exampleInputUsername1">
                        <option value="1">Về Chúng Tôi</option>
                        <option value="2">Dịch vụ</option>
                        <option value="3">Hợp tác</option>
                        <option value="4">Khu vực</option>
                        <option value="5">Media</option>
                    </select>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <th class="fw-bold"> #STT </th>
                        <th class="fw-bold">Danh mục</th>
                        <th class="fw-bold">Tiêu đề</th>
                        <th class="fw-bold">Thao Tác</th>
                    </thead>
                    <tbody id="load-footer">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    {{-- Load logo --}}
    <script>
            load_logo();
            function load_logo() {
                $.ajax({
                    url: '{{ url('/admin/configweb/load-configweb-logo') }}',
                    method: 'GET',
                    data: {},
                    success: function(data) {
                        $('#load-logo').html(data);
                    },
                    error: function() {
                        alert('Error Load Load logo');
                    }
                });
            }

            $(document).on('change', '.up_load_file', function() {
                var config_id = $(this).data('id');
                var img = document.getElementById('up_load_file' + config_id).files[0];

                var form_data = new FormData();
                form_data.append("file", img);
                form_data.append("config_id", config_id);

                $.ajax({
                    url: '{{ url('/admin/configweb/update-configweb-logo') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        load_logo();
                        message_toastr("success", "Cập Nhật Logo Thành Công !");
                    },
                    error: function() {
                        alert('lỗi Logo');
                    },
                });
            });
    </script>

    <script>
        // Load footer
        var config_type = '{{ $config_web->config_type }}';
        load_config_footer(config_type);
        function load_config_footer(config_type) {
            $.ajax({
                url: '{{ url('/admin/configweb/load-configweb-footer') }}',
                method: 'GET',
                data: {
                    config_type: config_type,
                },
                success: function(data) {
                    $('#load-footer').html(data);
                },
                error: function() {
                    alert('Error Load Load Footer');
                }
            });
        }

        $(document).on('click', '.add-config-type', function() {
            var config_type = $('.config_type').val();
            var config_title = $('.config_title').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/admin/configweb/insert-configweb-footer') }}',
                method: 'GET',
                data: {
                    config_type: config_type,
                    config_title: config_title,
                    _token: _token,
                },
                success: function(data) {
                    load_config_footer(config_type);
                    message_toastr("success", "Thêm thành công");
                },
                error: function() {
                    alert('Error Load Load Footer');
                }
            });
        });

        $(document).on('blur', '.edit_config_title', function() {
            var config_id = $(this).data('config_id');
            var config_title = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/admin/configweb/edit-configweb-footer') }}',
                method: 'get',
                data: {
                    config_id: config_id,
                    config_title: config_title,
                    _token: _token,
                },
                success: function(data) {
                    load_config_footer(config_type);
                    message_toastr("success", "Cập nhật thành công");
                },
                error: function() {
                    alert('Error Load Load Footer');
                }
            });
        });

        $('.btn-choose-type').click(function() {
            config_type = $(this).val();
            load_config_footer(config_type);
        });

        $(document).on('click', '.btn-delete-footer', function() {
            var config_id = $(this).data('id');
            message_toastr("success", 'Xác Nhận Xóa ID ' + config_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-id="' +
                config_id + '">Xóa</button>');
        });

        $(document).on('click', '.confirm-delete', function() {
            var config_id = $(this).data('id');
            $.ajax({
                url: '{{ url('/admin/configweb/delete-configweb-footer') }}',
                method: 'get',
                data: {
                    config_id: config_id,
                },
                success: function(data) {
                    load_config_footer(config_type);
                    message_toastr("success", "Cấu Hình ID " + config_id + " đã xoá thành công");
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });
    </script>

@endsection
