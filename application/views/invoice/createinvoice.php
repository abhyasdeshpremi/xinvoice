
<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <div id="accordion">
            <!---Create invoice header information card--->
            <div class="card">

                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Invoice Herder information
                        </button>
                    </h5>
                </div>
                <?php   $showheader = "";
                        $showinvoice = "";
                    if(isset($invoicestatus)){
                        if($invoicestatus === 'create'){
                            $showheader = "show";
                        }else{
                            $showinvoice = "show";
                        }
                    }
                    ?>
                <div id="collapseOne" class="collapse <?php echo $showheader; ?>" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <form class="purchaseinvoice" id="purchaseinvoice">
                            <input type="hidden" id="defaultinvoiceID" name="defaultinvoiceID" value="<?php echo $invoiceid; ?>" />
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="userStatus">Invoice Type</label>
                                    <select class="form-control" id="invoicetype" name="invoicetype" style="text-transform: capitalize;">
                                            <option value="">Select</option>
                                            <?php $count = 1; 
                                                foreach($invoiceTypes as $invoice){ ?>
                                                    <option value="<?php echo $invoice->invoice_reference_id; ?>"><?php echo "Invoice v_".$count;?></option>
                                            <?php $count++; } ?>
                                        </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault03">Invoice Title <span class="requiredClass">*</span></label>
                                    <input class="form-control" id="invoicetitle" name="invoicetitle" type="text" placeholder="Invoice Title" style="text-transform:uppercase" value="<?php echo isset($invoicetitle)? $invoicetitle : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Invoice Sub Title <span class="requiredClass">*</span></label>
                                    <input class="form-control" id="invoicesubtitle" name="invoicesubtitle" type="text" placeholder="Invoice Sub Title" value="<?php echo isset($invoicesubtitle)? $invoicesubtitle : ''; ?>" required/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Payment mode</label>
                                    <input class="form-control" id="paymentmode" name="paymentmode" type="text" placeholder="Payment mode" value="<?php echo isset($paymentmode)? $paymentmode : ''; ?>" required/>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Vehicle No.</label>
                                    <input class="form-control" id="vehicleno" name="vehicleno" type="text" placeholder="Vehicle No." value="<?php echo isset($vehicleno)? $vehicleno : ''; ?>"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">GST IN</label>
                                    <input class="form-control" id="owninvoicegstin" name="owninvoicegstin" type="text" placeholder="GST IN" value="<?php echo isset($owninvoicegstin)? $owninvoicegstin : ''; ?>" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Mobile No.</label>
                                    <input class="form-control" id="owninvoicemobileno" name="owninvoicemobileno" type="text" placeholder="Mobile No." value="<?php echo isset($owninvoicemobileno)? $owninvoicemobileno : ''; ?>"/>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Invoice Reference Number</label>
                                    <input class="form-control" id="invoicerefNumber" name="invoicerefNumber" type="text" placeholder="Invoice Reference Number" value="<?php echo isset($invoicerefNumber)? $invoicerefNumber : ''; ?>"/>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="saveinvoice" id="saveinvoice" name="saveinvoice"  />
                                <label class="form-check-label text-primary" for="saveinvoice">
                                    Are you want to save above invoice header information?
                                </label>
                            </div>
                           <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                        <label for="userStatus">To Invoice Client Name</label>
                                        <select class="form-control" id="clientcode" name="clientcode" style="text-transform: capitalize;">
                                            <option value="">Select Invoice Client Name</option>
                                            <?php $count = 0; 
                                                foreach($clients as $client){ ?>
                                                    <option value="<?php echo $client->code; ?>" <?php if($client->code == $clientcode){ echo"selected"; } ?> ><?php echo $client->name;?></option>
                                            <?php $count++; } ?>
                                        </select>
                                        <input type="hidden" name="clientname" id="clientname" value="" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">GST IN</label>
                                    <input class="form-control" id="gstin" name="gstin" type="text" placeholder="GST IN" value="<?php echo isset($gstin)? $gstin : ''; ?>" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">PAN No.</label>
                                    <input class="form-control" id="pannumber" name="pannumber" type="text" placeholder="Pan No." value="<?php echo isset($pannumber)? $pannumber : ''; ?>" />
                                </div>
                                
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Mobile Number</label>
                                    <input class="form-control" id="mobilenumber" name="mobilenumber" type="text" placeholder="Mobile Number" value="<?php echo isset($mobilenumber)? $mobilenumber : ''; ?>" />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Address</label>
                                    <input class="form-control" id="clintaddress" name="clintaddress" type="text" placeholder="Address" style="text-transform:uppercase" value="<?php echo isset($clintaddress)? $clintaddress : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">State</label>
                                    <input class="form-control" id="clientState" name="clientState" type="text" placeholder="State" value="<?php echo isset($clientState)? $clientState : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">District</label>
                                    <input class="form-control" id="clientDistrict" name="clientDistrict" type="text" placeholder="District" value="<?php echo isset($clientDistrict)? $clientDistrict : ''; ?>" required/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">City</label>
                                    <input class="form-control" id="clientcity" name="clientcity" type="text" placeholder="City" style="text-transform:uppercase" value="<?php echo isset($clientcity)? $clientcity : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Area</label>
                                    <input class="form-control" id="clientarea" name="clientarea" type="text" placeholder="Area" value="<?php echo isset($clientarea)? $clientarea : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Pin Code</label>
                                    <input class="form-control" id="clientpincode" name="clientpincode" type="text" placeholder="Pin Code" value="<?php echo isset($clientpincode)? $clientpincode : ''; ?>" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2 my-1" type="button">Save invoice</button>
                        </form>
                    </div>
                </div>
            </div><!----close card--->
            <!---End invoice header information card--->
            <!---Create invoice items card--->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                                Add Invoice Items 
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                                    Add Item
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">INVOICE &nbsp;<i data-feather="file-text"></i></button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split pdfdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createinvoicepdf'."/".$invoiceid."/landscape/0"); ?>">Landscape Invoice</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createinvoicepdf'."/".$invoiceid)."/portrait/0"; ?>">Portrait Invoice</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createinvoicepdf'."/".$invoiceid."/landscape/1"); ?>">Landscape Invoice Download</a>
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createinvoicepdf'."/".$invoiceid)."/portrait/1"; ?>">Portrait Invoice Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h5>
                </div>

                <div id="collapseTwo" class="collapse <?php echo $showinvoice; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <!--- invoice table item--->
                        <div class="datatable">
                            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="invoicecal">
                                            <th width="60px;">#</th>
                                            <th width="100px;">Item Code</th>
                                            <th>Name</th>
                                            <th width="70px;">QTY</th>
                                            <th width="70px;">MRP</th>
                                            <th width="100px;">MRP Value</th>
                                            <th width="70px;">DS%</th>
                                            <th width="100px;">Bill Value</th>
                                            <th width="80px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                              $mrp_value = 0;
                                              $bill_value = 0;
                                        foreach($invoiceitemsList as $value){ 
                                            $mrp_value = $mrp_value + $value->mrp_value;
                                            $bill_value = $bill_value + $value->bill_value;
                                            ?>
                                            <tr class="invoicecal">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $value->fk_item_code; ?></td>
                                                <td><?php echo $value->fk_item_name; ?></td>
                                                <td><?php echo $value->quantity; ?></td>
                                                <td><?php echo $value->mrp; ?></td>
                                                <td><?php echo $value->mrp_value; ?></td>
                                                <td><?php echo $value->discount; ?></td>
                                                <td><?php echo $value->bill_value; ?></td>
                                                <td>
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="more-vertical"></i></button>
                                                    <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>
                                                </td>
                                            </tr>
                                        <?php $i++; } ?>
                                            <input type="hidden" id="numberofinvoiceitem" value="<?php echo $i; ?>" />
                                            <tr class="invoicecal">
                                                <td colspan="5"></td>
                                                <td><b><?php echo $mrp_value; ?></b></td>
                                                <td></td>
                                                <td><b><?php echo $bill_value; ?></b></td>
                                            </tr>
                                            <?php 
                                               $basicValue = round((($bill_value * 100) / 118), 2);
                                               $cgstValue = round((($basicValue * 9) / 100), 2);
                                               $total_cgst_value = $basicValue + $cgstValue;
                                               $sgstValue = $cgstValue;
                                               $total_cgst_sgst_value = ($total_cgst_value + $sgstValue);
                                               $bill_amount = round($total_cgst_sgst_value, 0);
                                               $round_off = round(($bill_amount - $total_cgst_sgst_value), 2);
                                            ?>
                                            <tr class="invoicecal">
                                                <td colspan="4" rowspan="7"></td>
                                                <td colspan="3">BASIC VALUE RS.</td>
                                                <td><?php echo $basicValue; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">CGST 9.00%</td>
                                                <td><?php echo $cgstValue; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">TOTAL RS.</td>
                                                <td><?php echo $total_cgst_value; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">SGST 9.00%</td>
                                                <td><?php echo $sgstValue; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">TOTAL RS.</td>
                                                <td><?php echo $total_cgst_sgst_value; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">ROUND OFF</td>
                                                <td><?php echo $round_off; ?></td>
                                            </tr>
                                            <tr class="invoicecal">
                                                <td colspan="3">BILL AMOUNT</td>
                                                <td><?php echo $bill_amount; ?></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!----invoice table item-->
                    </div>
                </div>

            </div>

            <!---End invoice items card--->
        </div><!---close accordion-->

    </div>
</div>

<!----Add item modal Start----->
<div class="modal fade" id="addItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Item</button>
                    <div class="dropdown-menu">
                            <?php $count = 1; 
                                foreach($itemsList as $item){ ?>
                                    <a class="dropdown-item small select-dropdown-item" hreflang="<?php echo $item->item_code; ?>"><?php echo $item->name." <span style='font-size:50%;'>🍦 (".$item->item_code.") &copy; ".$item->company_code." ₹(".$item->mrp.")</span>";?></a>
                            <?php $count++; } ?>
                    </div>
                </div>
                <input type="hidden" class="form-control" aria-label="Text input with dropdown button" id="selectitemcode" name="selectitemcode" >
                <input type="hidden" class="form-control"  id="defineunitcase" name="defineunitcase" value="">
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
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemcaseunit" name="itemcaseunit" value="" readonly>
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
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itembillValue" name="itembillValue" value="" readonly>
            </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-primary" id="add_item_to_invoice">Add Item</button>
      </div>
    </div>
  </div>
</div>

<!----Add item modal end----->

<script>
    
    $(document).ready(function(){
        //Client type auto fill
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
                    $('#gstin').val(data.gst_no);
                    $('#pannumber').val(data.pan_no);
                    $('#mobilenumber').val(data.mobile_no);
                    $('#clientname').val(data.name);
                    $('#clintaddress').val(data.address);
                    $('#clientcity').val(data.city);
                    $('#clientDistrict').val(data.district);
                    $('#clientState').val(data.state);
                    $('#clientarea').val(data.area);
                    $('#clientpincode').val(data.pin_code);
                    // alert("Record added successfully"+ data.name);  
                }
                });
            }
        });
        //Invoice type select
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
        $('#purchaseinvoice').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/savevoiceheader'); ?>',
                dataType  : 'json',
                data: $('#purchaseinvoice').serialize(),
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    alert(data.message);
                }
            });
        });

        $('.select-dropdown-item').click(function(){
            var itemCode = $(this).attr("hreflang");
            // alert("The paragraph was clicked."+itemCode);
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
                    $('#itemmrp').val(data[0].cost_price);
                    $('#defineunitcase').val(data[0].unit_case);
                    invoiceCalculation();
                    // alert(data[0].name);
                }
            });
        });

        $('#add_item_to_invoice').click(function(){
            
            var item_code = $("#selectitemcode").val();
            var item_name = $("#itemdescription").val();
            var invoice_id = $("#defaultinvoiceID").val();
            var quatity = $("#itemquantity").val();
            var itemunitcase = $("#itemcaseunit").val();
            var itemmrp = $("#itemmrp").val();
            var itemdiscount = $("#itemdiscount").val();
            var itemdmrpvalue = $("#itemmrpvalue").val();
            var itembillValue = $("#itembillValue").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/saveitemininvoce'); ?>',
                data: {invoiceid: invoice_id, itemcode: item_code, itemname: item_name, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
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
                        $("#successfullyMessage").addClass('alert-success');
                    }else{
                        $("#successfullyMessage").addClass('alert-danger');
                    }
                    $("#successfullyMessage").text(data.message);
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();

                    // var myModal = $('#addItemInput');
                    // clearTimeout(myModal.data('hideInterval'));
                    // myModal.data('hideInterval', setTimeout(function(){
                    //     myModal.modal('hide');
                    // }, 1000));
                }
            });
        });

        //Item calculation
        $("#itemquantity, #itemdiscount").keyup(function(){
            invoiceCalculation();
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

        invoiceCalCulationInfo();
        function invoiceCalCulationInfo(){
            var numberofrow = $('#numberofinvoiceitem').val();
            var pdfdropdown = $(".pdfdropdown");
            if(numberofrow > 1){
                $('.invoicecal').show();
                pdfdropdown.removeAttr("disabled");
            }else{
                $('.invoicecal').hide();
                pdfdropdown.attr("disabled", "disabled");
            }
        }
    });
</script>
