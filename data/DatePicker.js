type = "text/javascript" >
$(function () {
    
    var start = moment();
    var end = moment().add(6, 'days');
    
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: start,
        ranges: {
            'Today': [moment(), moment()],
            'Next 7 Days': [moment(), moment().add(6, 'days')],
            'Next 30 Days': [moment(), moment().add(1, 'month')],
        }
    }, cb);
    
    cb(start, start);
    
});

