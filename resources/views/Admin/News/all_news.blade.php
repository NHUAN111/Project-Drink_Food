@extends('admin.admin_layout')
@section('main_admin')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
</div>
<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Liệt kê bài viết</h1>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th  style="font-weight: bold;"> #ID </th>
              <th  style="font-weight: bold;"> Tiều đề </th>
              <th  style="font-weight: bold;"> Ảnh </th>
              <th  style="font-weight: bold;"> Hiển thị </th>
              <th  style="font-weight: bold;"> Chức năng </th>
            </tr>
          </thead>
          <tbody id="load_news">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
   {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider --}}
   {{-- <nav aria-label="Page navigation example">
    {!! $items->links('admin.pagination') !!}
    </nav> --}}
{{-- Phân Trang Bằng Ajax --}}
{{-- Link ajax --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  getPosts();
  function getPosts(){
  $.ajax({
          url: '{{ url('/admin/news/load-news') }}',
          method: 'get',
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          data: {

          },
          success: function(data) {
              $('#load_news').html(data);
          },
          error: function() {
              alert("Bug Huhu :<<");
          }
      });
  }
</script>

<script>
   $(document).on('click', '.update-status', function() {
      var item_id = $(this).data('item_id');
      var item_status = $(this).data('item_status');

      $.ajax({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          url: '{{ url('/admin/news/update-status-news') }}',
          method: 'get',
          data: {
             news_id: item_id,
             news_status: item_status,
          },
          success: function(data) {
              getPosts();
              if (item_status == 1) {
                  message_toastr("success", 'Tin ID ' + item_id + ' Đã Được Kích Hoạt!');
              } else if (item_status == 0) {
                  message_toastr("success", 'Tin ID ' + item_id + ' Đã Bị Vô Hiệu!');
              }
          },
          error: function() {
              alert("Bug Huhu :<<");
          }
      })
  });
  
  $(document).on('click', '.btn-delete-news', function(){
      var item_id = $(this).data('item_id');
      message_toastr("success", 'Xác Nhận Xóa Tin ID ' + item_id +
          '?<br/><br/><button type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw confirm-delete" data-item_id="' +
          item_id + '">Xóa</button>');
  });

  $(document).on('click', '.confirm-delete', function() {
      $(".loading").css({
          "display": "block"
      });
      $(".overlay-loading").css({
          "display": "block"
      });
      var item_id = $(this).data('item_id');
      $.ajax({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          url: '{{ url('/admin/news/delete-news') }}',
          method: 'get',
          data: {
             news_id: item_id,
          },
          success: function(data) {
              getPosts();
              message_toastr("success", "Tin "+item_id+" đã xoá thành công");
          },
          error: function() {
              alert("Bug Huhu :<<");
          }
      });
  });
</script>
@endsection
