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
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4" >
                <table class="table table-bordered table-hover table-fixed" id="StockResultTable" width="77%" cellspacing="0">
                    <thead id="ledgerreporthead">
                        
                    </thead>
                    <tbody id="ledgerreportBody">
                    </tbody>
                </table>
            </div>
        </div>
            
        
    </div>
</div>

<script type="text/javascript">
$(function() {

    var start = moment().subtract(1, 'year').startOf('year');//moment(); // moment().subtract(29, 'days');
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
        $('#ledgerreporthead').html('');
        $('#ledgerreportBody').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('/clientreport'); ?>',
            dataType  : 'json',
            data: {start_date: start.format('YYYY-MM-DD'), end_date: end.format('YYYY-MM-DD')},
            error: function() {
                alert('Something is wrong');
            },
            success: function (data) {
                if (data.code){
                    $('#ledgerreporthead').append(addHeader());
                    console.log(data);
                    var result = data.result;

                    var total_basic_value_amount = 0.0;
                    var total_cgst_amount = 0.0;
                    var total_sgst_amount = 0.0;
                    var total_round_off_amount = 0.0;
                    var total_lock_bill_amount = 0.0;

                    var tmpBillDate = result[0]["bill_date"];
                    for(i=0;i<result.length; i++) {
                        var oneRow = result[i];
                        var basic_value_amount = parseFloat(oneRow["basic_value_amount"]);
                        var cgst_amount = parseFloat(oneRow["cgst_amount"]);
                        var sgst_amount = parseFloat(oneRow["sgst_amount"]);
                        var round_off_amount = parseFloat(oneRow["round_off_amount"]);
                        var lock_bill_amount = parseFloat(oneRow["lock_bill_amount"]);
                        var currentBillDate = oneRow["bill_date"];

                        if (tmpBillDate == currentBillDate){
                            $('#ledgerreportBody').append(addInvoicerow(oneRow, (i + 1)) );
                        }else{
                            $('#ledgerreportBody').append(addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount));
                            $('#ledgerreportBody').append(addInvoicerow(oneRow, (i + 1)) );
                            total_basic_value_amount = 0.0;
                            total_cgst_amount = 0.0;
                            total_sgst_amount = 0.0;
                            total_round_off_amount = 0.0;
                            total_lock_bill_amount = 0.0;
                            tmpBillDate = currentBillDate;
                        }
                         
                        total_basic_value_amount = parseFloat(total_basic_value_amount) + parseFloat(basic_value_amount);
                        total_cgst_amount = parseFloat(total_cgst_amount) + parseFloat(cgst_amount);
                        total_sgst_amount = parseFloat(total_sgst_amount) + parseFloat(sgst_amount);
                        total_round_off_amount = parseFloat(total_round_off_amount) + parseFloat(round_off_amount);
                        total_lock_bill_amount = parseFloat(total_lock_bill_amount) + parseFloat(lock_bill_amount);

                    }
                    $('#ledgerreportBody').append(addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount));
                    // $('#ledgerreportBody').append(addResultrow(total_opening_amount, total_credit_count_value, total_debit_count_value, total_amount_value));
                    var printurl = base_url + "/" +start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD');
                    $("#printStockReport").attr("href", printurl);
                    console.log(printurl);
                }else{
                    $('#ledgerreportBody').html("<center><h1>"+data.message+"</h1></center>");
                }
            }
        });
    });

    
    function addHeader(){
        return '<tr class="invoicecal">'
                    +'<th width="60px;">#</th>'
                    +'<th width="100px;">DATE</th>'
                    +'<th>INVNo.</th>'
                    +'<th>PARTY NAME</th>'
                    +'<th>GSTIN</th>'
                    +'<th>MODE</th>'
                    +'<th>BASIC</th>'
                    +'<th>CGST</th>'
                    +'<th>SGST</th>'
                    +'<th>R.OFF</th>'
                    +'<th width="70px;">NET AMOUNT</th>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, countNumber){
        var s = "00000" + oneRow["previous_invoice_ref_no"];

        return '<tr class="invoicecal" id="'+oneRow["pk_invoice_id"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+oneRow["bill_date"]+'</td>'
                    +'<td>'+s.substr(s.length-5)+ '/'+ oneRow["invoice_bill_date"] +'</td>'
                    +'<td>'+oneRow["client_name"]+'</td>'
                    +'<td>'+oneRow["gstnumber"]+'</td>'
                    +'<td>'+oneRow["payment_mode"]+'</td>'
                    +'<td>'+oneRow["basic_value_amount"]+'</td>'
                    +'<td>'+oneRow["cgst_amount"]+'</td>'
                    +'<td>'+oneRow["sgst_amount"]+'</td>'
                    +'<td>'+oneRow["round_off_amount"]+'</td>'
                    +'<td>'+oneRow["lock_bill_amount"]+'</td>'
                +'</tr>';
    }

    function addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount){
        return '<tr class="invoicecal" >'
                    +'<td colspan="5"></td>'
                    +'<td><b>TOTAL</b></td>'
                    +'<td><b>'+total_basic_value_amount+'</b></td>'
                    +'<td><b>'+total_cgst_amount.toFixed(2)+'</b></td>'
                    +'<td><b>'+total_sgst_amount.toFixed(2)+'</b></td>'
                    +'<td><b>'+total_round_off_amount+'</b></td>'
                    +'<td><b>'+total_lock_bill_amount+'</b></td>'
                +'</tr>'
                +'<tr class="invoicecal" >'
                    +'<td colspan="11">&nbsp;</td>'
                +'</tr>';
    }

});
</script>