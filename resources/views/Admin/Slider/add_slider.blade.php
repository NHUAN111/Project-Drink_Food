@extends('admin.admin_layout')
@section('main_admin')
    <div class="col-lg-12 stretch-card">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Thêm Slider </h3>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample" action="{{ URL::to('/admin/slider/insert-slider') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Ảnh Slider</label>
                                    <input name="file[]" accept="image/*" multiple type="file" class="form-control"
                                        id="file exampleInputUsername1">
                                    <span id="error_slider"></span>
                                </div>
                                <button type="submit" class="btn btn-gradient-primary me-2">Thêm slider</button>
                                <button class="btn btn-light">Thoát</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-header">
                <h3 class="page-title">Liệt kê Slider </h3>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div id="loading-slider">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Slider --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            loading_slider();
            function loading_slider() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/admin/slider/select-slider') }}',
                    method: 'get',
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        $('#loading-slider').html(data);
                    },
                    error: function() {
                        alert('lỗi slide');
                    }
                });
            }

            $(document).on('click', '.delete-slider', function(){
                var delete_id = $(this).data('id');
                message_toastr("success", 'Xác Nhận Xóa Tin ID ' + delete_id +'?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-id="' +
                delete_id + '">Xóa</button>');
            });

            $(document).on('click', '.confirm-delete', function() {
                var delete_id = $(this).data('id');
                $.ajax({
                    url: '{{ url('/admin/slider/delete-slider') }}',
                    method: 'get',
                    data: {
                        delete_id: delete_id,
                    },
                    success: function(data) {
                        loading_slider();
                        message_toastr("success", "Ảnh ID "+delete_id+" đã xoá thành công");
                    },
                    error: function() {
                        alert('lỗi ');
                    }
                });

                $('#file').change(function() {
                    var error = '';
                    var files = $('#file')[0].files;
                    if (files.length > 6) {
                        error += '<span>Tối đa 6 ảnh</span>';
                    } else if (files.length == '') {
                        error += '<span>Không để ảnh trống</span>';
                    } else if (files.size > 2000000) {
                        error += '<span>File không quá 2MB</span>';
                    }

                    if (error == '') {

                    } else {
                        $('#file').val('');
                        $('#error_slider').html('<span class="text-danger"> ' + error + ' </span>');
                        return false;
                    }
                });
            });


            $(document).on('change', '.up_load_file', function() {
                var slider_id = $(this).data('id');
                var img = document.getElementById('up_load_file' + slider_id).files[0];

                var form_data = new FormData();
                form_data.append("file", img);
                form_data.append("slider_id", slider_id);


                $.ajax({
                    url: '{{ url('/admin/slider/update-slider') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        message_toastr("success", "Cập Nhật Ảnh Thành Công !");
                        loading_slider();
                    },
                    error: function() {
                        alert('lỗi ');
                    },
                });
            });


            $(document).on('blur', '.edit_slider_name', function() {
                var slider_id = $(this).data('id');
                var slider_text = $(this).text();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/admin/slider/update-slider-name') }}',
                    method: 'post',
                    data: {
                        slider_id: slider_id,
                        slider_text: slider_text,
                        _token: _token,
                    },
                    success: function(data) {
                        loading_slider();
                        message_toastr("success", "Cập Nhật Tên Ảnh Thành Công !");
                    },
                    error: function() {
                        alert('lỗi');
                    }
                });
            });
        });
    </script>
@endsection
