@extends('user_layout2')
@section('user_main2')
    <div class="row gx-lg-5 gx-md-4 gx-2 justify-content-center">
        <div class="col-12 col-md-10 col-lg-5 card  p-3 p-md-5 p-lg-5 pt-4">
            @if ($errors->has('g-recaptcha-response'))
                <script>
                    message_toastr("warning", "Bạn Chưa Vượt Mã Xác Minh Google !", "Cảnh Báo !");
                </script>
            @endif
            <form class="fromlogin" action="{{ url('/dang-nhap-check') }}" method="POST">
                {{ csrf_field() }}
                <div class="mb-3">
                    <h4 class="form-title text-center fs-4">Đăng Nhập</h4>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-5">Tài Khoản Hoặc Email</label>
                    <input type="text" class="form-control p-2" id="name_login" aria-describedby="emailHelp"
                        name="customer_email" required placeholder="Tên Hoặc Email">
                    <span class="form-message text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label fs-5">Mật khẩu</label>
                    <input type="password" class="form-control p-2" id="pass_login" name="customer_pass" required placeholder="Mật Khẩu Của Bạn">
                    <span class="form-message text-danger"></span>
                </div>
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input p-2" id="exampleCheck1" name="remember" value="on">
                    <label class="form-check-label" for="exampleCheck1">Lưu đăng nhập của tôi</label>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                </div>
                <br />
                @if ($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback" style="display:block">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
                <div class="mb-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger w-100">Đăng nhập</button>
                </div>
                <div class="mb-3 text-center">
                    Chưa có tài khoản?
                    <a type="submit" class="text-decoration-none" href="{{ url('dang-ky') }}">Đăng ký tài khoản</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        Validator({
            form: '.fromlogin',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#name_login', 'Vui lòng nhập tên tài khoản hoặc email'),
                Validator.isRequired('#pass_login', 'Vui lòng nhập mật khẩu của bạn'),
                // Validator.minLength('#pass_login', 6),
            ]
        });
    </script>

    <script>
        load_count_cart();

        function load_count_cart() {
            $.ajax({
                url: '{{ url('/count-cart') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">0</span>'
                            );
                    } else {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">' +
                            data + '</span>');
                    }
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
    </script>
@endsection
