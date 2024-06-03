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
    var isChecked = $(this).is(':checked');
    $(this).parents('.card').find('.checkbox-children').prop('checked', isChecked); 
});
    