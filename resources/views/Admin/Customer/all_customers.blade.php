@extends('admin.admin_layout')
@section('main_admin')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <form action="{{ URL::to('/search-food-admin') }}" method="post">
                        {{ csrf_field() }}
                        <span>
                            <div class="input-group mb-3">
                                <input type="text" name="keywords_search" class="form-control"
                                    placeholder="Tìm kiếm món ăn" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <button type="submit" class="input-group-text btn-primary" id="basic-addon2">Tìm
                                    kiếm</button>
                            </div>
                        </span>
                    </form>
                 </li>
            </ul>
        </nav>
    </div>
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Liệt kê danh sách khách hàng</h1>
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;"> STT </th>
                            <th style="font-weight: bold;"> #ID </th>
                            <th style="font-weight: bold;"> Tên  </th>
                            <th style="font-weight: bold;"> Email </th>
                            <th style="font-weight: bold;"> Mật khẩu </th>
                            <th style="font-weight: bold;"> Số điện thoại </th>
                            <th style="font-weight: bold;"> Hiển thị </th>
                            <th style="font-weight: bold;"> Chức năng </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 0;
                        ?>
                        @foreach ($all_customers as $key => $cusotmers)
                            <tr class="table">
                                <td>{{ $i++ }}</td>
                                <td scope="row">{{ $cusotmers->customer_id }}</td>
                                <td>{{ $cusotmers->customer_name }}</td>
                                <td>{{ $cusotmers->customer_email }}</td>
                                <td>{{ $cusotmers->customer_pass }}</td>
                                <td>{{ $cusotmers->customer_phone }}</td>
                                <td>
                                <?php 
                                    // if($cusotmers->customer_status==0){    
                                ?>
                                {{-- <a href="{{ URL::to('/unactive-food?food_id=' .$value_food->food_id) }}"><i class="mdi mdi-lock-open" style="color: #46c35f; font-size: 1.2rem;"></i></a> --}}
                                <?php 
                                    // }else{
                                ?>
                                    {{-- <a href="{{ URL::to('/active-food?food_id='. $value_food->food_id) }}"><i class="mdi mdi-lock" style="color: f96868; font-size: 1.2rem"></i></a> --}}
                                <?php  
                                    // }
                                ?>
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ URL::to('/admin/customer/delete-customers?customer_id=' . $cusotmers->customer_id) }}"
                                            onclick="return confirm('Bạn muốn xóa khách hàng này không ?')">
                                            <i class="mdi mdi-delete"
                                                style="color: #f96868; margin-right: 10px; font-size: 1.2rem"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Phân Trang Bằng Paginate + Boostraps , Apply Boostrap trong Provider--}}
    <nav aria-label="Page navigation example">
        {{-- {!!  $cusotmers->links()  !!} --}}
   </nav>

@endsection
