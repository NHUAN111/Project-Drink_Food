@extends('admin.admin_layout')
@section('main_admin')
<div class="col-lg-12 stretch-card">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Chỉnh sữa mã giảm giá </h3>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" id="form-coupon" action="{{ URL::to('/admin/coupon/update-coupon-code?coupon_id='.$edit_coupon->coupon_id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="exampleInputUsername1">Tên mã giảm giá</label>
                  <input  name="coupon_name" value="{{ $edit_coupon->coupon_name }}" type="text" class="form-control" id="name_coupon">
                  <span class="form-message text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Mã giảm giá</label>
                    <input  name="coupon_code"  value="{{ $edit_coupon->coupon_code }}" type="text" class="form-control" id="code_coupon">
                    <span class="form-message text-danger"></span>
                </div>
                  <div class="form-group">
                    <label for="exampleInputUsername1">Số lượng mã giảm giá</label>
                    <input  name="coupon_qty"  value="{{ $edit_coupon->coupon_qty }}" type="text" class="form-control" id="qty_coupon">
                    <span class="form-message text-danger"></span>
                  </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Tính năng </label>
                  <div>
                    <select name="coupon_condition" id="" class="form-control" id="condition_coupon">
                        @if($edit_coupon->coupon_condition == 1)
                            <option value="1">Giảm theo phần trăm</option>
                            <option value="2">Giảm theo tiền</option>
                        @else
                            <option value="2">Giảm theo tiền</option>
                            <option value="1">Giảm theo phần trăm</option>
                        @endif
                      </select>
                    <span class="form-message text-danger"></span>
                  </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Nhập số % hoặc số tiền giảm</label>
                    <input name="coupon_number" value="{{ $edit_coupon->coupon_number }}" class="form-control" id="number_coupon"> 
                    <span class="form-message text-danger"></span>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="exampleInputUsername1">Thời gian bắt đầu</label>
                      <input name="coupon_start" value="{{ $edit_coupon->coupon_start }}" type="text" class="form-control" id="datepicker_start">
                      <span class="form-message text-danger"></span>
                    </div>
                    <div class="col-md-6">
                      <label for="exampleInputUsername1">Thời gian kết thúc</label>
                      <input name="coupon_end" value="{{ $edit_coupon->coupon_end }}" type="text" class="form-control" id="datepicker_end">
                      <span class="form-message text-danger"></span>
                    </div>
                </div>
                <button class="btn btn-gradient-primary me-2 ">Cập nhật</button>
                <button class="btn btn-light">Thoát</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection