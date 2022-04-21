
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

    var base_url = "<?php echo base_url('/downloadallzonesalepdf'); ?>";
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
                    hideloader();
                    alert('Something is wrong');
                },
                success: function (data) {
                    if (data.code){
                        $('#stockreporthead').append(addHeader());
                        console.log(data);
                        var result = data.result;
                        var total_debit_count_value = 0.0;
                        var final_total_debit_count_value = 0.0;
                        var tmpDistrict = result[0]["district"];
                        var j = 1;
                        $('#stockreportBody').append(addDHeader(tmpDistrict));
                        for(i=0;i<result.length; i++) {
                            var oneRow = result[i];
                            var debit_count_value = parseFloat(oneRow["debit_count_value"]);

                            var currentDistrict = oneRow["district"];
                            if (tmpDistrict == currentDistrict){
                                $('#stockreportBody').append(addInvoicerow(oneRow, j) );
                            }else{
                                j = 1;
                                $('#stockreportBody').append(addResultrow(total_debit_count_value));
                                $('#stockreportBody').append(addDHeader(currentDistrict));
                                $('#stockreportBody').append(addInvoicerow(oneRow, j) );
                                total_debit_count_value = 0.0;
                                tmpDistrict = currentDistrict;
                            }
                            total_debit_count_value = parseFloat(total_debit_count_value) + parseFloat(debit_count_value);
                            final_total_debit_count_value = parseFloat(final_total_debit_count_value) + parseFloat(debit_count_value);
                            j = j + 1;
                        }
                        $('#stockreportBody').append(addResultrow(total_debit_count_value));
                        $('#stockreportBody').append(addFinalResultrow(final_total_debit_count_value));
                        var printurl = base_url + "/" +$('#startDate').val()+"/"+$('#endDate').val()+"/"+ledgerearch;
                        $("#printStockReport").attr("href", printurl);
                        console.log(printurl);
                        hideloader();
                    }else{
                        $('#stockreporthead').html('');
                        $('#stockreportBody').html("<h1>"+data.message+"</h1>");
                        hideloader();
                    }
                }
            });
        }else{
            $('#stockreporthead').html('');
            $('#stockreportBody').html("<center><h1>Please select start and end date.</h1></center>");
            hideloader();
        }
    });

    
    function addHeader(){
        return '<tr class="invoicecal">'
                    +'<th width="60px;">#</th>'
                    +'<th>NAME</th>'
                    +'<th width="100px;">TYPE</th>'
                    +'<th>GSTIN</th>'
                    +'<th width="150px;">SALE AMOUNT</th>'
                +'</tr>';
    }

    function addDHeader(dis){
        return '<tr class="invoicecal">'
                    +'<td>#</td>'
                    +'<td><b>'+dis+'</b></td>'
                    +'<td colspan="3"></td>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, countNumber){
        
        return '<tr class="invoicecal" id="'+oneRow["fk_client_code"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+oneRow["fk_client_name"]+'</td>'
                    +'<td>'+oneRow["client_type"]+'</td>'
                    +'<td>'+oneRow["gst_no"]+'</td>'
                    +'<td>'+oneRow["debit_count_value"]+'</td>'
                +'</tr>';
    }

    function addResultrow(total_debit_count_value){
        return '<tr class="invoicecal" >'
                    +'<td colspan="3"></td>'
                    +'<td><b>TOTAL</b></td>'
                    +'<td><b>'+total_debit_count_value+'</b></td>'
                +'</tr>'
                +'<tr class="invoicecal" >'
                    +'<td colspan="5">&nbsp;</td>'
                +'</tr>';
    }

    function addFinalResultrow(final_total_debit_count_value){
        return '<tr class="invoicecal" >'
                    +'<td colspan="3"></td>'
                    +'<td><b>FINAL TOTAL</b></td>'
                    +'<td><b>'+final_total_debit_count_value+'</b></td>'
                +'</tr>'
                +'<tr class="invoicecal" >'
                    +'<td colspan="5">&nbsp;</td>'
                +'</tr>';
    }

});
</script>
<script>
var input = document.getElementById("ledgerearch");
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