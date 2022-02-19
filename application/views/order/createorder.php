
<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <div id="accordion">
            <div class="card">

                <div class="card-header" id="headingOne">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Order(#<?php echo $orderrefNumber; ?>) Herder information
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            
                        </div>
                        <div class="col-md-3 mb-3">
                             
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="btn-group">
                                <button type="button" class="btn select-dropdown-status-text btn-danger" style="text-transform: capitalize;" data-toggle="tooltip" title="If invoice infoamtion and Add Products are done. Please invoice status change to be complete">
                                    <?php if(isset($orderstatus)){ echo $orderstatus; }?>
                                </button>
                                <button type="button" class="btn select-dropdown-status-bottom-indicator btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item select-dropdown-status" id="create" hreflang="create" href="#">Create</a>
                                    <a class="dropdown-item select-dropdown-status" id="initiated" hreflang="initiated" href="#">Initiated</a>
                                    <a class="dropdown-item select-dropdown-status" id="pending" hreflang="pending" href="#">Pending</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item select-dropdown-status" id="completed" hreflang="completed" href="#">Completed</a>
                                    <a class="dropdown-item select-dropdown-status" id="partial_paid" hreflang="partial_paid" href="#">Partial Paid</a>
                                    <a class="dropdown-item select-dropdown-status" id="paid" hreflang="paid" href="#">Paid</a>
                                    <a class="dropdown-item select-dropdown-status" id="force_edit" hreflang="force_edit" href="#">Force Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php   $showheader = "";
                        $showinvoice = "";
                    if(isset($orderstatus)){
                        if($orderstatus === 'create'){
                            $showheader = "show";
                        }else{
                            $showinvoice = "show";
                        }
                    }
                    ?>
                <div id="collapseOne" class="collapse <?php echo $showheader; ?>" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <form class="orderheader" id="orderheader">
                            <input type="hidden" id="defaultorderID" name="defaultorderID" value="<?php echo $unique_order_code; ?>" />
                            
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                        <label for="userStatus">Select Client for order</label>
                                        <select class="form-control" id="clientcode" name="clientcode" style="text-transform: capitalize;">
                                            <option value="">Select Order Client Name</option>
                                            <?php $count = 0; 
                                                foreach($clients as $client){ ?>
                                                    <option value="<?php echo $client->code; ?>" <?php if($client->code == $clientcode){ echo"selected"; } ?> ><?php echo $client->name;?></option>
                                            <?php $count++; } ?>
                                        </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Client's Name</label>
                                    <input class="form-control" id="clientname" name="clientname" type="text" placeholder="Client's Name" value="<?php echo isset($clientname)? $clientname : ''; ?>" />
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Mobile Number</label>
                                    <input class="form-control" id="mobilenumber" name="mobilenumber" type="text" placeholder="Mobile Number" value="<?php echo isset($mobilenumber)? $mobilenumber : ''; ?>" />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Address</label>
                                    <input class="form-control" id="clintaddress" name="clintaddress" type="text" placeholder="Address" style="text-transform:uppercase" value="<?php echo isset($clintaddress)? $clintaddress : ''; ?>" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">State</label>
                                    <input class="form-control uppercase" id="clientState" name="clientState" type="text" placeholder="State" value="<?php echo isset($clientState)? $clientState : ''; ?>" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">District</label>
                                    <input class="form-control uppercase" id="clientDistrict" name="clientDistrict" type="text" placeholder="District" value="<?php echo isset($clientDistrict)? $clientDistrict : ''; ?>" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">City</label>
                                    <input class="form-control uppercase" id="clientcity" name="clientcity" type="text" placeholder="City" style="text-transform:uppercase" value="<?php echo isset($clientcity)? $clientcity : ''; ?>" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Area</label>
                                    <input class="form-control uppercase" id="clientarea" name="clientarea" type="text" placeholder="Area" value="<?php echo isset($clientarea)? $clientarea : ''; ?>" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Pin Code</label>
                                    <input class="form-control" id="clientpincode" name="clientpincode" type="number" placeholder="Pin Code" value="<?php echo isset($clientpincode)? $clientpincode : ''; ?>" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning mr-2 my-1 save-item-button" type="button">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                                Add Order(#<?php echo $orderrefNumber; ?>) Product 
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" onclick="addInvoiceItem()" class="btn btn-warning add-item-button" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                                    Add Product
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning">Receipt &nbsp;<i data-feather="file-text"></i></button>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split pdfdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createorderpdf'."/".$unique_order_code."/landscape/0"); ?>">Landscape Receipt</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createorderpdf'."/".$unique_order_code)."/portrait/0"; ?>">Portrait Receipt</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createorderpdf'."/".$unique_order_code."/landscape/1"); ?>">Landscape Receipt Download</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createorderpdf'."/".$unique_order_code)."/portrait/1"; ?>">Portrait Receipt Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h5>
                </div>

                <div id="collapseTwo" class="collapse <?php echo $showinvoice; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="forceclosegolobal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Product</button>
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
        <button type="button" class="btn btn-warning" id="add_item_to_invoice">Add Product</button>
      </div>
    </div>
  </div>
</div>


<script>
    var orderData = <?php echo json_encode($orderitemsList); ?>;
    var globalOrderStatus = "<?php echo $orderstatus; ?>";
    var globalInvoice_bill_include_tax = "no";
    $(document).ready(function(){
        
        $("#clientcode").change(function(){
            var selectedClientCode = $(this).children("option:selected").val();
            if( selectedClientCode.length > 0){
                $.ajax({
                url: '<?php echo base_url('/getclientid'); ?>',
                type: 'POST',
                dataType  : 'json',
                data: {uniqueCode: selectedClientCode},
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    $('#mobilenumber').val(data.mobile_no);
                    $('#clientname').val(data.name);
                    $('#clintaddress').val(data.address);
                    $('#clientcity').val(data.city);
                    $('#clientDistrict').val(data.district);
                    $('#clientState').val(data.state);
                    $('#clientarea').val(data.area);
                    $('#clientpincode').val(data.pin_code); 
                }
                });
            }
        });
        
        $("#invoicetype").change(function(){
            var selectedInvoiceType = $('#invoicetype').val();
            if( selectedInvoiceType.length > 0){
                $.ajax({
                url: '<?php echo base_url('/getinvoicelist'); ?>',
                type: 'POST',
                dataType  : 'json',
                data: {invoiceRefID: selectedInvoiceType},
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    $('#invoicetitle').val(data.title);
                    $('#invoicesubtitle').val(data.subtitle);
                    $('#paymentmode').val(data.payment_mode);
                    $('#vehicleno').val(data.vehicle);
                    $('#owninvoicemobileno').val(data.mobile);
                    $('#owninvoicegstin').val(data.gstnumber);
                }
                });
            }
        });

        //form header value check
        $('#orderheader').on('submit', function (e) {
            var order_id = $("#defaultorderID").val();
            var clientcode = $('#clientcode').val();
            var clientname = $('#clientname').val();
            var mobilenumber = $('#mobilenumber').val();

            var clintaddress = $('#clintaddress').val();
            var clientState = $('#clientState').val();
            var clientDistrict = $('#clientDistrict').val();
            var clientcity = $('#clientcity').val();
            var clientarea = $('#clientarea').val();
            var clientpincode = $('#clientpincode').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/saveorderheader'); ?>',
                dataType  : 'json',
                data: { defaultorderID: order_id, clientcode:  clientcode, clientname: clientname, mobilenumber: mobilenumber,
                    clintaddress: clintaddress, clientState: clientState, clientDistrict: clientDistrict, clientcity: clientcity, 
                    clientarea: clientarea, clientpincode: clientpincode},
                error: function(data) {
                    console.log(data);
                    // alert('Something is wrong');
                },
                success: function (data) {
                    alert(data.message);
                }
            });
        });

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
            var modelbutton = $("#add_item_to_invoice").text();
            if (modelbutton === "Add Product"){
                var item_code = $("#selectitemcode").val();
                var item_name = $("#itemdescription").val();
                var order_id = $("#defaultorderID").val();
                var quatity = $("#itemquantity").val();
                var itemunitcase = $("#itemcaseunit").val();
                var itemmrp = $("#itemmrp").val();
                var itemdiscount = $("#itemdiscount").val();
                var itemdmrpvalue = $("#itemmrpvalue").val();
                var itembillValue = $("#itembillValue").val();
                $("#collapseTwo").addClass("show");
                for(j=0;j<orderData.length; j++) {
                    var invoiceItemCode = orderData[j]["fk_item_code"];
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
                    url: '<?php echo base_url('/saveitemorder'); ?>',
                    data: {orderid: order_id, itemcode: item_code, itemname: item_name, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
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
                            orderData.push(data.previewData);
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
            }else if(modelbutton === "Update Product"){
                var itemID = $("#updateItemID").val();
                var item_code = $("#selectitemcode").val();
                var item_name = $("#itemdescription").val();
                var order_id = $("#defaultorderID").val();
                var quatity = $("#itemquantity").val();
                var itemunitcase = $("#itemcaseunit").val();
                var itemmrp = $("#itemmrp").val();
                var itemdiscount = $("#itemdiscount").val();
                var itemdmrpvalue = $("#itemmrpvalue").val();
                var itembillValue = $("#itembillValue").val();
                $("#collapseTwo").addClass("show");
                var shouldbeUpdate = false;
                for(j=0;j<orderData.length; j++) {
                    var orderItemCode = orderData[j]["fk_item_code"];
                    if (orderItemCode === item_code) {
                        shouldbeUpdate = true;
                    }
                }
                if(shouldbeUpdate == false){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Current selected item unmatched with updated item");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                }
                if(quatity <= 1){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Please check your inputs.");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/updateitemorder'); ?>',
                    data: {itemID: itemID, orderid: order_id, itemcode: item_code, itemname: item_name, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
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
                        $("#add_item_to_invoice").text("Add Product");
                        if(data.code){
                            console.log(data.previewData);
                            var updateIndex = -1;
                            for(j=0;j<orderData.length; j++) {
                                var invoiceItemCode = orderData[j]["pk_order_item_id"];
                                if (parseInt(invoiceItemCode) === parseInt(itemID)) {
                                    updateIndex = j;
                                }
                            }
                            orderData[updateIndex] = data.previewData;
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
    
        function setInvoiceStatus(invoiceStatus){
            console.log(invoiceStatus);
            var classColor = "red";
            var buttonColor = "btn-danger";
            switch(invoiceStatus){
                case "create":
                    $(".deleteItemlistkjsdksdj").removeAttr("disabled");
                    $(".editItemButton").removeAttr("disabled");
                    $(".add-item-button").removeAttr("disabled");
                    $(".save-item-button").removeAttr("disabled");
                    $("#initiated").removeClass("disabled");
                    $("#create, #pending, #completed, #partial_paid, #paid, #force_edit").addClass("disabled");
                    classColor = "red";
                    buttonColor = "btn-danger";
                    break;
                case "initiated":
                    $(".deleteItemlistkjsdksdj").removeAttr("disabled");
                    $(".editItemButton").removeAttr("disabled");
                    $(".add-item-button").removeAttr("disabled");
                    $(".save-item-button").removeAttr("disabled");
                    $("#pending").removeClass("disabled");
                    $("#initiated, #create, #completed, #force_edit, #partial_paid, #paid").addClass("disabled");
                    classColor = "red";
                    buttonColor = "btn-danger";
                    break;
                case "pending":
                    $(".deleteItemlistkjsdksdj").removeAttr("disabled");
                    $(".editItemButton").removeAttr("disabled");
                    $(".add-item-button").removeAttr("disabled");
                    $(".save-item-button").removeAttr("disabled");
                    $("#completed").removeClass("disabled");
                    $("#create, #pending, #initiated, #force_edit, #partial_paid, #paid").addClass("disabled");
                    classColor = "red";
                    buttonColor = "btn-danger";
                    break;
                case "completed":
                    $(".deleteItemlistkjsdksdj").attr("disabled", "disabled");
                    $(".editItemButton").attr("disabled", "disabled");
                    $(".add-item-button").attr("disabled", "disabled");
                    $(".save-item-button").attr("disabled", "disabled");
                    $("#create, #initiated, #pending, #completed").addClass("disabled");
                    $("#force_edit, #partial_paid, #paid").removeClass("disabled");
                    classColor = "yellow";
                    buttonColor = "btn-warning";
                    break;
                case "partial_paid":
                    $(".deleteItemlistkjsdksdj").attr("disabled", "disabled");
                    $(".editItemButton").attr("disabled", "disabled");
                    $(".add-item-button").attr("disabled", "disabled");
                    $(".save-item-button").attr("disabled", "disabled");
                    $("#create, #initiated, #pending, #partial_paid, #completed").addClass("disabled");
                    $("#force_edit, #paid").removeClass("disabled");
                    classColor = "green";
                    buttonColor = "btn-success";
                    break;
                case "paid":
                    $(".deleteItemlistkjsdksdj").attr("disabled", "disabled");
                    $(".editItemButton").attr("disabled", "disabled");
                    $(".add-item-button").attr("disabled", "disabled");
                    $(".save-item-button").attr("disabled", "disabled");
                    $("#create, #initiated, #pending, #completed, #partial_paid, #paid, #force_edit").addClass("disabled");
                    classColor = "green";
                    buttonColor = "btn-success";
                    break;
                case "force_edit":
                    $(".deleteItemlistkjsdksdj").removeAttr("disabled");
                    $(".editItemButton").removeAttr("disabled");
                    $(".add-item-button").removeAttr("disabled");
                    $(".save-item-button").removeAttr("disabled");
                    $("#create, #initiated, #pending, #partial_paid, #paid, #force_edit").addClass("disabled");
                    $("#completed").removeClass("disabled");
                    classColor = "red";
                    buttonColor = "btn-danger";
                break;   
            }

            $(".select-dropdown-status").removeClass("red");
            $(".select-dropdown-status").removeClass("green");
            $(".select-dropdown-status").removeClass("yellow");
            $("#"+invoiceStatus).addClass(classColor);
            $(".select-dropdown-status-text").text(invoiceStatus.replace("_"," "));

            $(".select-dropdown-status-text").removeClass("btn-success");
            $(".select-dropdown-status-text").removeClass("btn-danger");
            $(".select-dropdown-status-text").removeClass("btn-warning");
            $(".select-dropdown-status-text").addClass(buttonColor);

            $(".select-dropdown-status-bottom-indicator").removeClass("btn-success");
            $(".select-dropdown-status-bottom-indicator").removeClass("btn-danger");
            $(".select-dropdown-status-bottom-indicator").removeClass("btn-warning");
            $(".select-dropdown-status-bottom-indicator").addClass(buttonColor);
            
        }
        setInvoiceStatus("<?php echo $orderstatus; ?>");


        $('.select-dropdown-status').click(function(){
            var orderStatus = $(this).attr("hreflang");
            var defaultorderID = $("#defaultorderID").val();
            console.log(orderStatus);
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/updateorderstatus'); ?>',
                dataType  : 'json',
                data: {defaultorderID: defaultorderID, orderStatus: orderStatus },
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    console.log(data);
                    if (data.code){
                        globalOrderStatus = orderStatus;
                        setInvoiceStatus(orderStatus);
                    }
                }
            });
        });
    });
</script>
<script>
    function deleteOrderItem(itemOrderid) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteorderitem'); ?>',
                data: {itemOrderid: itemOrderid},
                error: function(request, error) {
                    console.log(arguments);
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.code){
                        var deleteIndex = -1;
                        for(j=0;j<orderData.length; j++) {
                            var orderItemCode = orderData[j]["pk_order_item_id"];
                            if (parseInt(orderItemCode) === parseInt(itemOrderid)) {
                                deleteIndex = j;
                            }
                        }
                        orderData.splice(deleteIndex, 1);

                        var row = $('#'+itemOrderid);
                        row.addClass("bg-danger");
                        row.hide(2000, function(){
                            this.remove(); 
                            showItemData();
                        });
                    }else{
                        alert(data.message)
                    }
                }
            });
        }
    }

    function addInvoiceItem(){
        $("#add_item_to_invoice").text("Add Product");
    }

    function editOrderItem(itemOrderCode) {
        var editIndex = -1;
        for(j=0;j<orderData.length; j++) {
            var orderItemCode = orderData[j]["pk_order_item_id"];
            if (parseInt(orderItemCode) === parseInt(itemOrderCode)) {
                editIndex = j;
            }
        }
        if (editIndex >= 0){
            var editPreviewData = orderData[editIndex];

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
            $("#updateItemID").val(itemOrderCode);
            $("#itemdescription").val(editPreviewData["fk_item_name"]);
            $("#defaultorderID").val(editPreviewData["fk_unique_order_code"]);
            $("#itemquantity").val(editPreviewData["quantity"]);
            $("#itemcaseunit").val(editPreviewData["case_unit"]);
            $("#itemmrp").val(editPreviewData["mrp"]);
            $("#itemdiscount").val(editPreviewData["discount"]);
            $("#itemmrpvalue").val(editPreviewData["mrp_value"]);
            $("#itembillValue").val(editPreviewData["bill_value"]);
            $("#add_item_to_invoice").text("Update Product");
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
            for(i=0;i<orderData.length; i++) {
                $('#invoiceBody').append(addInvoicerow(orderData[i], (i + 1) ));
                console.log(orderData[i]["pk_order_item_id"]);
                basic_value = parseFloat(basic_value) + parseFloat(((parseFloat(orderData[i]["bill_value"]) * 100) / 118).toFixed(2));
                mrp_value = parseFloat(mrp_value) + parseFloat(orderData[i]["mrp_value"]);
                bill_value = parseFloat(bill_value) + parseFloat(orderData[i]["bill_value"]);
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
            return '<tr class="invoicecal" id="'+oneRow["pk_order_item_id"]+'">'
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
                            +'<button type="button" onclick="editOrderItem('+oneRow["pk_order_item_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteOrderItem('+oneRow["pk_order_item_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                        +'</td>'
                    +'</tr>';
        }else{
            return '<tr class="invoicecal" id="'+oneRow["pk_order_item_id"]+'">'
                        +'<td>'+numberOne+'</td>'
                        +'<td>'+oneRow["fk_item_code"]+'</td>'
                        +'<td>'+oneRow["fk_item_name"]+'</td>'
                        +'<td>'+oneRow["quantity"]+'</td>'
                        +'<td>'+oneRow["mrp"]+'</td>'
                        +'<td>'+oneRow["mrp_value"]+'</td>'
                        +'<td>'+oneRow["discount"]+'</td>'
                        +'<td>'+parseFloat(oneRow["bill_value"]).toFixed(2)+'</td>'
                        +'<td>'
                            +'<button type="button" onclick="editOrderItem('+oneRow["pk_order_item_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteOrderItem('+oneRow["pk_order_item_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
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
    function invoiceCalCulationInfo(){
        var numberofrow = orderData.length;
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