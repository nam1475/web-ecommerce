function updateCheckboxes() {
    var selectedItem = $('.parent-pms').val();
    // console.log(selectedItem);
    switch (selectedItem) {
        case 'dashboard':
            $('#list-wrapper').show();
            $('#add-wrapper, #edit-wrapper, #delete-wrapper').hide();
            break;
        case 'order':
            $('#list-wrapper, #edit-wrapper, #delete-wrapper').show();
            $('#add-wrapper').hide();
            break;
        default:
            $('.module-action').show();
            break;
    }
}

$('.parent-pms').on('change', function(){
    updateCheckboxes();
});