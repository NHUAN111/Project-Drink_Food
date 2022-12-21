<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail To TAT</title>
</head>
<body>
    <h4> TAT Xin chào {{ $name }} !</h4> 
    <span style="color: green">{{ $type }}</span> <br>
    Mã đơn của bạn là : <span style="color: red; font-weight: bold">{{ $code }}</span> (Kiểm Tra Tình Trạng Đơn Của Bạn)<br>
    <table style="border-collapse: collapse">
        <tr>
            <th style="border: 1px solid #ddd;">Món</th>
            <th style="border: 1px solid #ddd;">Số Lượng</th>
            <th style="border: 1px solid #ddd;">Giá</th>
            <th style="border: 1px solid #ddd;">Thành Tiền</th>
        </tr>
        <?php
            $total = 0;
        ?>
        @foreach ($orderdetail as $key => $v_order_detail)
        <?php 
            $subtotal = $v_order_detail->food_price * $v_order_detail->food_sales_quantity;
            $total += $subtotal;
        ?>
        <tr>
            <td style="border: 1px solid #ddd;">{{ $v_order_detail->food->food_name }}</td>
            <td style="border: 1px solid #ddd;">{{ $v_order_detail->food_sales_quantity }}</td>
            <td class="align-middle">{{ number_format($v_order_detail->food_price, 0, ',', '.') }} đ</td>
            <td style="border: 1px solid #ddd;">{{ number_format( $subtotal, 0,',','.') }} đ</td>
        </tr>
        @endforeach
    </table>

    <span>Phí Ship: {{ number_format($order->order_feeship,0,',','.') }} đ</span> <br>
    <?php if ($order->order_coupon == 0) {
        $fee_ship = $order->order_feeship;
        $total = $total + $fee_ship;
    ?>
        <span>Mã Giảm: Không Có </span> <br>
        <h3>Tổng Đơn: {{  number_format($total,0,',','.')  }}đ</h3> 
    <?php } else {
        $fee_ship = $order->order_feeship;
        $coupon_price = $order->coupon_price; // Số tiền giảm
    ?>
    <?php
        if ($coupon_price <= 100) { // Theo %
        $total_coupon = ($total * $coupon_price) / 100; //Số Tiền Giảm %
        $total = ($total - $total_coupon) + $fee_ship;
    ?>
        <span>Mã Giảm:  {{ $order->order_coupon }} </span> <br>
        <h3>Tổng Đơn: {{  number_format($total,0,',','.')  }}đ</h3> 
    <?php 
        } else if ($coupon_price > 1000) { // Theo Tiền
            $total_coupon = $total - $coupon_price; //Số Tiền Giảm Theo Tiền
            $total = $total_coupon + $fee_ship;
    ?>
         <span>Mã Giảm:  {{ $order->order_coupon }} </span> <br>
         <h3>Tổng Đơn: {{  number_format($total,0,',','.')  }}đ</h3> 
    <?php 
        }
    }
    ?>
    Cảm ơn bạn đã đặt món tại TAT, Xin cảm ơn !
</body>
</html>