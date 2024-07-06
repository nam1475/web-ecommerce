$(document).ready(function() {
    /* ------Active item------ */
    // Kiểm tra localStorage để đặt trạng thái active
    var activeItem = localStorage.getItem('shop_activeNavItem');
    if (activeItem) {
        $('.nav-link').removeClass('active');
        $('#' + activeItem).addClass('active');
    } else {
        // Đặt trạng thái mặc định nếu không có mục nào được lưu trữ
        $('#all').addClass('active');
        // $('#info').addClass('active');
    }

    // Loại bỏ item hiện tại khỏi localstorage khi click vào những item khác .nav-link
    $(document).on('click', function(e) {   
        if (!$(e.target).hasClass('nav-link')) {
            localStorage.removeItem('shop_activeNavItem');
        }
    })

    $('.nav-link').click(function(e) {
        // e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active'); 
        localStorage.setItem('shop_activeNavItem', this.id);
        // Giả lập tải lại trang (bỏ dòng này nếu trang thực sự tải lại)
        // location.reload();
    });

    /* ------Clear local storage Shop after logout------ */
    $('#logout-customer').on('click', function(){
        for(var i = 0; i < localStorage.length; ++i){
            var key = localStorage.key(i);
            /* Nếu các key chứa chuỗi 'shop_' thì sẽ xóa khỏi localstorage */
            if(key.includes('shop_')){
                localStorage.removeItem(key);
                /* Giảm i vì số lượng phần tử trong localStorage đã giảm đi 1 sau khi xóa */
                --i;
            }
        }
    });
});
