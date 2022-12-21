@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
    </div>
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-2" style="    float: right;
                margin-bottom: 33px;">
                    <div class="input-group">
                        <a style="text-decoration: none" href="{{ URL::to('admin/category/list-deleted-category') }}">
                            <button id="bin" type="button" class="btn btn-gradient-danger btn-icon-text">
                            </button>
                        </a>
                    </div>
                </div>
                <h1 class="card-title">Liệt kê thể loại</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #ID </th>
                            <th style="font-weight: bold;"> Tên thể loại </th>
                            <th style="font-weight: bold;"> Ảnh thể loại </th>
                            <th style="font-weight: bold;"> Hiển thị </th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody id="all-category">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    <script>
        load_category();
        load_count_bin();
        function load_category() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/admin/category/load-category') }}' ,
                method: 'GET',
                data: {
                    _token: _token
                },
                success: function(data) {
                    $('#all-category').html(data);
                },
                error: function() {
                    alert('Error Load Category');
                }
            });
        }
    </script>

    <script>
        load_count_bin();
        $(document).on('click', '.delete-category', function() {
            var delete_id = $(this).data('category_id');
            message_toastr("success", 'Xác Nhận Xóa Thể Loại ID ' + delete_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-category_id="' +
                delete_id + '">Xóa</button>');
        });

        $(document).on('click', '.confirm-delete', function() {
            var delete_id = $(this).data('category_id');
            $.ajax({
                url: '{{ url('/admin/category/delete-category') }}',
                method: 'get',
                data: {
                    delete_id: delete_id,
                },
                success: function(data) {
                    load_count_bin();
                    load_category();
                    message_toastr("success", "Thể Loại ID " + delete_id + " Đã Chuyển Vào Thùng Rác");
                },
                error: function() {
                    alert('lỗi ');
                }
            });
        });

        function load_count_bin() {
            $.ajax({
                url: '{{ url('/admin/category/count-bin-category') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#bin').html('<i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Thùng Rác');
                    } else {
                        $('#bin').html(
                            '<i class="mdi mdi-delete-sweep btn-icon-prepend"></i> Thùng Rác <div style="width: 20px;height: 20px;background-color:red;display: flex;justify-content: center;align-items: center;position: absolute;border-radius: 10px;right: 10%;top:10%"><b>' +
                            data + '</b></div>');
                    }
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
    </script>
@endsection
