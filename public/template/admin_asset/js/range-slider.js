$(document).ready(function() {
    $('#range-price').ionRangeSlider({
        min     : 0,
        max     : $('#highest-price').val(),
        from    : $('#price-min').val() ? $('#price-min').val() : 0,
        to      : $('#price-max').val() ? $('#price-max').val() : $('#highest-price').val(),
        type    : 'double',
        step    : 1,
        prefix  : 'đ',
        prettify: false,
        hasGrid : true,
        // Đặt giá trị mặc định cho price-min và price-max
        // onStart: function (data) {
        //     $('#price-min').val(data.from);
        //     $('#price-max').val(data.to);
        // },
        // Update giá trị input khi slider đang di chuyển
        // onChange: function (data) {
        //     $('#price-min').val(data.from);
        //     $('#price-max').val(data.to);
        // },
        // Update giá trị input khi slider di chuyển xong
        onFinish: function (data) {
            $('#price-min').val(data.from);
            $('#price-max').val(data.to);
        },
    });
});