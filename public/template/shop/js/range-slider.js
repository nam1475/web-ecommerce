$(document).ready(function() {
    $("#price-range").ionRangeSlider({
        type: "double",
        min: 0,
        max: $('#price-highest').val(),
        from: $('#min-price').val() ? $('#min-price').val() : 0,
        to: $('#max-price').val() ? $('#max-price').val() : $('#price-highest').val(),
        step: 50000,
        prettify_separator: ".",
        // prettify: false,
        // prefix: "đ",
        hide_min_max: true, // Ẩn số min và max
        hide_from_to: true, // Ẩn số from và to
        onStart: updateInputs,
        onChange: updateInputs,
    });

    function updateInputs(data) {
        $("#min-price").val(data.from);
        $("#max-price").val(data.to);
    }
});