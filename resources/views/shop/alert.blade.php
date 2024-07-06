@if(Session::has('success'))
<script>
    Swal.fire({
        title: 'Thành công',
        text: `{{ Session::get('success') }}`,
        icon: 'success',
    });
</script>
@elseif (Session::has('error'))
  <script>
      Swal.fire({
        title: 'Lỗi',
        text: `{{ Session::get('error') }}`,
        icon: 'error',
      });
  </script>
@endif