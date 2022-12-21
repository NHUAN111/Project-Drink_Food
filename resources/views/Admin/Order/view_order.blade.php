@extends('admin.admin_layout')
@section('main_admin')
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Thông tin người mua (Tài khoản khách)</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #ID </th>
                            <th style="font-weight: bold;"> Tên khách hàng</th>
                            <th style="font-weight: bold;"> Email khách hàng </th>
                            <th style="font-weight: bold;"> Số điện thoại </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($all_order as $key => $value_order) --}}
                        <tr class="table">
                            <?php 
                                if($order_byId->customer_id == 0){
                            ?>
                                <td>#0</td>
                                <td>Khách vãng lai</td>
                                <td>Trống</td>
                                <td>Trống</td>
                            <?php 
                                }else{
                            ?>
                                <td>{{ $order_byId->customer->customer_id }}</td>
                                <td>{{ $order_byId->customer->customer_name }}</td>
                                <td>{{ $order_byId->customer->customer_email }}</td>
                                <td>{{ $order_byId->customer->customer_phone }}</td>
                            <?php 
                                }
                            ?>
                            {{-- @endforeach --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br><br>

    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Thông tin giao hàng (Khách hàng)</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #ID </th>
                            <th style="font-weight: bold;"> Tên </th>
                            <th style="font-weight: bold;"> Địa chỉ </th>
                            <th style="font-weight: bold;"> Số điện thoại </th>
                            <th style="font-weight: bold;"> Email khách hàng</th>
                            <th style="font-weight: bold;"> Ghi chú * </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table">
                            <td>{{ $order_byId->shipping->shipping_id }}</td>
                            <td>{{ $order_byId->shipping->shipping_name }}</td>
                            <td>{{ $order_byId->shipping->shipping_address }}</td>
                            <td>{{ $order_byId->shipping->shipping_phone }}</td>
                            <td>{{ $order_byId->shipping->shipping_email }}</td>
                            <?php 
                                if( $order_byId->shipping->shipping_notes == NULL){
                            ?>
                            <td>Không yêu cầu</td>
                            <?php 
                                }else{
                            ?>
                            <td>{{ $order_byId->shipping->shipping_notes }}</td>
                            <?php 
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <br><br>

    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Liệt kê chi tiết đơn hàng</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> #Mã đơn hàng </th>
                            <th style="font-weight: bold;"> Tên sản phẩm</th>
                            <th style="font-weight: bold;"> Số lượng </th>
                            <th style="font-weight: bold;"> Mã giảm </th>
                            <th style="font-weight: bold;"> Giá </th>
                            <th style="font-weight: bold;"> Tổng </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total = 0;
                        ?>
                        @foreach ($order_detailId as $key => $value_order_detail)
                            {{-- Lấy giá từng sản phẩm --}}
                                <?php 
                                    $qty = $value_order_detail->food_sales_quantity;
                                    $price = $value_order_detail->food_price;
                                    $subtotal = $qty * $price;
                                    $total += $subtotal;
                                ?>
                            <tr class="table">
                                <td>{{ $value_order_detail->order_code }}</td>
                                <td>{{ $value_order_detail->food_name }}</td>
                                <td>{{ $value_order_detail->food_sales_quantity }}</td>
                                <td>
                                    @if($order_byId->order_coupon == 0)
                                        Không có mã giảm
                                    @else
                                        {{ $order_byId->order_coupon }}
                                    @endif
                                </td>
                                <td>{{ number_format($value_order_detail->food_price, 0, ',', '.') . ' ' . ' đ' }}</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') . ' ' . ' đ' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                            <span style="color: red; font-weight: bold">Tổng các món: &nbsp; </span>
                            {{ number_format($total, 0, ',', '.') . ' ' . ' đ' }}
                        </div>

                        @if ($order_byId->order_coupon)
                            <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                                <span style="color: red; font-weight: bold">Số giảm: &nbsp; </span>
                                @if($coupon_condition == 1 )
                                    - {{ number_format($order_byId->coupon_price, 0, ',', '.') . ' %' }}
                                @elseif($coupon_condition == 2)
                                - {{ number_format($order_byId->coupon_price, 0, ',', '.') . ' đ' }} 
                                @endif
                            </div>
                        @elseif($order_byId->order_coupon == 0)
                            <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                                <span style="color: red; font-weight: bold">Số giảm: &nbsp; </span>
                                Không có mã giảm
                            </div>
                        @endif

                        <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                            <span style="color: red; font-weight: bold">Phí vận chuyển: &nbsp; </span>
                            + {{ number_format($order_byId->order_feeship, 0, ',', '.') . ' ' . ' đ' }}
                        </div>

                        {{-- Tồn tại coupon --}}
                        @if ($order_byId->order_coupon)
                            @php
                                $total_coupon = 0;
                            @endphp
                            @if ($coupon_condition == 1)
                                @php
                                    $total_coupon = ($total * $order_byId->coupon_price) / 100;
                                    $total = ($total - $total_coupon) + $order_byId->order_feeship;
                                @endphp
                                <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                                    <span style="color: red; font-weight: bold">Tổng Đơn Hàng: &nbsp; </span>
                                    {{ number_format($total, 0, ',', '.') . ' ' . ' đ' }}
                                </div>
                            @else
                                @php
                                    $total = ($total - $order_byId->coupon_price) + $order_byId->order_feeship;
                                @endphp
                                <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                                    <span style="color: red; font-weight: bold">Tổng Đơn Hàng: &nbsp; </span>
                                    {{ number_format($total, 0, ',', '.') . ' ' . ' đ' }}
                                </div>
                            @endif
                        {{-- Không tồn tại coupon --}}
                        @elseif($order_byId->order_coupon == 0)
                            @php
                                $total_order_notcoupon = $total + $order_byId->order_feeship;
                            @endphp
                            <div style="display: flex; justify-content: flex-start; margin-top: 10px;">
                                <span style="color: red; font-weight: bold">Tổng Đơn Hàng: &nbsp; </span>
                                {{ number_format($total_order_notcoupon, 0, ',', '.') . ' ' . ' đ' }}
                            </div>
                        @endif
                        <div class="mt-2">
                            <a href="{{ url('/admin/order/print-order?order_code='.$order_byId->order_code) }}">
                                <button type="button" class="btn-sm btn-gradient-info btn-icon-text">
                                    <i class="mdi mdi-printer"></i> In Hoá Đơn
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
