/* Active Item and Dropdown */
$(document).ready(function() {
    var activeItem = localStorage.getItem('admin_activeAdminItem');
    var dropdownItem = localStorage.getItem('admin_dropdownAdminItem');
    if (activeItem) {
        $('.nav-link').removeClass('active');
        $('#' + activeItem).addClass('active');
    }
    // else{
    //     var dashboard = $('#dashboard');
    //     dashboard.addClass('active');
    //     localStorage.setItem('admin_activeAdminItem', dashboard.attr('id'));
    // }

    if(dropdownItem) {
        $('.nav-bar').removeClass('menu-open');
        $('#' + dropdownItem).addClass('menu-open');
    }
    
    /* Dấu '>' chọn ptu con trực tiếp của ptu cha, trong TH này sẽ chọn ptu nav-link ko có ptu 
    cha nào khác bao bọc */
    $('.nav-bar > .nav-link').click(function() {
        var parent = $(this).parent();
        parent.toggleClass('menu-open');    
        localStorage.setItem('admin_dropdownAdminItem', parent.attr('id'));
    });
    
    $('.nav-link').click(function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active'); 
        localStorage.setItem('admin_activeAdminItem', this.id);
    });

    switch (activeItem) {
        case 'dashboard':
        case 'user-profile':
        case 'customer-list':
            $('.nav-bar').removeClass('menu-open');
            break;
    }
});

