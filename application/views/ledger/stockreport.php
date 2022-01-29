<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-3 mb-3">
            
            </div>
            <div class="col-md-4 mb-3">
                    
            </div>
            <div class="col-md-3 mb-3">
                <input type="text" id="daterange" class="form-control">
            </div>
            <div class="col-md-2 mb-3 pull-right">
                <button type="button" class="btn btn-outline-primary" id="applySearch">Search</button>
            </div>
        </div>

        <div class="row">
            <div id="stockbody">

            </div>
        </div>
            
        
    </div>
</div>

<script type="text/javascript">
$(function() {

    var start = moment(); // moment().subtract(29, 'days');
    var end = moment();

    $('#daterange').daterangepicker({
        locale: { cancelLabel: 'Clear' }  
    });

    $('#daterange').daterangepicker({
        showDropdowns: true,
        showWeekNumbers: true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        alwaysShowCalendars: false,
        startDate: start,
        endDate: end,
        opens: "left"
    }, function(start, end, label) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")");
    });

    // $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
    //     //do something, like clearing an input
    //     $('#daterange').val('');
    // });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        start = picker.startDate;
        end = picker.endDate;
        console.log(picker.startDate.format('YYYY-MM-DD'));
        console.log(picker.endDate.format('YYYY-MM-DD'));
    });
     
    $("#applySearch").click(function(){
        console.log("Hello start"+start.format('MMMM D, YYYY')+ " End"+end.format('MMMM D, YYYY'));
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('/stockreport'); ?>',
            dataType  : 'json',
            data: {start_date: start.format('YYYY-MM-DD'), end_date: end.format('YYYY-MM-DD')},
            error: function() {
                alert('Something is wrong');
            },
            success: function (data) {
                // alert(data);
                if (data.code){
                    $('#stockbody').html("<h1>Result</h1>")
                }else{
                    $('#stockbody').html("<h1>No Stock Available.</h1>")
                }
            }
        });
    });

});
</script>