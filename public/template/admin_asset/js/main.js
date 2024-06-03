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
    */
   // console.log($(this)[0].files[0]);
   form.append('file', $(this)[0].files[0]);   
    
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
        }
    });
});










