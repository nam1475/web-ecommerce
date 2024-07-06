/* Dùng để bao gồm X-CSRF-TOKEN trong mọi request AJAX thông qua sử dụng middleware 
VerifyCsrfToken */
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

function loadMoreProduct()
{
    const page = $('#page').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type : 'POST',
        dataType : 'JSON',
        data : { page },
        url : '/services/load-product',
        success : function (result) {
            if (result.html != '') {
                /* Thêm product vào khi ấn nút Load More */
                $('#loadProduct').append(result.html);
                $('#page').val(page + 1);
            } else {
                /* Ẩn button Load More đi khi đã hiện hết products */
                $('#button-loadMore').css('display', 'none');
            }
        }
    });
}

/* $(document).ready(): Đảm bảo rằng toàn bộ HTML DOM, trang web đã được load xong và sẵn sàng trước khi thực 
thi mã jQuery. */
$(document).ready(function() {
    /* ------Update------ */    
    $('.btn-update').on('click', function(){
        var routeName = $(this).data('route');
        $('#form-update').attr('action', routeName);
        // $('.form-update').attr('action', routeName);
    }); 

    $('.btn-update-password').on('click', function(){
        var routeName = $(this).data('route');
        $('.form-update-password').attr('action', routeName);
    });

    /* ------Show password------ */
    $('.show-password').on('click', function() {
        if ($(this).children().hasClass('fa-eye-slash')) {
            $(this).children().removeClass('fa-eye-slash').addClass('fa-eye');
            $(this).closest('.input-group').find('input').attr('type', 'text');
        } else {
            $(this).children().removeClass('fa-eye').addClass('fa-eye-slash');
            $(this).closest('.input-group').find('input').attr('type', 'password');
        }
    })

    /* ------Send email reset password------ */
    $('#show-modal-send-email').on('click', function() {
        var routeName = $(this).data('route');
        $('#form-send-email').attr('action', routeName);
    });

    /* ------Insert, update query string 'search-products'------ */
    $('#search-form').submit(function(e) {
        e.preventDefault(); // Ngăn chặn form submit mặc định

        /*- new URLSearchParams(window.location.search): Tạo một đối tượng URLSearchParams từ chuỗi 
        query string hiện tại. 
        - window.location.search: Sẽ trả về phần query string của url 
            +, Ví dụ, nếu URL là http://example.com?page=1&sort=asc, thì window.location.search 
            sẽ trả về chuỗi "?page=1&sort=asc". 
        */
        var searchParams = new URLSearchParams(window.location.search);
        var searchValue = $('#search-products').val();

        // Cập nhật hoặc thêm query string mới
        if (searchValue) {
            searchParams.set('search-products', searchValue);
        } 

        // Tạo URL mới với các query string đã gộp
        var newUrl = window.location.pathname + '?' + searchParams.toString();

        // Chuyển hướng đến URL mới
        window.location.href = newUrl;
    });
});
