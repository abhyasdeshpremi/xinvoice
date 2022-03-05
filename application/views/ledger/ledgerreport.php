
<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-3">
            
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                    
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3 col-xs-12">
                <input type="text" id="daterange" class="form-control">
            </div>
            <div class="col-md-1 col-xs-12">
                <button type="button" class="btn btn-outline-warning" id="applySearch">Search</button>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-1 col-xs-12">
                <a target="_blank" class="btn btn-outline-warning" id="printStockReport" href=""><i data-feather="printer"></i></a>
            </div>
        </div>
        <hr>
        <div class="clearfix">
            &nbsp;
        </div>
        <div class="datatable">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <table class="table table-bordered table-hover" id="StockResultTable" width="80%" cellspacing="0">
                    <thead id="stockreporthead">
                        
                    </thead>
                    <tbody id="stockreportBody">
                    </tbody>
                </table>
            </div>
        </div>
            
        
    </div>
</div>

<script type="text/javascript">
$(function() {

    var start = moment(); // moment().subtract(29, 'days');
    var end = moment();
    var base_url = "<?php echo base_url('/downloadclientpdf'); ?>";
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
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        alwaysShowCalendars: false,
        startDate: start,
        endDate: end,
        opens: "left"
    }, function(start, end, label) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")");
    });

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        start = picker.startDate;
        end = picker.endDate;
        console.log(picker.startDate.format('YYYY-MM-DD'));
        console.log(picker.endDate.format('YYYY-MM-DD'));
    });
    
    $("#applySearch").click(function(){
        $('#stockreporthead').html('');
        $('#stockreportBody').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('/salereport'); ?>',
            dataType  : 'json',
            data: {start_date: start.format('YYYY-MM-DD'), end_date: end.format('YYYY-MM-DD')},
            error: function() {
                alert('Something is wrong');
            },
            success: function (data) {
                if (data.code){
                    $('#stockreporthead').append(addHeader());
                    console.log(data);
                    var result = data.result;
                    var total_opening_amount = 0.0;
                    var total_credit_count_value = 0.0;
                    var total_debit_count_value = 0.0;
                    var total_amount_value = 0.0;
                    var tmpDistrict = result[0]["district"];
                    for(i=0;i<result.length; i++) {
                        var oneRow = result[i];
                        var debit_count_value = parseFloat(oneRow["debit_count_value"]);
                        var credit_count_value = parseFloat(oneRow["credit_count_value"]);
                        var total_amount = parseFloat(oneRow["total_amount"]);
                        var opening_amount = (total_amount + debit_count_value - credit_count_value);

                        var currentDistrict = oneRow["district"];
                        if (tmpDistrict == currentDistrict){
                            $('#stockreportBody').append(addInvoicerow(oneRow, opening_amount, (i + 1)) );
                        }else{
                            $('#stockreportBody').append(addResultrow(total_opening_amount, total_credit_count_value, total_debit_count_value, total_amount_value));
                            $('#stockreportBody').append(addInvoicerow(oneRow, opening_amount, (i + 1)) );
                            total_opening_amount = 0.0;
                            total_credit_count_value = 0.0;
                            total_debit_count_value = 0.0;
                            total_amount_value = 0.0;
                            tmpDistrict = currentDistrict;
                        }

                        total_opening_amount = parseFloat(total_opening_amount) + parseFloat(opening_amount);
                        total_credit_count_value = parseFloat(total_credit_count_value) + parseFloat(credit_count_value);
                        total_debit_count_value = parseFloat(total_debit_count_value) + parseFloat(debit_count_value);
                        total_amount_value = parseFloat(total_amount_value) + parseFloat(total_amount);
                        
                        
                    }
                    $('#stockreportBody').append(addResultrow(total_opening_amount, total_credit_count_value, total_debit_count_value, total_amount_value));
                    var printurl = base_url + "/" +start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD');
                    $("#printStockReport").attr("href", printurl);
                    console.log(printurl);
                }else{
                    $('#stockreportBody').html("<h1>"+data.message+"</h1>");
                }
            }
        });
    });

    
    function addHeader(){
        return '<tr class="invoicecal">'
                    +'<th width="60px;">#</th>'
                    +'<th>NAME</th>'
                    +'<th width="100px;">TYPE</th>'
                    +'<th>DISTRICT</th>'
                    +'<th width="100px;">OP. BAL</th>'
                    +'<th width="100px;">TTL CR.</th>'
                    +'<th width="100px;">TTL DR.</th>'
                    +'<th width="70px;">CL. BAL</th>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, opening_amount, countNumber){
        
        return '<tr class="invoicecal" id="'+oneRow["fk_client_code"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+oneRow["fk_client_name"]+'</td>'
                    +'<td>'+oneRow["client_type"]+'</td>'
                    +'<td>'+oneRow["district"]+'</td>'
                    +'<td>'+opening_amount+'</td>'
                    +'<td>'+oneRow["credit_count_value"]+'</td>'
                    +'<td>'+oneRow["debit_count_value"]+'</td>'
                    +'<td>'+oneRow["total_amount"]+'</td>'
                +'</tr>';
    }

    function addResultrow(total_opening_amount, total_credit_count_value, total_debit_count_value, total_amount_value){
        return '<tr class="invoicecal" >'
                    +'<td colspan="3"></td>'
                    +'<td><b>TOTAL</b></td>'
                    +'<td><b>'+total_opening_amount+'</b></td>'
                    +'<td><b>'+total_credit_count_value+'</b></td>'
                    +'<td><b>'+total_debit_count_value+'</b></td>'
                    +'<td><b>'+total_amount_value+'</b></td>'
                +'</tr>'
                +'<tr class="invoicecal" >'
                    +'<td colspan="8">&nbsp;</td>'
                +'</tr>';
    }

});
</script>