<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-4">
                <input class="form-control border-end-0 border rounded-pill" type="text" placeholder="search" id="salesearch">
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
                <a target="_blank" class="btn btn-outline-warning" id="printStockReport" href="" download><i data-feather="printer"></i></a>
            </div>
        </div>
        <hr>
        <div class="clearfix">
            &nbsp;
        </div>
        <div class="datatable">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <table class="table table-bordered table-hover" id="StockResultTable" width="80%" cellspacing="0">
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
    var globalInvoice_bill_include_tax = "<?php echo $this->session->userdata('bill_include_tax'); ?>";
    var base_url = "<?php echo base_url('/downloadsalepdf'); ?>";
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
        var salesearch = $('#salesearch').val();
        if((startDate.length > 0) && (endDate.length > 0) ){ 
            $('#ledgerreporthead').html('');
            $('#ledgerreportBody').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/clientreport'); ?>',
                dataType  : 'json',
                data: {start_date: $('#startDate').val(), end_date: $('#endDate').val(), salesearch: salesearch},
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
                        var final_total_lock_bill_amount = 0.0;

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
                            final_total_lock_bill_amount = parseFloat(final_total_lock_bill_amount) + parseFloat(lock_bill_amount);

                        }
                        $('#ledgerreportBody').append(addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount));
                        $('#ledgerreportBody').append(addFinalResultrow(final_total_lock_bill_amount));
                        var printurl = base_url + "/" +$('#startDate').val()+"/"+$('#endDate').val()+"/"+salesearch;
                        $("#printStockReport").attr("href", printurl);
                        console.log(printurl);
                    }else{
                        $('#ledgerreporthead').html('');
                        $('#ledgerreportBody').html("<center><h1>"+data.message+"</h1></center>");
                    }
                }
            });
        }else{
            $('#ledgerreporthead').html('');
            $('#ledgerreportBody').html("<center><h1>Please select start and end date.</h1></center>");
        }
    });

    
    function addHeader(){
        if (globalInvoice_bill_include_tax === 'yes'){
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
        }else {
            return '<tr class="invoicecal">'
                        +'<th width="60px;">#</th>'
                        +'<th width="100px;">DATE</th>'
                        +'<th>INVNo.</th>'
                        +'<th>PARTY NAME</th>'
                        +'<th>MODE</th>'
                        +'<th width="120px;">NET AMOUNT</th>'
                    +'</tr>';
        }
    }

    function addInvoicerow(oneRow, countNumber){
        if (globalInvoice_bill_include_tax === 'yes'){
            return '<tr class="invoicecal" id="'+oneRow["pk_invoice_id"]+'">'
                        +'<td>'+countNumber+'</td>'
                        +'<td>'+oneRow["bill_date"]+'</td>'
                        +'<td>'+oneRow["previous_invoice_ref_no"]+ '/'+ oneRow["financial_year"] +'</td>'
                        +'<td>'+oneRow["client_name"]+'</td>'
                        +'<td>'+oneRow["gstnumber"]+'</td>'
                        +'<td>'+oneRow["payment_mode"]+'</td>'
                        +'<td>'+oneRow["basic_value_amount"]+'</td>'
                        +'<td>'+oneRow["cgst_amount"]+'</td>'
                        +'<td>'+oneRow["sgst_amount"]+'</td>'
                        +'<td>'+oneRow["round_off_amount"]+'</td>'
                        +'<td>'+oneRow["lock_bill_amount"]+'</td>'
                    +'</tr>';
        }else {
            return '<tr class="invoicecal" id="'+oneRow["pk_invoice_id"]+'">'
                        +'<td>'+countNumber+'</td>'
                        +'<td>'+oneRow["bill_date"]+'</td>'
                        +'<td>'+oneRow["previous_invoice_ref_no"]+ '/'+ oneRow["financial_year"] +'</td>'
                        +'<td>'+oneRow["client_name"]+'</td>'
                        +'<td>'+oneRow["payment_mode"]+'</td>'
                        +'<td>'+oneRow["lock_bill_amount"]+'</td>'
                    +'</tr>';
        }
    }

    function addResultrow(total_basic_value_amount, total_cgst_amount, total_sgst_amount, total_round_off_amount, total_lock_bill_amount){
        if (globalInvoice_bill_include_tax === 'yes'){
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
        }else {
            return '<tr class="invoicecal" >'
                        +'<td colspan="4"></td>'
                        +'<td><b>TOTAL</b></td>'
                        +'<td><b>'+total_lock_bill_amount+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal" >'
                        +'<td colspan="11">&nbsp;</td>'
                    +'</tr>';
        }
    }

    function addFinalResultrow(final_total_lock_bill_amount){
        if (globalInvoice_bill_include_tax === 'yes'){
            return '<tr class="invoicecal" >'
                        +'<td colspan="9"></td>'
                        +'<td><b>TOTAL</b></td>'
                        +'<td><b>'+final_total_lock_bill_amount+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal" >'
                        +'<td colspan="11">&nbsp;</td>'
                    +'</tr>';
        }else {
            return '<tr class="invoicecal" >'
                        +'<td colspan="4"></td>'
                        +'<td><b>FINAL TOTAL</b></td>'
                        +'<td><b>'+final_total_lock_bill_amount+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal" >'
                        +'<td colspan="11">&nbsp;</td>'
                    +'</tr>';
        }
    }

});
</script>
<script>
var input = document.getElementById("salesearch");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("applySearch").click();
  }
});
var startDate = document.getElementById("startDate");
startDate.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("applySearch").click();
  }
});

var endDate = document.getElementById("endDate");
endDate.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("applySearch").click();
  }
});
</script>
<script language="javascript" type="text/javascript" >
    var isCtrl = false;     
    document.onkeyup=function()
    {
        var e = window.event;
        if(e.keyCode == 17)
        {
            isCtrl=false;
        }
    }
    
    document.onkeydown=function()
    {
        var e = window.event;
        if(e.keyCode == 17)
        {
            isCtrl=true;
        }
        if(e.keyCode == 80 && isCtrl == true) // Ctrl + P
        {
            var href = document.getElementById("printStockReport").getAttribute("href");
            if(href.length > 0){
                document.getElementById("printStockReport").click();
            }else{
                alert("Please search first");
            }
        }
    }
    </script>