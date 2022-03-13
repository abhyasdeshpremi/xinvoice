
<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-4">
                <input class="form-control border-end-0 border rounded-pill" type="text" placeholder="search" id="ledgerearch">
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
                <input type="date" id="startDate" name="startDate" class="form-control">
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3 col-xs-12"> 
                <input type="date" id="endDate" name="endDate" class="form-control">
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

    var base_url = "<?php echo base_url('/downloadclientpdf'); ?>";
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#startDate").attr("value", today);
    $("#endDate").attr("value", today);
    $("#startDate").focus();
    $("#applySearch").click(function(){
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var ledgerearch = $('#ledgerearch').val();
        if((startDate.length > 0) && (endDate.length > 0) ){ 
            $('#stockreporthead').html('');
            $('#stockreportBody').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/salereport'); ?>',
                dataType  : 'json',
                data: {start_date: $('#startDate').val(), end_date: $('#endDate').val(), ledgerearch: ledgerearch},
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
                        var printurl = base_url + "/" +$('#startDate').val()+"/"+$('#endDate').val()+"/"+ledgerearch;
                        $("#printStockReport").attr("href", printurl);
                        console.log(printurl);
                    }else{
                        $('#stockreporthead').html('');
                        $('#stockreportBody').html("<h1>"+data.message+"</h1>");
                    }
                }
            });
        }else{
            $('#stockreporthead').html('');
            $('#stockreportBody').html("<center><h1>Please select start and end date.</h1></center>");
        }
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