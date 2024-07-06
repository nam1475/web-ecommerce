$(document).ready(function() {
    $('.checkbox-parent').on('click', function(){
        /* Lấy trạng thái của checkbox cha */
        var isChecked = $(this).is(':checked');
        // console.log(isChecked);
        // console.log($(this).closest('.card').find('.checkbox-children'));

        /* Đặt trạng thái của tất cả các checkbox con theo trạng thái của checkbox cha 
        - closet(): Lấy ra phần tử cha chỉ định gần nhất của phần tử con chỉ định 
        */
        $(this).closest('.card').find('.checkbox-children').prop('checked', isChecked); 
    });

    $('.checkbox-all').on('click', function(){
        /* Kiểm tra xem checkbox đã được check chưa, nếu rồi -> true, ngược lại -> false */
        var isChecked = $(this).is(':checked');
        /* visible: Chỉ chọn những đối tượng đang hiện, ko chọn những đối tượng đang bị ẩn đi (display:none) */
        $(this).parents('.card').find('.checkbox-children:visible').prop('checked', isChecked); 
    });
});


    