/* $(document).ready(): Đảm bảo rằng toàn bộ HTML DOM, trang web đã được load xong và sẵn sàng trước khi thực 
thi mã jQuery. */
$(document).ready(function() {
    /* Thêm mã csrf token vào thẻ <meta> trong file header để có thể thực hiện POST, PUT, DELETE bởi
    request ajax */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });  

    /* Upload file */
    $("#upload").change(function(){
        /* Lớp(Class) FormData cung cấp một giao diện để xử lý dữ liệu biểu mẫu trong HTML và gửi nó đi trong một 
        yêu cầu HTTP. Bạn có thể sử dụng đối tượng FormData để tạo và xử lý dữ liệu biểu mẫu từ các yếu tố 
        HTML trong trang web. */
        const form = new FormData();
        
        /* - $(this): Đối tượng vừa chọn (Trong TH này là trường input có name là 'file') 
        - files: Lấy ra các property của file 
        - form.append(): Thêm key-value vào trong đối tượng form
        - form.get(): Lấy ra value của key trong đối tượng form
        */
        form.append('file', $(this)[0].files[0]);   
        // console.log($(this)[0].files[0]);
        // console.log(form.get('file'));

        /* $.ajax(): Là một phương thức trong jQuery được sử dụng để thực hiện các yêu cầu HTTP bất đồng bộ (asynchronous)
        từ trình duyệt web đến máy chủ và xử lý các phản hồi được trả về. */
        $.ajax({
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            data: form,
            url: '/admin/upload/services',
            /* Khi upload thành công: */
            success: function(results){
                if(results.error == false){
                    $("#image_show").html(
                        `
                        <a href="${results.urlFile}" target="_blank">
                            <img src="${results.urlFile}" width="100px">
                        </a>
                    `);
                    $("#thumb").val(results.urlFile);
                }
                else{
                    alert(results.messageError);
                }
            },
            /* Khi upload thất bại: */
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
            }
        });
    });

    // function removeRow(routeName){
    //     // console.log(routeName);
    //     $('#submit-delete').on('click', function(){
    //         // console.log(123);
    //         $.ajax({
    //             type: 'DELETE',
    //             datatype: 'JSON',
    //             data: { 
    //                 _token: $('meta[name="csrf-token"]').attr('content'),
    //             },
    //             url: routeName,
    //             success: function (result) {
    //                 if (result.error == false) {
    //                     $('#modal-danger').modal('hide');
    //                     location.reload();
    //                 } else {
    //                     alert('Xóa lỗi vui lòng thử lại');
    //                 }
    //             }
    //         })
    //     })
    // }

    /* Delete Row */
    $('.btn-delete').on('click', function(){
        var routeName = $(this).data('route');
        $('#form-delete').attr('action', routeName);
    });

    /* Submit form */
    //     $('.form').on('submit', function(e){
    //         /* Ngăn chặn hành vi submit form mặc định */
    //         e.preventDefault();
    //         /* this[0]: Lấy ra phần tử form */
    //         var form = $(this)[0];
    //         /* Truyền các key-value vào đối tượng data (name:..., menu_id:...) */
    //         var data = new FormData(form);
    //         var routeName = $(this).data('route');
    //         var redirect = $(this).data('href');
    //         // var serializedData = $(this).serialize();

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });  

    //         $.ajax({
    //             processData: false,
    //             contentType: false,
    //             type: 'POST',
    //             datatype: 'JSON',
    //             data: data,
    //             url: routeName,
    //             success: function (result) {
    //                 if (result.error == false) {
    //                     showToast(result.message);
    //                     $('.form')[0].reset();
    //                     // location.href = redirect;
    //                 } else {
    //                     alert('Thêm lỗi vui lòng thử lại');
    //                 }
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 console.error('AJAX error:', textStatus, errorThrown);
    //             }
    //         });
    //     });

    // function showToast(message){
    //     var toast = `
    //         <div class="toast toast-success" aria-live="polite">
    //             <div class="toast-message">${message}</div>
    //         </div>
    //     `;
    //     $('#toast-container').append(toast);
    //     $('#toast-container').fadeIn(1000);
        
    //     setTimeout(() => {  
    //         $('#toast-container').hide('slow');
    //     }, 3000);
    // }

    /* Dropdown Item */
    $('.nav-link').on('click', function(){
        // $(this).closet('.dropdown').find('.dropdown-menu').toggleClass('show');  
        $(this).next('.dropdown-menu').toggle();
    });

    /* Clear local storage Admin after logout */
    $('#logout-user').on('click', function(){
        for(var i = 0; i < localStorage.length; ++i){
            var key = localStorage.key(i);
            /* Nếu các key chứa chuỗi 'admin_' thì sẽ xóa khỏi localstorage */
            if(key.includes('admin_')){
                localStorage.removeItem(key);
                /* Giảm i vì số lượng phần tử trong localStorage đã giảm đi 1 sau khi xóa */
                --i;
            }
        }
    });

    /* Select2 */
    $('.select2').select2();

    

});

