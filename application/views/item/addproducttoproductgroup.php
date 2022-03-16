<?php 
    foreach($data as $value){ 
        $uniqueCode = $value->pk_gfi_unique_code;
        $productgroupName =  $value->name;
        $description = $value->description; 
    }
?>
<input type="hidden" id="defaultproductgroup" name="defaultproductgroup" value="<?php echo $uniqueCode; ?>" />
<div class="card">
    <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                    Add Invoice(#<?php echo $productgroupName; ?>) Items 
                    </button>
                </div>
                <div class="col-md-3 mb-3">
                </div>
                <div class="col-md-3 mb-3"> 
                </div>
                <div class="col-md-2 mb-3">
                    <button type="button" onclick="addInvoiceItem()" class="btn btn-warning add-item-button" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                        Add Item
                    </button>
                </div>
            </div>
        </h5>
    </div>

    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
            <!--- invoice table item--->
            <div class="datatable">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead id="invoicehead">
                            
                        </thead>
                        <tbody id="invoiceBody">
                        </tbody>
                    </table>
                </div>
            </div>
            <!----invoice table item-->
        </div>
    </div>

</div>




<!----Add item modal Start----->
<div class="modal fade" id="addItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="forceclosegolobal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Item</button>
                    <div id="myDropdown" class="dropdown-menu">
                            <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" autocomplete="off">
                            <?php $count = 1; 
                                foreach($itemsList as $item){ ?>
                                    <a class="dropdown-item small select-dropdown-item" hreflang="<?php echo $item->item_code; ?>"><?php echo $item->name." <span style='font-size:50%;'>🍦 (".$item->item_code.") &copy; ".$item->company_code." ₹(".$item->mrp.")</span>";?></a>
                            <?php $count++; } ?>
                    </div>
                </div>
                <input type="hidden" class="form-control" aria-label="Text input with dropdown button" id="selectitemcode" name="selectitemcode" >
                <input type="hidden" class="form-control"  id="defineunitcase" name="defineunitcase" value="">
                <input type="hidden" class="form-control"  id="updateItemID" name="updateItemID" value="">
                <input type="text" class="form-control" aria-label="Text input with dropdown button" id="itemdescription" name="itemdescription" value="" readonly>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Quantity</span>
                </div>
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemquantity" name="itemquantity" value="">
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Case/Unit</span>
                </div>
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemcaseunit" name="itemcaseunit" value="" >
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">MRP</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemmrp" name="itemmrp" value="" onchange="SetDefault($(this).val());" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" readonly>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">MRP Value</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemmrpvalue" name="itemmrpvalue" value="" readonly>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Discount(%)</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemdiscount" name="itemdiscount" value="">
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Bill Value</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itembillValue" name="itembillValue" value="">
            </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-warning" id="add_item_to_invoice">Add Item</button>
      </div>
    </div>
  </div>
</div>
<script>
    var globalproductgroupcode = "<?php echo $uniqueCode; ?>";
    var invoiceData = <?php echo json_encode($invoiceitemsList); ?>;
    var globalInvoice_bill_include_tax = "<?php echo $this->session->userdata('bill_include_tax'); ?>";
    $(document).ready(function(){
        $('.select-dropdown-item').click(function(){
            var itemCode = $(this).attr("hreflang");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/getitemcode'); ?>',
                dataType  : 'json',
                data: {itemcode: itemCode},
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    $('#selectitemcode').val(data[0].item_code);
                    $('#itemdescription').val(data[0].name);
                    $('#itemmrp').val(data[0].mrp);
                    $('#defineunitcase').val(data[0].unit_case);
                    invoiceCalculation();
                    // alert(data[0].name);
                }
            });
        });

        $('#add_item_to_invoice').click(function(){
            $("#myInput").val('');
            removefilterFunction();
            var modelbutton = $("#add_item_to_invoice").text();
            if (modelbutton === "Add Item"){
                var item_code = $("#selectitemcode").val();
                var item_name = $("#itemdescription").val();
                var productgroupcode = globalproductgroupcode;
                var quatity = $("#itemquantity").val();
                var itemunitcase = $("#itemcaseunit").val();
                var itemmrp = $("#itemmrp").val();
                var itemdiscount = $("#itemdiscount").val();
                var itemdmrpvalue = $("#itemmrpvalue").val();
                var itembillValue = $("#itembillValue").val();
                $("#collapseTwo").addClass("show");
                for(j=0;j<invoiceData.length; j++) {
                    var invoiceItemCode = invoiceData[j]["fk_item_code"];
                    if (invoiceItemCode === item_code) {
                        $("#successfullyMessage").addClass('alert-danger');
                        $("#successfullyMessage").text("Already added this item. Please edit to continue.");
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                        return;
                    }
                }
                if(quatity < 1){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Please check your inputs.");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/saveproducttoproductgroup'); ?>',
                    data: {productgroupcode: productgroupcode, itemcode: item_code, itemname: item_name, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
                    error: function(request, error) {
                        console.log(arguments);
                        $("#successfullyMessage").addClass('alert-danger');
                        $("#successfullyMessage").text("Something went wrong");
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        console.log(data);
                        $("#selectitemcode").val('');
                        $("#itemdescription").val('');
                        $("#itemquantity").val('');
                        $("#itemmrp").val('');
                        $("#itemdiscount").val('');
                        $("#itemmrpvalue").val('');
                        $("#itembillValue").val('');
                        $("#itemcaseunit").val('');
                        $("#defineunitcase").val('');
                        if(data.code){
                            console.log(data.previewData);
                            invoiceData.push(data.previewData);
                            showItemData();
                            $("#successfullyMessage").addClass('alert-success');
                        }else{
                            $("#successfullyMessage").addClass('alert-danger');
                        }
                        $("#successfullyMessage").text(data.message);
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                    }
                });
            }else if(modelbutton === "Update Item"){
                var itemID = $("#updateItemID").val();
                var item_code = $("#selectitemcode").val();
                var item_name = $("#itemdescription").val();
                var productgroupcode = globalproductgroupcode;
                var quatity = $("#itemquantity").val();
                var itemunitcase = $("#itemcaseunit").val();
                var itemmrp = $("#itemmrp").val();
                var itemdiscount = $("#itemdiscount").val();
                var itemdmrpvalue = $("#itemmrpvalue").val();
                var itembillValue = $("#itembillValue").val();
                $("#collapseTwo").addClass("show");
                var shouldbeUpdate = false;
                for(j=0;j<invoiceData.length; j++) {
                    var invoiceItemCode = invoiceData[j]["fk_item_code"];
                    if (invoiceItemCode === item_code) {
                        shouldbeUpdate = true;
                    }
                }
                if(shouldbeUpdate == false){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Current selected item unmatched with updated item");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                }
                if(quatity < 1){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Please check your inputs.");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/updateproducttoproductgroup'); ?>',
                    data: {itemID: itemID, productgroupcode: productgroupcode, itemcode: item_code, itemname: item_name, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
                    error: function(request, error) {
                        console.log(arguments);
                        $("#successfullyMessage").addClass('alert-danger');
                        $("#successfullyMessage").text("Something went wrong");
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        console.log(data);
                        $("#updateItemID").val('');
                        $("#selectitemcode").val('');
                        $("#itemdescription").val('');
                        $("#itemquantity").val('');
                        $("#itemmrp").val('');
                        $("#itemdiscount").val('');
                        $("#itemmrpvalue").val('');
                        $("#itembillValue").val('');
                        $("#itemcaseunit").val('');
                        $("#defineunitcase").val('');
                        $("#add_item_to_invoice").text("Add Item");
                        if(data.code){
                            console.log(data.previewData);
                            var updateIndex = -1;
                            for(j=0;j<invoiceData.length; j++) {
                                var invoiceItemCode = invoiceData[j]["goi_id"];
                                if (parseInt(invoiceItemCode) === parseInt(itemID)) {
                                    updateIndex = j;
                                }
                            }
                            invoiceData[updateIndex] = data.previewData;
                            showItemData();
                            $('#addItemInput').modal('hide')
                            $("#successfullyMessage").addClass('alert-success');
                        }else{
                            $("#successfullyMessage").addClass('alert-danger');
                        }
                        $("#successfullyMessage").text(data.message);
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                    }
                });
            }
        });

        $("#itemquantity").keyup(function(){
            invoiceCalculation();
        });

        $("#itemdiscount").keyup(function(){
            invoiceCalculation();
        });

        $("#itembillValue").keyup(function(){
            var quatity = $("#itemquantity").val();
            var itemmrp = $("#itemmrp").val();
            var itembillvalue = $("#itembillValue").val();
            var mrpvalue = quatity * itemmrp;
            var mrppercentage = parseFloat(((mrpvalue - itembillvalue) * 100) / mrpvalue).toFixed(2)
            $("#itemdiscount").val(mrppercentage);
        });

        $("#itemcaseunit").keyup(function(){
            var totalunitcasevalue = $('#itemcaseunit').val();
            var defineuintcase = $("#defineunitcase").val();
            var quatity = totalunitcasevalue * defineuintcase;
            var itemmrp = $("#itemmrp").val();
            var itemdiscount = $("#itemdiscount").val();
            var mrpvalue = quatity * itemmrp;
            var discountrs = (mrpvalue * itemdiscount) / 100;
            var itembillvalue = mrpvalue - discountrs;
            $("#itemquantity").val(quatity);
            $("#itemmrpvalue").val(mrpvalue);
            $("#itembillValue").val(itembillvalue);
        });

        function invoiceCalculation(){
            var quatity = $("#itemquantity").val();
            var itemmrp = $("#itemmrp").val();
            var itemdiscount = $("#itemdiscount").val();
            var defineuintcase = $("#defineunitcase").val();
            var mrpvalue = quatity * itemmrp;
            var discountrs = (mrpvalue * itemdiscount) / 100;
            var itembillvalue = mrpvalue - discountrs;
            var totalunitcasevalue = parseFloat(quatity / defineuintcase).toFixed(2);
            $('#itemcaseunit').val(totalunitcasevalue);
            $("#itemmrpvalue").val(mrpvalue);
            $("#itembillValue").val(itembillvalue);
        }

        //Model close action
        $('#forceclose, #forceclosegolobal').click(function(){
            $("#selectitemcode").val('');
                    $("#itemdescription").val('');
                    $("#itemquantity").val('');
                    $("#itemmrp").val('');
                    $("#itemdiscount").val('');
                    $("#itemmrpvalue").val('');
                    $("#itembillValue").val('');
                    $("#itemcaseunit").val('');
                    $("#defineunitcase").val('');
        });
        $('#invoicehead').append(addHeader());
        showItemData();

        $("#myDropdown").attrchange({
            trackValues: true,
            callback: function(evnt) {
                if(evnt.attributeName == "class") { 
                    console.log("input"+evnt.newValue.search(/show/i));
                    if(evnt.newValue.search(/show/i) == 14) { 
                        $('#myInput').focus(); 
                    }
                }
            }
        });
    });
</script>
<script>
    function deleteInvoiceItem(productgroupCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteproducttoproductgroup'); ?>',
                data: {productgroupCode: productgroupCode},
                error: function(request, error) {
                    console.log(arguments);
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.code){
                        var deleteIndex = -1;
                        for(j=0;j<invoiceData.length; j++) {
                            var invoiceItemCode = invoiceData[j]["goi_id"];
                            if (parseInt(invoiceItemCode) === parseInt(productgroupCode)) {
                                deleteIndex = j;
                            }
                        }
                        invoiceData.splice(deleteIndex, 1);

                        var row = $('#'+productgroupCode);
                        row.addClass("bg-danger");
                        row.hide(2000, function(){
                            this.remove(); 
                            showItemData();
                        });
                        // alert(data.message)
                    }else{
                        alert(data.message)
                    }
                }
            });
        }
    }

    function addInvoiceItem(){
        $("#add_item_to_invoice").text("Add Item");
    }

    function editInvoiceItem(itemInvoiceCode) {
        var editIndex = -1;
        for(j=0;j<invoiceData.length; j++) {
            var invoiceItemCode = invoiceData[j]["goi_id"];
            if (parseInt(invoiceItemCode) === parseInt(itemInvoiceCode)) {
                editIndex = j;
            }
        }
        if (editIndex >= 0){
            var editPreviewData = invoiceData[editIndex];

            var itemCode = editPreviewData["fk_item_code"];
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/getitemcode'); ?>',
                dataType  : 'json',
                data: {itemcode: itemCode},
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    $('#selectitemcode').val(data[0].item_code);
                    $('#itemdescription').val(data[0].name);
                    $('#itemmrp').val(data[0].mrp);
                    $('#defineunitcase').val(data[0].unit_case);
                }
            });
            $("#selectitemcode").val(editPreviewData["fk_item_code"]);
            $("#updateItemID").val(itemInvoiceCode);
            $("#itemdescription").val(editPreviewData["fk_item_name"]);
            $("#defaultproductgroup").val(editPreviewData["defaultproductgroup"]);
            $("#itemquantity").val(editPreviewData["quantity"]);
            $("#itemcaseunit").val(editPreviewData["case_unit"]);
            $("#itemmrp").val(editPreviewData["mrp"]);
            $("#itemdiscount").val(editPreviewData["discount"]);
            $("#itemmrpvalue").val(editPreviewData["mrp_value"]);
            $("#itembillValue").val(editPreviewData["bill_value"]);
            $("#add_item_to_invoice").text("Update Item");
        }else{
            alert("Something went wrong")
        }
        
    }

    function showItemData(){
            $('tbody').empty();
            var mrp_value = 0;
            var bill_value = 0;
            var basic_value = 0.0;
            var count = 1;
            for(i=0;i<invoiceData.length; i++) {
                $('#invoiceBody').append(addInvoicerow(invoiceData[i], (i + 1) ));
                console.log(invoiceData[i]["goi_id"]);
                basic_value = parseFloat(basic_value) + parseFloat(((parseFloat(invoiceData[i]["bill_value"]) * 100) / 118).toFixed(2));
                mrp_value = parseFloat(mrp_value) + parseFloat(invoiceData[i]["mrp_value"]);
                bill_value = parseFloat(bill_value) + parseFloat(invoiceData[i]["bill_value"]);
            }
            $('#invoiceBody').append(addInvoiceCalculation(bill_value, mrp_value, basic_value));
            invoiceCalCulationInfo();
    }
    function addHeader(){
        if (globalInvoice_bill_include_tax === 'yes'){
            return '<tr class="invoicecal">'
                        +'<th width="60px;">#</th>'
                        +'<th width="100px;">Item Code</th>'
                        +'<th>Name</th>'
                        +'<th width="70px;">QTY</th>'
                        +'<th width="70px;">MRP</th>'
                        +'<th width="100px;">MRP Value</th>'
                        +'<th width="70px;">DS%</th>'
                        +'<th width="100px;">Bas. Val</th>'
                        +'<th width="100px;">Bill Value</th>'
                        +'<th width="80px;">Actions</th>'
                    +'</tr>';
        }else{
            return '<tr class="invoicecal">'
                        +'<th width="60px;">#</th>'
                        +'<th width="100px;">Item Code</th>'
                        +'<th>Name</th>'
                        +'<th width="70px;">QTY</th>'
                        +'<th width="70px;">MRP</th>'
                        +'<th width="100px;">MRP Value</th>'
                        +'<th width="70px;">DS%</th>'
                        +'<th width="100px;">Bill Value</th>'
                        +'<th width="80px;">Actions</th>'
                    +'</tr>';
        }
    }

    function addInvoicerow(oneRow, numberOne){
        if (globalInvoice_bill_include_tax === 'yes'){
            var basicValue = ((parseFloat(oneRow["bill_value"]) * 100) / 118).toFixed(2);
            return '<tr class="invoicecal" id="'+oneRow["goi_id"]+'">'
                        +'<td>'+numberOne+'</td>'
                        +'<td>'+oneRow["fk_item_code"]+'</td>'
                        +'<td>'+oneRow["fk_item_name"]+'</td>'
                        +'<td>'+oneRow["quantity"]+'</td>'
                        +'<td>'+oneRow["mrp"]+'</td>'
                        +'<td>'+oneRow["mrp_value"]+'</td>'
                        +'<td>'+oneRow["discount"]+'</td>'
                        +'<td>'+basicValue+'</td>'
                        +'<td>'+parseFloat(oneRow["bill_value"]).toFixed(2)+'</td>'
                        +'<td>'
                            +'<button type="button" onclick="editInvoiceItem('+oneRow["goi_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteInvoiceItem('+oneRow["goi_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                        +'</td>'
                    +'</tr>';
        }else{
            return '<tr class="invoicecal" id="'+oneRow["goi_id"]+'">'
                        +'<td>'+numberOne+'</td>'
                        +'<td>'+oneRow["fk_item_code"]+'</td>'
                        +'<td>'+oneRow["fk_item_name"]+'</td>'
                        +'<td>'+oneRow["quantity"]+'</td>'
                        +'<td>'+oneRow["mrp"]+'</td>'
                        +'<td>'+oneRow["mrp_value"]+'</td>'
                        +'<td>'+oneRow["discount"]+'</td>'
                        +'<td>'+parseFloat(oneRow["bill_value"]).toFixed(2)+'</td>'
                        +'<td>'
                            +'<button type="button" onclick="editInvoiceItem('+oneRow["goi_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteInvoiceItem('+oneRow["goi_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                        +'</td>'
                    +'</tr>';
        }
    }

    function addInvoiceCalculation(bill_value, mrp_value, basic_value){
        var basic_value = parseFloat(basic_value).toFixed(2);
        var basicValue = ((parseFloat(bill_value) * 100) / 118).toFixed(2);
        var cgstValue = ((parseFloat(basicValue) * 9) / 100).toFixed(2);
        var total_cgst_value = (parseFloat(basic_value) + parseFloat(cgstValue)).toFixed(2);
        var sgstValue = cgstValue;
        var total_cgst_sgst_value = (parseFloat(total_cgst_value) + parseFloat(sgstValue)).toFixed(2);
        var bill_amount = Math.round(parseFloat(bill_value).toFixed(2));
        var round_off = (parseFloat(bill_amount) - parseFloat(total_cgst_sgst_value)).toFixed(2);
        var round_off_without_gst = (parseFloat(bill_amount) - parseFloat(bill_value)).toFixed(2);
        var total_saving = parseFloat(mrp_value) - parseFloat(bill_amount);
        if (globalInvoice_bill_include_tax === 'yes'){
            return  '<tr class="invoicecal">'
                        +'<td colspan="5"></td>'
                        +'<td><b>'+parseFloat(mrp_value).toFixed(2)+'</b></td>'
                        +'<td></td>'
                        +'<td><b>'+parseFloat(basic_value).toFixed(2)+'</b></td>'
                        +'<td><b>'+parseFloat(bill_value).toFixed(2)+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="5" rowspan="7"></td>'
                        +'<td colspan="3">BASIC VALUE RS.</td>'
                        +'<td>'+basic_value+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">CGST 9.00%</td>'
                        +'<td>'+cgstValue+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">TOTAL RS.</td>'
                        +'<td>'+total_cgst_value+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">SGST 9.00%</td>'
                        +'<td>'+sgstValue+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">TOTAL RS.</td>'
                        +'<td>'+total_cgst_sgst_value+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">ROUND OFF</td>'
                        +'<td>'+round_off+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">BILL AMOUNT</td>'
                        +'<td>'+bill_amount+'</td>'
                    +'</tr>';
        }else{
            return  '<tr class="invoicecal">'
                        +'<td colspan="5"></td>'
                        +'<td><b>'+parseFloat(mrp_value).toFixed(2)+'</b></td>'
                        +'<td></td>'
                        +'<td><b>'+parseFloat(bill_value).toFixed(2)+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="5"></td>'
                        +'<td colspan="2">ROUND OFF</td>'
                        +'<td>'+round_off_without_gst+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="5"><center><b>TOTAL SAVING: '+total_saving+'</b></center></td>'
                        +'<td colspan="2">BILL AMOUNT</td>'
                        +'<td><b>'+bill_amount+'</b></td>'
                    +'</tr>';
        }
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }

    function removefilterFunction() {
        var a; 
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            a[i].style.display = ""; 
        }
    }

    function invoiceCalCulationInfo(){
        var numberofrow = invoiceData.length;
        var pdfdropdown = $(".pdfdropdown");
        if(numberofrow >= 1){
            $('.invoicecal').show();
            pdfdropdown.removeAttr("disabled");
        }else{
            $('.invoicecal').hide();
            pdfdropdown.attr("disabled", "disabled");
        }
    }

</script>