$(document).ready(function() {
    /* Date range picker
    - moment(): Lấy ngày hiện tại 
    */
    $('#reservation').daterangepicker({
        startDate: $('#start-date').val() ? $('#start-date').val() : moment(),
        endDate: $('#end-date').val() ? $('#end-date').val() : moment(),
        locale: {
            format: 'YYYY-MM-DD'
        },
        // function(start, end) {
        //     $('#reservation').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        // }
    });

    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        $('#start-date').val(picker.startDate.format('YYYY-MM-DD'));
        $('#end-date').val(picker.endDate.format('YYYY-MM-DD'));
    });
});
