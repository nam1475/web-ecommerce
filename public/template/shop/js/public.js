/* Dùng để kiểm tra request POST từ ajax lên server */
/* Dùng để bao gồm X-CSRF-TOKEN trong mọi request AJAX thông qua sử dụng middleware 
VerifyCsrfToken */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function loadMore()
{
    const page = $('#page').val();
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
                // alert('Đã load xong Sản Phẩm');
                /* Ẩn button Load More đi khi đã hiện hết products */
                $('#button-loadMore').css('display', 'none');
            }
        }
    });
}
