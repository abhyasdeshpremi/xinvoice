
<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 pt-3">
        <div class="row">
            <div class="col-md-4">
                <select class="form-control selectpicker border" id="ledgerearch" name="ledgerearch" style="text-transform: capitalize;" data-live-search="true">
                    <option value="">Select Party Name</option>
                    <?php $count = 0; 
                        foreach($clients as $client){ ?>
                            <option value="<?php echo $client->code; ?>"><?php echo $client->name;?></option>
                    <?php $count++; } ?>
                </select>
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

    var base_url = "<?php echo base_url('/downloadpartyledgerpdf'); ?>";
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
        if((startDate.length > 0) && (endDate.length > 0) && (ledgerearch !== '')){ 
            $('#stockreporthead').html('');
            $('#stockreportBody').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/partyledgerreport'); ?>',
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
                        for(i=0;i<result.length; i++) {
                            var oneRow = result[i];  
                            var result_account_history = oneRow["accounthistory"];
                            var opening_balance = oneRow["opening_balace_value"];
                            $('#stockreportBody').append(addInvoiceOpenrow(opening_balance));
                            for(j=0;j<result_account_history.length; j++) {
                                var paymenttype = result_account_history[j]["payment_type"];
                                var amount = result_account_history[j]["amount"];
                                var creditAmount = '';
                                var debitAmount = '';
                                if(paymenttype === "debit"){
                                    debitAmount = parseFloat(amount);
                                    opening_balance = parseFloat(opening_balance) - parseFloat(amount);
                                }else if(paymenttype === "credit"){
                                    creditAmount = parseFloat(amount);
                                    opening_balance = parseFloat(opening_balance) + parseFloat(amount);
                                }
                                $('#stockreportBody').append(addInvoicerow(result_account_history[j], debitAmount, creditAmount, opening_balance, (j + 2)) );
                            }
                        }
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
            $('#stockreportBody').html("<center><h1>Please select party name, start and end date.</h1></center>");
        }
    });

    
    function addHeader(){
        return '<tr class="invoicecal">'
                    +'<th width="60px;">#</th>'
                    +'<th width="175px;">DATE</th>'
                    +'<th>NOTES</th>'
                    +'<th width="110px;">DEBIT</th>'
                    +'<th width="110px;">CREDIT</th>'
                    +'<th width="120px;">BALANCE</th>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, debitAmount, creditAmount, opening_balance,  countNumber){
        var symbol = "CR";
        if(opening_balance < 0){
            symbol = "DR";
            opening_balance = -(opening_balance);
        }
        return '<tr class="invoicecal" id="'+oneRow["fk_client_code"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+moment(oneRow["payment_date"]).format('DD-MM-YYYY h:mm A')+'</td>'
                    +'<td>'+oneRow["notes"]+'</td>'
                    +'<td>'+debitAmount+'</td>'
                    +'<td>'+creditAmount+'</td>'
                    +'<td style="text-align: right;">'+opening_balance+' '+symbol+'</td>'
                +'</tr>';
    }

    function addInvoiceOpenrow(opening_balance){
        var symbol = "CR";
        if(opening_balance < 0){
            symbol = "DR";
            opening_balance = -(opening_balance);
        }
        return '<tr class="invoicecal">'
                    +'<td>1</td>'
                    +'<td></td>'
                    +'<td>OPENING BALANCE</td>'
                    +'<td></td>'
                    +'<td></td>'
                    +'<td style="text-align: right;">'+opening_balance+' '+symbol+'</td>'
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