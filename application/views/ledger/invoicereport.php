<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-4">
                
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
            <!-- <div class="clearfix"></div> -->
            <!-- <div class="col-md-1 col-xs-12">
                <a target="_blank" class="btn btn-outline-warning" id="printStockReport" href=""><i data-feather="printer"></i></a>
            </div> -->
        </div>
        <hr>
        <div class="clearfix">
            &nbsp;
        </div>
        <div class="datatable">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-fixed" id="StockResultTable" width="80%" cellspacing="0" style="font-size:12px;">
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
        showloader();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        if((startDate.length > 0) && (endDate.length > 0) ){ 
            $('#ledgerreporthead').html('');
            $('#ledgerreportBody').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/invoicereport'); ?>',
                dataType  : 'json',
                data: {start_date: $('#startDate').val(), end_date: $('#endDate').val()},
                error: function() {
                    hideloader();
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
                            var invoice_items_list = oneRow["invoice_items_list"];

                            console.log(invoice_items_list);
                            var invoiceitem;
                            if (invoice_items_list.length >= 1){
                                    invoiceitem = invoice_items_list[0]
                            }
                            if (tmpBillDate == currentBillDate){
                                $('#ledgerreportBody').append(addInvoicerow(oneRow, (i + 1), invoiceitem));
                                for(j=1;j<invoice_items_list.length; j++) {
                                    $('#ledgerreportBody').append(addItemrow(invoice_items_list[j]));
                                }
                                $('#ledgerreportBody').append(addInvoiceTotalrow(oneRow));
                            }else{
                                $('#ledgerreportBody').append(addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount));
                                $('#ledgerreportBody').append(addInvoicerow(oneRow, (i + 1), invoiceitem));
                                for(j=1;j<invoice_items_list.length; j++) {
                                    $('#ledgerreportBody').append(addItemrow(invoice_items_list[j]));
                                }
                                $('#ledgerreportBody').append(addInvoiceTotalrow(oneRow));
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
                        var printurl = base_url + "/" +$('#startDate').val()+"/"+$('#endDate').val();
                        $("#printStockReport").attr("href", printurl);
                        console.log(printurl);
                        hideloader();
                    }else{
                        $('#ledgerreporthead').html('');
                        $('#ledgerreportBody').html("<center><h1>"+data.message+"</h1></center>");
                        hideloader();
                    }
                }
            });
        }else{
            $('#ledgerreporthead').html('');
            $('#ledgerreportBody').html("<center><h1>Please select start and end date.</h1></center>");
            hideloader();
        }
    });

    
    function addHeader(){
        return '<tr class="invoicecal">'
                    +'<th width="60px;">#</th>'
                    +'<th width="100px;">DATE</th>'
                    +'<th>INVNo.</th>'
                    +'<th>PARTY NAME</th>'
                    +'<th>GSTIN</th>'
                    +'<th>MODE</th>'
                    +'<th>PRODUCT</th>'
                    +'<th>QTY.</th>'
                    +'<th>MRP</th>'
                    +'<th>BASIC</th>'
                    +'<th>CGST</th>'
                    +'<th>SGST</th>'
                    +'<th>R.OFF</th>'
                    +'<th width="70px;">NET AMOUNT</th>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, countNumber, invoiceitem){
        return '<tr class="invoicecal" id="'+oneRow["pk_invoice_id"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+oneRow["bill_date"]+'</td>'
                    +'<td>'+oneRow["previous_invoice_ref_no"]+ '/'+ oneRow["financial_year"] +'</td>'
                    +'<td>'+oneRow["client_name"]+'</td>'
                    +'<td>'+oneRow["gstnumber"]+'</td>'
                    +'<td>'+oneRow["payment_mode"]+'</td>'

                    +'<td>'+invoiceitem["fk_item_name"]+'</td>'
                    +'<td>'+invoiceitem["quantity"]+'</td>'
                    +'<td>'+invoiceitem["mrp_value"]+'</td>'
                    +'<td>'+invoiceitem["bill_value"]+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+invoiceitem["bill_value"]+'</td>'
                +'</tr>';
    }

    function addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount){
        return '<tr class="invoicecal" >'
                    +'<td colspan="7"></td>'
                    +'<td colspan="2"><b>DAY TOTAL</b></td>'
                    +'<td><b>'+total_basic_value_amount+'</b></td>'
                    +'<td><b>'+total_cgst_amount.toFixed(2)+'</b></td>'
                    +'<td><b>'+total_sgst_amount.toFixed(2)+'</b></td>'
                    +'<td><b>'+total_round_off_amount+'</b></td>'
                    +'<td><b>'+total_lock_bill_amount+'</b></td>'
                +'</tr>'
                +'<tr class="invoicecal" >'
                    +'<td colspan="14">&nbsp;</td>'
                +'</tr>';
    }

    function addItemrow(productnRow){
        return '<tr class="invoicecal" >'
                    +'<td colspan="5"></td>'
                    +'<td colspan="2">'+productnRow["fk_item_name"]+'</td>'
                    +'<td>'+productnRow["quantity"]+'</td>'
                    +'<td>'+productnRow["mrp_value"]+'</td>'
                    +'<td>'+productnRow["bill_value"]+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+0+'</td>'
                    +'<td>'+productnRow["bill_value"]+'</td>'
                    
                +'</tr>'
    }

    function addInvoiceTotalrow(oneRow){
        return '<tr class="invoicecal">'
                    +'<td colspan="8"></td>'
                    +'<td>Total</td>'

                    +'<td>'+oneRow["basic_value_amount"]+'</td>'
                    +'<td>'+oneRow["cgst_amount"]+'</td>'
                    +'<td>'+oneRow["sgst_amount"]+'</td>'
                    +'<td>'+oneRow["round_off_amount"]+'</td>'
                    +'<td>'+oneRow["lock_bill_amount"]+'</td>'
                +'</tr>';
    }

});
</script>