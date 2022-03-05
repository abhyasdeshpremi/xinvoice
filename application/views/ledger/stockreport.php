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
    var base_url = "<?php echo base_url('/downloadpdf'); ?>";
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#startDate").attr("value", today);
    $("#endDate").attr("value", today);

    $("#applySearch").click(function(){
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        if((startDate.length > 0) && (endDate.length > 0) ){ 
            $('#stockreporthead').html('');
            $('#stockreportBody').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/stockreport'); ?>',
                dataType  : 'json',
                data: {start_date: $('#startDate').val(), end_date: $('#endDate').val()},
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    if (data.code){
                        $('#stockreporthead').append(addHeader());
                        console.log(data);
                        var result = data.result;
                        var total_stock_value = 0.0;
                        for(i=0;i<result.length; i++) {
                            var oneRow = result[i];
                            var buy_count = parseFloat(oneRow["buy_count_value"]);
                            var sell_count = parseFloat(oneRow["sell_count_value"]);
                            var total_count = parseFloat(oneRow["item_total_count"]);
                            var opening_value = (total_count + sell_count - buy_count);
                            var bill_per_item_value = parseFloat(oneRow["bill_per_item_value"]);
                            var total_value = parseFloat(bill_per_item_value * total_count).toFixed(2);
                            total_stock_value = parseFloat(total_stock_value) + parseFloat(total_value);
                            $('#stockreportBody').append(addInvoicerow(oneRow, opening_value, total_value, (i + 1)) );
                        }
                        $('#stockreportBody').append(addResultrow(total_stock_value));
                        var printurl = base_url + "/" +$('#startDate').val()+"/"+$('#endDate').val();
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
                    +'<th width="100px;">Item Code</th>'
                    +'<th>Name</th>'
                    +'<th width="100px;">op. qty.</th>'
                    +'<th width="70px;">Purchase</th>'
                    +'<th width="100px;">Sales</th>'
                    +'<th width="70px;">Closing</th>'
                    +'<th width="100px;">Value rs.</th>'
                +'</tr>';
    }

    function addInvoicerow(oneRow, opening_value, total_value, countNumber){
        
        return '<tr class="invoicecal" id="'+oneRow["item_code"]+'">'
                    +'<td>'+countNumber+'</td>'
                    +'<td>'+oneRow["item_code"]+'</td>'
                    +'<td>'+oneRow["item_name"]+'</td>'
                    +'<td>'+opening_value+'</td>'

                    +'<td>'+oneRow["buy_count_value"]+'</td>'
                    +'<td>'+oneRow["sell_count_value"]+'</td>'

                    +'<td>'+oneRow["item_total_count"]+'</td>'
                    +'<td>'+total_value+'</td>'
                +'</tr>';
    }

    function addResultrow(total_stock_value){
        return '<tr class="invoicecal" >'
                    +'<td colspan="7"></td>'
                    +'<td><b>'+total_stock_value.toFixed(2)+'</b></td>'
                +'</tr>';
    }

});
</script>