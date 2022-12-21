@extends('user_layout2')
@section('user_main2')
    <h2 class="text-bold text-capitalize text-center fs-4 fw-bolder">
        <img src="http://localhost/DACN-Web/public/frontend/assets/img/banner/logo.jpg" width="60" alt=""
            srcset="">
        Về chúng tôi
    </h2>
    <div class="row g-lg-5 g-md-4 g-3">
        @foreach ($news as $v_news)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <img src="{{ URL::to('public/upload/News/' . $v_news->news_image) }}" height="200"
                        style="object-fit: cover" class="rounded-1" alt="">
                    <div class="card-body">
                        <h5 class="card-text text-capitalize"
                            style="display: -webkit-box; height: 3rem;
                        -webkit-box-orient: vertical;
                        -webkit-line-clamp: 2;
                        text-overflow: ellipsis; overflow: hidden">
                            {{ $v_news->news_title }}</h5>
                        <p class="card-text">
                            <small class="text-muted">{{ date($v_news->create_at) }}</small>
                        </p>
                        <p class="card-text"
                            style="display: -webkit-box; height: 3.4rem;
                        -webkit-box-orient: vertical;
                        -webkit-line-clamp: 2;
                        text-overflow: ellipsis; overflow: hidden">
                            {{ $v_news->news_content }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        load_count_cart();

        function load_count_cart() {
            $.ajax({
                url: '{{ url('/count-cart') }}',
                method: 'GET',
                success: function(data) {
                    if (data == 0) {
                        $('#list-cart').html(
                            '<span style="position: absolute; top: -27px; right: 14px; padding: 1px 5px;font-size: 0.9rem; line-height: 1rem; border-radius: 10px; color: #fff; background-color: #dc3545; border: 2px solid #fff">' +
                            data + '</span>');
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
