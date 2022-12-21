@extends('user_layout2')
@section('user_main2')
    <!-- Chi tiết -->
    <div class="row gx-lg-5 gx-md-4 gx-2 justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 pt-4">
            <div class="card">
                <img src="{{ asset('public/frontend/assets/img/banner/banner1.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <table class="table">
                                    <tbody>
                                        <h5 class="text-center">ĐƠN ĐẶT HÀNG</h5>
                                            <p class="text-center text-success">Bạn Chưa Đặt Đơn Nào</p>
                                            <div>
                                                <img src="https://matkinhminhnhat.vn/upload/images/thank.png" alt=""
                                                width="100%">
                                            </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
