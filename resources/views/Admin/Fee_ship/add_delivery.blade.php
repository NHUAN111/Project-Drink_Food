@extends('admin.admin_layout')
@section('main_admin')
    <div class="col-lg-12 stretch-card">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Thêm phí vận chuyển </h3>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h1 class="card-title">Điền thông tin thể loại</h1> --}}
                            <form>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn thành phố</label>
                                    <div>
                                        <select name="city" id="city" class="form-control choose city"
                                            id="exampleInputUsername1">
                                            <option value>--Chọn tỉnh thành phố--</option>
                                            @foreach ($city as $key => $v_city)
                                                <option value="{{ $v_city->matp }}">{{ $v_city->name_city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn quận huyện</label>
                                    <div>
                                        <select name="province" id="province" class="form-control choose province"
                                            id="exampleInputUsername1">
                                           <option value="">--Chọn quận huyện--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn xã phường</label>
                                    <div>
                                        <select name="wards" id="wards" class="form-control wards" id="exampleInputUsername1">
                                           <option>--Chọn xã phường--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Phí vận chuyển</label>
                                    <input name="fee_ship" type="text" class="form-control fee_ship" id="exampleInputUsername1" >
                                </div>
                                <button type="button" class="btn btn-gradient-primary me-2 add_delivery" >Thêm phí vận chuyển</button>
                                <button class="btn btn-light">Thoát</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Phí vận chuyển các địa điểm </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 stretch-card" id="load-delivery">
                
            </div>
        </div>
    </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Phí Ship --}}
    <script>
        $(document).on('click', '.delete-feeship', function(){
        var delete_id = $(this).data('feeship_id');
        message_toastr("success", 'Xác Nhận Xóa Phí Vận Chuyển ID ' + delete_id +'?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-feeship_id="' +
        delete_id + '">Xóa</button>');
    });

            $(document).on('click', '.confirm-delete', function() {
                var delete_id = $(this).data('feeship_id');
                $.ajax({
                    url: '{{ url('/admin/feeship/delete-delivery') }}',
                    method: 'get',
                    data: {
                        delete_id: delete_id,
                    },
                    success: function(data) {
                        fetch_delivery();
                        message_toastr("success", "Phí Vận Chuyển ID "+delete_id+" đã xoá thành công");
                    },
                    error: function() {
                        alert('lỗi ');
                    }
                });
            });
    </script>
    <script>
        // $(document).ready(function() {
            fetch_delivery();
            function fetch_delivery() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/admin/feeship/select-feeship') }}',
                    method: 'get',
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        $('#load-delivery').html(data);
                    },
                    error: function() {
                        alert('lỗi 1');
                    }
                });
            }

            $('.add_delivery').click(function() {
                var city = $('.city').val();
                var province = $('.province').val();
                var wards = $('.wards').val();
                var fee_ship = $('.fee_ship').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ url('/admin/feeship/insert-delivery') }}',
                    method: 'GET',
                    data: {
                        city: city,
                        province: province,
                        wards: wards,
                        fee_ship: fee_ship,
                        _token: _token,
                    },
                    success: function(data) {
                        fetch_delivery();
                        message_toastr("success", "Thêm Phí Vận Chuyển thành công");
                    },
                    error: function() {
                        alert('lỗi 2');
                    }
                });
            });

            $(document).on('blur', '.fee_feeship_edit', function() {
                var feeship_id = $(this).data('feeship_id');
                var fee_value = $(this).text();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/admin/feeship/update-delivery') }}',
                    method: 'POST',
                    data: {
                        feeship_id: feeship_id,
                        fee_value: fee_value,
                        _token: _token,
                    },
                    success: function(data) {
                        fetch_delivery();
                        message_toastr("success", "Cập Nhật Phí Vận Chuyển Thành Công");
                    },
                    error: function() {
                        alert('lỗi 3');
                    }
                });
            });

            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var matp = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/admin/feeship/select-delivery') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        matp: matp,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    },
                    error: function() {
                        alert('lỗi 4');
                    }
                });
            });
        // });
    </script>

@endsection
