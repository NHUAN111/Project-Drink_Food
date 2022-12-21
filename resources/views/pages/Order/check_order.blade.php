@extends('user_layout2')
@section('user_main2')
    <div class="row gx-lg-5 gx-md-4 gx-2 justify-content-center">
        <div class="col-12 col-md-10 col-lg-4 card  p-3 p-md-5 p-lg-5 pt-4">
            <div class="mb-3">
                {{-- <i class="fa-solid fa-file"></i> --}}
                <h4 class="form-title text-center fs-4 text-dark">Kiểm Tra Đơn Hàng</h4>
            </div>
            <form class="fromlogin" action="{{ url('/check-info-order') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <input type="text" class="form-control p-2" id="order_code" aria-describedby="emailHelp"
                        name="order_code" required placeholder="Nhập mã đơn hàng">
                    <span class="form-message text-danger"></span>
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit"class="btn btn-danger w-100">Kiểm tra</button>
                </div>
            </form>
        </div>
    </div>
@endsection
