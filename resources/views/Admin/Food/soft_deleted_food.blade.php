@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Thùng Rác
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

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Bảng Danh Sách Món</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input id="search" type="text" class="form-control" name="search"
                                placeholder="Tìm Kiếm ID Hoặc Tên Món">
                            <button type="button" class="btn-md btn-inverse-success btn-icon">
                                <i class="mdi mdi-account-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th> Ảnh</th>
                            <th> Tên Món </th>
                            <th> Giá  </th>
                            <th> Số Giảm  </th>
                            <th> Giá Cuối  </th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody id="loading-table-food">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        loading_table_food();
        function loading_table_food(){
            $.ajax({
                url: '{{ url('/admin/food/load-bin-food') }}' ,
                method: 'GET',
                data: {
                },
                success: function(data) {
                    $('#loading-table-food').html(data);
                },
                error: function() {
                    alert('Error Load food');
                }
            });
        }
    </script>

    <script>
        $(document).on("click", ".btn-restore-item", function() {
            var item_id = $(this).data('item_id');
            message_toastr("success", 'Xác Nhận Khôi Phục Món ID ' + item_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-restore" data-item_id="' +
                item_id + '">Khôi Phục</button>');

        })
        
        $(document).on("click", ".confirm-restore", function() {
            $(".loading").css({
                "display": "block"
            });
            $(".overlay-loading").css({
                "display": "block"
            });
            var item_id = $(this).data('item_id');
            setTimeout(restore_item(item_id), 1000);
        })

        function restore_item(item_id) {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/admin/food/restore-food') }}',
                method: 'POST',
                data: {
                    food_id: item_id,
                },
                success: function(data) {
                    $(".loading").css({
                        "display": "none"
                    });
                    $(".overlay-loading").css({
                        "display": "none"
                    });
                    message_toastr("success", "Món Có ID " + item_id + " Đã Được Khôi Phục!");
                    loading_table_food();
                },
                error: function() {
                    $(".loading").css({
                        "display": "none"
                    });
                    $(".overlay-loading").css({
                        "display": "none"
                    });
                    alert("Bug Huhu :<<");
                }
            })
        }


        $(document).on("click", ".btn-delete-item", function() {
            var item_id = $(this).data('item_id');
            message_toastr("success", 'Xác Nhận Xóa Vĩnh Viễn Món ID ' + item_id +
                '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete-bin" data-item_id="' +
                item_id + '">Xóa Vĩnh Viễn</button>');

        })

        $(document).on("click", ".confirm-delete-bin", function() {
            $(".loading").css({
                "display": "block"
            });
            $(".overlay-loading").css({
                "display": "block"
            });
            var item_id = $(this).data('item_id');
            setTimeout(delete_trash_item(item_id), 1000);
        })

        function delete_trash_item(item_id) {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('/admin/food/delete-trash-food') }}',
                method: 'POST',
                data: {
                    food_id: item_id,
                },
                success: function(data) {
                    $(".loading").css({
                        "display": "none"
                    });
                    $(".overlay-loading").css({
                        "display": "none"
                    });
                    message_toastr("success", "Món Có ID " + item_id + " Đã Được Xóa Vĩnh Viển!");
                    loading_table_food();
                },
                error: function() {
                    $(".loading").css({
                        "display": "none"
                    });
                    $(".overlay-loading").css({
                        "display": "none"
                    });
                    alert("Bug Huhu :<<");
                }
            })
        }
    </script>
@endsection
