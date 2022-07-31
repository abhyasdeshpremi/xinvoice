
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
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Invoice(#<?php echo $invoicerefNumber; ?>) Herder information(Standard)
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo (isset($clientname)) ? $clientname : ''; ?>
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                             
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="btn-group">
                                <button type="button" class="btn select-dropdown-status-text btn-danger" style="text-transform: capitalize;" data-toggle="tooltip" title="If invoice infoamtion and add items are done. Please invoice status change to be complete">
                                    <?php if(isset($invoicestatus)){ echo $invoicestatus; }?>
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
                                    <select class="form-control selectpicker border" id="invoicetype" name="invoicetype" style="text-transform: capitalize;" data-live-search="true">
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
                                    <select class="form-control" id="paymentmode" name="paymentmode" style="text-transform: capitalize;">
                                        <option value="CASE" <?php if($paymentmode == "CASE") { echo 'selected="selected"'; }?>>CASH</option>
                                        <option value="CREDIT" <?php if($paymentmode == "CREDIT") { echo 'selected="selected"'; }?>>CREDIT</option>
                                    </select>
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
                                    <input class="form-control" id="invoicerefNumber" name="invoicerefNumber" type="text" placeholder="Invoice Reference Number" value="<?php echo isset($invoicerefNumber)? $invoicerefNumber : ''; ?>" readonly/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Reverse Charge</label>
                                    <select class="form-control" id="reversecharge" name="reversecharge" style="text-transform: capitalize;">
                                        <option value="N" <?php if($reversecharge == "N") { echo 'selected="selected"'; }?>>No</option>
                                        <option value="Y" <?php if($reversecharge == "Y") { echo 'selected="selected"'; }?>>Yes</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Place of supply</label>
                                    <input class="form-control" id="placeofsupply" name="placeofsupply" type="text" placeholder="Place of supply" value="<?php echo isset($placeofsupply)? $placeofsupply : ''; ?>"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">GG/RR No.</label>
                                    <input class="form-control" id="GGRRNo" name="GGRRNo" type="text" placeholder="GG/RR No." value="<?php echo isset($GGRRNo)? $GGRRNo : ''; ?>" />
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Transport</label>
                                    <input class="form-control" id="transport" name="transport" type="text" placeholder="Transport" value="<?php echo isset($transport)? $transport : ''; ?>"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Station</label>
                                    <input class="form-control" id="station" name="station" type="text" placeholder="Station" value="<?php echo isset($station)? $station : ''; ?>"/>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">E-Way Bill no.</label>
                                    <input class="form-control" id="ewaybillno" name="ewaybillno" type="text" placeholder="E-Way Bill no." value="<?php echo isset($ewaybillno)? $ewaybillno : ''; ?>"/>
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
                                        <label for="userStatus">To Invoice Client Name &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('/createclient'); ?>">Add new Client</a></label>
                                        <select class="form-control selectpicker border" id="clientcode" name="clientcode" style="text-transform: capitalize;" data-live-search="true">
                                            <option value="">Select Invoice Client Name</option>
                                            <?php $count = 0; 
                                                foreach($clients as $client){ ?>
                                                    <option value="<?php echo $client->code; ?>" <?php if($client->code == $clientcode){ echo"selected"; } ?> ><?php echo $client->name;?></option>
                                            <?php $count++; } ?>
                                        </select>
                                        <!-- <input type="hidden" name="clientname" id="clientname" value="<?php echo $clientname; ?>" /> -->
                                </div>
                                <div class="col-md-6 mb-3">
                                        <label for="userStatus">To Invoice Client Name</label>
                                        <input class="form-control" type="text" name="clientname" id="clientname" value="<?php echo $clientname; ?>" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">GST IN</label>
                                    <input class="form-control" id="gstin" name="gstin" type="text" placeholder="GST IN" value="<?php echo isset($gstin)? $gstin : ''; ?>" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">PAN No.</label>
                                    <input class="form-control" id="pannumber" name="pannumber" type="text" placeholder="Pan No." value="<?php echo isset($pannumber)? $pannumber : ''; ?>" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Mobile Number</label>
                                    <input class="form-control" id="mobilenumber" name="mobilenumber" type="text" placeholder="Mobile Number" value="<?php echo isset($mobilenumber)? $mobilenumber : ''; ?>" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Aadhar Number</label>
                                    <input class="form-control" id="aadharnumber" name="aadharnumber" type="text" placeholder="Aadhar Number" value="<?php echo isset($aadharnumber)? $aadharnumber : ''; ?>" />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Address</label>
                                    <input class="form-control" id="clintaddress" name="clintaddress" type="text" placeholder="Address" style="text-transform:uppercase" value="<?php echo isset($clintaddress)? $clintaddress : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">State</label>
                                    <input class="form-control uppercase" id="clientState" name="clientState" type="text" placeholder="State" value="<?php echo isset($clientState)? $clientState : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">District</label>
                                    <input class="form-control uppercase" id="clientDistrict" name="clientDistrict" type="text" placeholder="District" value="<?php echo isset($clientDistrict)? $clientDistrict : ''; ?>" required/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">City</label>
                                    <input class="form-control uppercase" id="clientcity" name="clientcity" type="text" placeholder="City" style="text-transform:uppercase" value="<?php echo isset($clientcity)? $clientcity : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Area</label>
                                    <input class="form-control uppercase" id="clientarea" name="clientarea" type="text" placeholder="Area" value="<?php echo isset($clientarea)? $clientarea : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Pin Code</label>
                                    <input class="form-control" id="clientpincode" name="clientpincode" type="number" placeholder="Pin Code" value="<?php echo isset($clientpincode)? $clientpincode : ''; ?>" />
                                </div>
                            </div>
                            <!--------Shipped address-Start--------->
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                        <label for="userStatus">Shipped Invoice Client Name</label>
                                        <select class="form-control selectpicker border" id="clientcodes" name="clientcodes" style="text-transform: capitalize;" data-live-search="true">
                                            <option value="">Select Invoice Client Name</option>
                                            <?php $count = 0; 
                                                foreach($clients as $client){ ?>
                                                    <option value="<?php echo $client->code; ?>" <?php if($client->code == $clientcodes){ echo"selected"; } ?> ><?php echo $client->name;?></option>
                                            <?php $count++; } ?>
                                        </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                        <label for="userStatus">Shipped Invoice Client Name</label>
                                        <input class="form-control" type="text" name="clientnames" id="clientnames" value="<?php echo isset($clientnames)? $clientnames : ''; ?>" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">GST IN</label>
                                    <input class="form-control" id="gstins" name="gstins" type="text" placeholder="GST IN" value="<?php echo isset($gstins)? $gstins : ''; ?>" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">PAN No.</label>
                                    <input class="form-control" id="pannumbers" name="pannumbers" type="text" placeholder="Pan No." value="<?php echo isset($pannumbers)? $pannumbers : ''; ?>" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Mobile Number</label>
                                    <input class="form-control" id="mobilenumbers" name="mobilenumbers" type="text" placeholder="Mobile Number" value="<?php echo isset($mobilenumbers)? $mobilenumbers : ''; ?>" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Aadhar Number</label>
                                    <input class="form-control" id="aadharnumbers" name="aadharnumbers" type="text" placeholder="Aadhar Number" value="<?php echo isset($aadharnumbers)? $aadharnumbers : ''; ?>" />
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Address</label>
                                    <input class="form-control" id="clintaddresss" name="clintaddresss" type="text" placeholder="Address" style="text-transform:uppercase" value="<?php echo isset($clintaddresss)? $clintaddresss : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">State</label>
                                    <input class="form-control uppercase" id="clientStates" name="clientStates" type="text" placeholder="State" value="<?php echo isset($clientStates)? $clientStates : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">District</label>
                                    <input class="form-control uppercase" id="clientDistricts" name="clientDistricts" type="text" placeholder="District" value="<?php echo isset($clientDistricts)? $clientDistricts : ''; ?>" required/>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">City</label>
                                    <input class="form-control uppercase" id="clientcitys" name="clientcitys" type="text" placeholder="City" style="text-transform:uppercase" value="<?php echo isset($clientcitys)? $clientcitys : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Area</label>
                                    <input class="form-control uppercase" id="clientareas" name="clientareas" type="text" placeholder="Area" value="<?php echo isset($clientareas)? $clientareas : ''; ?>" required/>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Pin Code</label>
                                    <input class="form-control" id="clientpincodes" name="clientpincodes" type="number" placeholder="Pin Code" value="<?php echo isset($clientpincodes)? $clientpincodes : ''; ?>" />
                                </div>
                            </div>
                            <!-------------Shipped address-end-------------------->
                            <button type="submit" class="btn btn-warning mr-2 my-1 save-item-button" type="button">Save invoice</button>
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
                                Add Invoice(#<?php echo $invoicerefNumber; ?>) Items 
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                            </div>
                            <div class="col-md-2 mb-3">
                            <button type="button" onclick="addInvoiceItem()" class="btn btn-warning add-item-button" data-toggle="modal" data-target="#addGroupItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                                    Add Group Item
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" onclick="addInvoiceItem()" class="btn btn-warning add-item-button" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                                    Add Item
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning">INVOICE &nbsp;<i data-feather="file-text"></i></button>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split pdfdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- <a class="dropdown-item" target="_blank" href="<?php //echo base_url('/createinvoicepdf'."/".$invoiceid."/landscape/0"); ?>">Landscape Invoice</a> -->
                                        <a class="dropdown-item"  href="<?php echo base_url('/viewinvoicepdf'."/".$invoiceid)."/portrait/0/A4"; ?>">View Invoice(A4)</a>
                                        <a class="dropdown-item"  href="<?php echo base_url('/viewinvoicepdf'."/".$invoiceid)."/portrait/0/A5"; ?>">View Invoice(A5)</a>
                                        <!-- <a class="dropdown-item" target="_blank" href="<?php //echo base_url('/createinvoicepdf'."/".$invoiceid."/landscape/1"); ?>">Landscape Invoice Download</a> -->
                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/createinvoicepdf'."/".$invoiceid)."/portrait/1/A4"; ?>" download>Download Invoice</a>
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
                                    <a class="dropdown-item small select-dropdown-item" hreflang="<?php echo $item->item_code; ?>"><?php echo $item->name." <span style='font-size:50%;'> (".$item->item_code.") &copy; ".$item->company_code." ₹(".$item->mrp.") ".$item->Style_No." ".$item->HSN_Code."</span>";?></a>
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
                    <span class="input-group-text" id="inputGroup-sizing-sm">HSN Code</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemhsncode" name="itemhsncode" value="" readonly>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Style No.</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="itemstyleno" name="itemstyleno" value="" readonly>
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

<!----Add item modal end----->


<!----Add Group item modal Start----->
<div class="modal fade" id="addGroupItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Group Item</h5>
        <a href="<?php echo base_url('createproductgroup'); ?>"><i data-feather="plus-circle"></i></a>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="forceclosegolobal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyGroupMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Group Item</button>
                    <div id="myGroupDropdown" class="dropdown-menu">
                            <input type="text" placeholder="Search.." id="myGroupInput" onkeyup="filterGroupFunction()" autocomplete="off">
                            <?php $count = 1; 
                                foreach($itemsGroupList as $item){ ?>
                                    <a class="dropdown-item small select-group-dropdown-item" hreflang="<?php echo $item->pk_gfi_unique_code; ?>"><?php echo $item->name;?></a>
                            <?php $count++; } ?>
                    </div>
                </div>
                <input type="hidden" class="form-control" aria-label="Text input with dropdown button" id="selectgroupitemcode" name="selectgroupitemcode" >
                <input type="text" class="form-control" aria-label="Text input with dropdown button" id="itemedgroupscription" name="itemedgroupscription" value="" readonly>
            </div>
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Quantity</span>
                </div>
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="groupitemquantity" name="groupitemquantity" value="">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-warning" id="add_group_item_to_invoice">Add Group Item</button>
      </div>
    </div>
  </div>
</div>

<!----Add Group item modal end----->


<script>
    var invoiceData = <?php echo json_encode($invoiceitemsList); ?>;
    var globalInvoiceStatus = "<?php echo $invoicestatus; ?>";
    var globalInvoice_bill_include_tax = "<?php echo $this->session->userdata('bill_include_tax'); ?>";
    var cgstrate = "<?php echo $this->session->userdata('cgstrate'); ?>";
    var sgstrate = "<?php echo $this->session->userdata('sgstrate'); ?>";
    var igstrate = "<?php echo $this->session->userdata('igstrate'); ?>";
    var applyedSameStateGST = true;
    var clientState = "<?php echo $clientState; ?>";
    var firmState = "<?php echo $this->session->userdata('firm_state'); ?>";
    
    if(clientState.toLowerCase() !== firmState.toLowerCase()){
        applyedSameStateGST = false;
    }

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
                    $('#aadharnumber').val(data.aadhar_no);
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
        //Shipped address
        $("#clientcodes").change(function(){
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
                    $('#gstins').val(data.gst_no);
                    $('#pannumbers').val(data.pan_no);
                    $('#mobilenumbers').val(data.mobile_no);
                    $('#aadharnumbers').val(data.aadhar_no);
                    $('#clientnames').val(data.name);
                    $('#clintaddresss').val(data.address);
                    $('#clientcitys').val(data.city);
                    $('#clientDistricts').val(data.district);
                    $('#clientStates').val(data.state);
                    $('#clientareas').val(data.area);
                    $('#clientpincodes').val(data.pin_code);
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
            var invoice_id = $("#defaultinvoiceID").val();
            var invoicetitle = $('#invoicetitle').val();
            var invoicesubtitle = $('#invoicesubtitle').val();
            var paymentmode = $('#paymentmode').val();
            var vehicleno = $('#vehicleno').val();
            var owninvoicegstin = $('#owninvoicegstin').val();
            var owninvoicemobileno = $('#owninvoicemobileno').val();
            var invoicerefNumber = $('#invoicerefNumber').val();
            var clientcode = $('#clientcode').val();
            var clientname = $('#clientname').val();
            var gstin = $('#gstin').val();
            var pannumber = $('#pannumber').val();
            var mobilenumber = $('#mobilenumber').val();
            var aadharnumber = $('#aadharnumber').val();
            
            var clintaddress = $('#clintaddress').val();
            var clientState = $('#clientState').val();
            var clientDistrict = $('#clientDistrict').val();
            var clientcity = $('#clientcity').val();
            var clientarea = $('#clientarea').val();
            var clientpincode = $('#clientpincode').val();

            var clientcodes = $('#clientcodes').val();
            var clientnames = $('#clientnames').val();
            var gstins = $('#gstins').val();
            var pannumbers = $('#pannumbers').val();
            var mobilenumbers = $('#mobilenumbers').val();
            var aadharnumbers = $('#aadharnumbers').val();
            
            var clintaddresss = $('#clintaddresss').val();
            var clientStates = $('#clientStates').val();
            var clientDistricts = $('#clientDistricts').val();
            var clientcitys = $('#clientcitys').val();
            var clientareas = $('#clientareas').val();
            var clientpincodes = $('#clientpincodes').val();

            var reversecharge = $('#reversecharge').val();
            var placeofsupply = $('#placeofsupply').val();
            var GGRRNo = $('#GGRRNo').val();
            var transport = $('#transport').val();
            var station = $('#station').val();
            var ewaybillno = $('#ewaybillno').val();

            var saveinvoice = "NOTSELECTED";
            $('input[name="saveinvoice"]:checked').each(function() {
                saveinvoice = "saveinvoice";
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/savevoiceheader'); ?>',
                dataType  : 'json',
                data: { defaultinvoiceID: invoice_id, invoicetitle: invoicetitle, invoicesubtitle: invoicesubtitle, paymentmode: paymentmode,
                    vehicleno: vehicleno, owninvoicegstin: owninvoicegstin, owninvoicemobileno: owninvoicemobileno, invoicerefNumber: invoicerefNumber,
                    clientcode:  clientcode, clientname: clientname, gstin: gstin, pannumber: pannumber, mobilenumber: mobilenumber, aadharnumber: aadharnumber,
                    clintaddress: clintaddress, clientState: clientState, clientDistrict: clientDistrict, clientcity: clientcity, 
                    clientarea: clientarea, clientpincode: clientpincode, clientcodes:  clientcodes, clientnames: clientnames, gstins: gstins, pannumbers: pannumbers, mobilenumbers: mobilenumbers, aadharnumbers: aadharnumbers,
                    clintaddresss: clintaddresss, clientStates: clientStates, clientDistricts: clientDistricts, clientcitys: clientcitys, 
                    clientareas: clientareas, clientpincodes: clientpincodes, reversecharge: reversecharge, placeofsupply: placeofsupply, GGRRNo: GGRRNo, transport: transport, 
                    station: station, ewaybillno: ewaybillno, saveinvoice: saveinvoice},
                error: function(error) {
                    alert('Something is wrong');
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
                    $('#itemhsncode').val(data[0].HSN_Code);
                    $('#itemstyleno').val(data[0].Style_No);
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
                var item_hsncode = $("#itemhsncode").val();
                var item_styleno = $("#itemstyleno").val();
                var invoice_id = $("#defaultinvoiceID").val();
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
                    url: '<?php echo base_url('/saveitemininvoce'); ?>',
                    data: {invoiceid: invoice_id, itemcode: item_code, itemname: item_name, item_hsncode: item_hsncode, item_styleno: item_styleno, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
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
                        $("#itemhsncode").val('');
                        $("#itemstyleno").val('');
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
                var item_hsncode = $("#itemhsncode").val();
                var item_styleno = $("#itemstyleno").val();
                var invoice_id = $("#defaultinvoiceID").val();
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
                if(quatity <= 1){
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Please check your inputs.");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/updateitemininvoce'); ?>',
                    data: {itemID: itemID, invoiceid: invoice_id, itemcode: item_code, itemname: item_name, item_hsncode: item_hsncode, item_styleno: item_styleno, quatity: quatity, itemunitcase: itemunitcase, itemmrp: itemmrp, itemdiscount: itemdiscount, itemdmrpvalue: itemdmrpvalue, itembillValue: itembillValue},
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
                        $("#itemhsncode").val('');
                        $("#itemstyleno").val('');
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
                                var invoiceItemCode = invoiceData[j]["pk_invoice_item_id"];
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

        //Item calculation
        $("#itemquantity").keyup(function(){
            invoiceCalculation();
            /*
            var item_code = $("#selectitemcode").val();
            var quatity = $("#itemquantity").val();
            $.ajax({
                type: 'POST',
                url: '<?php //echo base_url('/getstockquantity'); ?>',
                data: {item_code: item_code},
                error: function(request, error) {
                    console.log(arguments);
                    $("#itemquantity").val('');
                    invoiceCalculation();
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Something went wrong");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var stockQuantity = data.quantity;
                        if(stockQuantity >= quatity){
                            invoiceCalculation();
                        }else{
                            $("#itemquantity").val('');
                            invoiceCalculation();
                            $("#successfullyMessage").addClass('alert-danger');
                            $("#successfullyMessage").text("Stock in less than your need. Please check available stock");
                            $('#successfullyMessage').fadeIn();
                            $('#successfullyMessage').delay(4000).fadeOut();
                        }
                    }else{
                        $("#itemquantity").val('');
                        invoiceCalculation();
                        $("#successfullyMessage").addClass('alert-danger');
                        $("#successfullyMessage").text("Stock in less than your need. Please check available stock");
                        $('#successfullyMessage').fadeIn();
                        $('#successfullyMessage').delay(4000).fadeOut();
                    }
                }
            });
            */
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
            if(totalunitcasevalue == "0.00"){
                $('#itemcaseunit').val('');
            }else{
                $('#itemcaseunit').val(totalunitcasevalue);
            }
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
        setInvoiceStatus("<?php echo $invoicestatus; ?>");


        $('.select-dropdown-status').click(function(){
            showloader();
            var invoiceStatus = $(this).attr("hreflang");
            var invoice_id = $("#defaultinvoiceID").val();
            console.log(invoiceStatus);
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/updateinvoicestatus'); ?>',
                dataType  : 'json',
                data: {invoiceid: invoice_id, invoiceStatus: invoiceStatus },
                error: function() {
                    hideloader();
                    alert('Something is wrong');
                },
                success: function (data) {
                    console.log(data);
                    if (data.code){
                        globalInvoiceStatus = invoiceStatus;
                        setInvoiceStatus(invoiceStatus);
                    }
                    hideloader();
                }
            });
        });
        
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

        /****
         * group item code
         */

        $('.select-group-dropdown-item').click(function(){
            var groupitemcode = $(this).attr("hreflang");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/getgroupitemcode'); ?>',
                dataType  : 'json',
                data: {groupitemcode: groupitemcode},
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    $('#selectgroupitemcode').val(data[0].pk_gfi_unique_code);
                    $('#itemedgroupscription').val(data[0].name);
                    $('#groupitemquantity').val(1);
                }
            });
        });

        $('#add_group_item_to_invoice').click(function(){
            $("#myGroupInput").val('');
            removeGroupfilterFunction(); 
            var selectgroupitemcode = $("#selectgroupitemcode").val();
            var invoice_id = $("#defaultinvoiceID").val();
            var quatity = $("#groupitemquantity").val();
            $("#collapseTwo").addClass("show"); 

            if(quatity < 1){
                $("#successfullyGroupMessage").addClass('alert-danger');
                $("#successfullyGroupMessage").text("Please check your inputs.");
                $('#successfullyGroupMessage').fadeIn();
                $('#successfullyGroupMessage').delay(4000).fadeOut();
                return;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/savegroupitemininvoce'); ?>',
                data: {invoiceid: invoice_id, selectgroupitemcode: selectgroupitemcode, quatity: quatity},
                error: function(request, error) {
                    console.log(arguments);
                    $("#successfullyGroupMessage").addClass('alert-danger');
                    $("#successfullyGroupMessage").text("Something went wrong");
                    $('#successfullyGroupMessage').fadeIn();
                    $('#successfullyGroupMessage').delay(4000).fadeOut();
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    $("#selectgroupitemcode").val('');
                    $("#itemedgroupscription").val('');
                    $("#groupitemquantity").val('');
                    if(data.code){
                        for (i = 0; i < data.previewData.length; ++i) {
                            console.log(data.previewData[i]);
                            var shouldbeUpdate = false;
                            var invoiceDataIndex = -1;
                            for(j=0;j<invoiceData.length; j++) {
                                var invoiceItemCode = invoiceData[j]["fk_item_code"];
                                if (invoiceItemCode === data.previewData[i]["fk_item_code"]) {
                                    shouldbeUpdate = true;
                                    invoiceDataIndex = i;
                                }
                            }
                            if(shouldbeUpdate){
                                invoiceData[invoiceDataIndex] = data.previewData[i];
                            }else{
                                invoiceData.push(data.previewData[i]);
                            }
                        }
                        showItemData();
                        $("#successfullyGroupMessage").addClass('alert-success');
                    }else{
                        $("#successfullyGroupMessage").addClass('alert-danger');
                    }
                    $("#successfullyGroupMessage").text(data.message);
                    $('#successfullyGroupMessage').fadeIn();
                    $('#successfullyGroupMessage').delay(4000).fadeOut();
                }
            });
        });
    });
</script>
<script>
    function deleteInvoiceItem(itemInvoiceCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteinvoiceitem'); ?>',
                data: {itemInvoiceCode: itemInvoiceCode},
                error: function(request, error) {
                    console.log(arguments);
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.code){
                        var deleteIndex = -1;
                        for(j=0;j<invoiceData.length; j++) {
                            var invoiceItemCode = invoiceData[j]["pk_invoice_item_id"];
                            if (parseInt(invoiceItemCode) === parseInt(itemInvoiceCode)) {
                                deleteIndex = j;
                            }
                        }
                        invoiceData.splice(deleteIndex, 1);

                        var row = $('#'+itemInvoiceCode);
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
            var invoiceItemCode = invoiceData[j]["pk_invoice_item_id"];
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
            $("#defaultinvoiceID").val(editPreviewData["fk_unique_invioce_code"]);
            $("#itemquantity").val(editPreviewData["quantity"]);
            $("#itemcaseunit").val(editPreviewData["case_unit"]);
            $("#itemmrp").val(editPreviewData["mrp"]);
            $("#itemdiscount").val(editPreviewData["discount"]);
            $("#itemmrpvalue").val(editPreviewData["mrp_value"]);
            $("#itembillValue").val(editPreviewData["bill_value"]);
            $("#itemhsncode").val(editPreviewData["HSN_Code"]);
            $("#itemstyleno").val(editPreviewData["Style_No"]);
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
                console.log(invoiceData[i]["pk_invoice_item_id"]);
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
                        +'<th>Name</th>'
                        +'<th width="30px;">HSN</th>'
                        +'<th width="70px;">STYLE#</th>'
                        +'<th width="70px;">QTY</th>'
                        +'<th width="100px;">RATE</th>'
                        +'<th width="100px;">RATE Val.</th>'
                        +'<th width="70px;">DS%</th>'
                        +'<th width="100px;">Amount</th>'
                        +'<th width="80px;">Actions</th>'
                    +'</tr>';
        }else{
            return '<tr class="invoicecal">'
                        +'<th width="60px;">#</th>'
                        +'<th>Name</th>'
                        +'<th width="30px;">HSN</th>'
                        +'<th width="70px;">STYLE#</th>'
                        +'<th width="70px;">QTY</th>'
                        +'<th width="100px;">RATE</th>'
                        +'<th width="100px;">RATE Val.</th>'
                        +'<th width="70px;">DS%</th>'
                        +'<th width="100px;">Amount</th>'
                        +'<th width="80px;">Actions</th>'
                    +'</tr>';
        }
    }

    function addInvoicerow(oneRow, numberOne){
        if (globalInvoice_bill_include_tax === 'yes'){
            return '<tr class="invoicecal" id="'+oneRow["pk_invoice_item_id"]+'">'
                        +'<td>'+numberOne+'</td>'
                        +'<td>'+oneRow["fk_item_name"]+'</td>'
                        +'<td>'+oneRow["HSN_Code"]+'</td>'
                        +'<td>'+oneRow["Style_No"]+'</td>'
                        +'<td>'+oneRow["quantity"]+'</td>'
                        +'<td>'+oneRow["mrp"]+'</td>'
                        +'<td>'+oneRow["mrp_value"]+'</td>'
                        +'<td>'+oneRow["discount"]+'</td>'
                        +'<td>'+parseFloat(oneRow["bill_value"]).toFixed(2)+'</td>'
                        +'<td>'
                            +'<button type="button" onclick="editInvoiceItem('+oneRow["pk_invoice_item_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteInvoiceItem('+oneRow["pk_invoice_item_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                        +'</td>'
                    +'</tr>';
        }else{
            return '<tr class="invoicecal" id="'+oneRow["pk_invoice_item_id"]+'">'
                        +'<td>'+numberOne+'</td>'
                        +'<td>'+oneRow["fk_item_name"]+'</td>'
                        +'<td>'+oneRow["HSN_Code"]+'</td>'
                        +'<td>'+oneRow["Style_No"]+'</td>'
                        +'<td>'+oneRow["quantity"]+'</td>'
                        +'<td>'+oneRow["mrp"]+'</td>'
                        +'<td>'+oneRow["mrp_value"]+'</td>'
                        +'<td>'+oneRow["discount"]+'</td>'
                        +'<td>'+parseFloat(oneRow["bill_value"]).toFixed(2)+'</td>'
                        +'<td>'
                            +'<button type="button" onclick="editInvoiceItem('+oneRow["pk_invoice_item_id"]+')" class="btn btn-datatable btn-icon editItemButton" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false"><i data-feather="more-vertical"></i></button>&nbsp;&nbsp;'
                            +'<button type="button" onclick="deleteInvoiceItem('+oneRow["pk_invoice_item_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                        +'</td>'
                    +'</tr>';
        }
    }

    function addInvoiceCalculation(bill_value, mrp_value, basic_value){
        var basic_value = parseFloat(basic_value).toFixed(2);
        if (globalInvoice_bill_include_tax === 'yes'){
            if(applyedSameStateGST){
                var cgstValue = ((parseFloat(bill_value) * parseFloat(cgstrate)) / 100).toFixed(2);
                var total_cgst_value = (parseFloat(bill_value) + parseFloat(cgstValue)).toFixed(2);
                var sgstValue = ((parseFloat(bill_value) * parseFloat(sgstrate)) / 100).toFixed(2);
                var total_cgst_sgst_value = (parseFloat(total_cgst_value) + parseFloat(sgstValue)).toFixed(2);
            }else{
                var igstValue = ((parseFloat(bill_value) * parseFloat(igstrate)) / 100).toFixed(2);
                var total_cgst_sgst_value = (parseFloat(bill_value) + parseFloat(igstValue)).toFixed(2);
            }
            var bill_amount = Math.round(parseFloat(total_cgst_sgst_value).toFixed(2));
        }else{
            var bill_amount = Math.round(parseFloat(bill_value).toFixed(2));
        }
        var round_off = (parseFloat(bill_amount) - parseFloat(total_cgst_sgst_value)).toFixed(2);
        var round_off_without_gst = (parseFloat(bill_amount) - parseFloat(bill_value)).toFixed(2);
        var total_saving = parseFloat(mrp_value) - parseFloat(bill_amount);

        if (globalInvoice_bill_include_tax === 'yes'){
            if(applyedSameStateGST){
                return  '<tr class="invoicecal">'
                        +'<td colspan="6"></td>'
                        +'<td><b>'+parseFloat(mrp_value).toFixed(2)+'</b></td>'
                        +'<td></td>'
                        +'<td><b>'+parseFloat(bill_value).toFixed(2)+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="5" rowspan="7"></td>'
                        +'<td colspan="3">CGST '+cgstrate+'%</td>'
                        +'<td>'+cgstValue+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">SGST '+sgstrate+'%</td>'
                        +'<td>'+sgstValue+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">ROUND OFF</td>'
                        +'<td>'+round_off+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">BILL AMOUNT</td>'
                        +'<td>'+bill_amount.toFixed(2)+'</td>'
                    +'</tr>';
            }else{
                return  '<tr class="invoicecal">'
                        +'<td colspan="6"></td>'
                        +'<td><b>'+parseFloat(mrp_value).toFixed(2)+'</b></td>'
                        +'<td></td>'
                        +'<td><b>'+parseFloat(bill_value).toFixed(2)+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="5" rowspan="7"></td>'
                        +'<td colspan="3">IGST '+igstrate+'%</td>'
                        +'<td>'+igstValue+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">ROUND OFF</td>'
                        +'<td>'+round_off+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="3">BILL AMOUNT</td>'
                        +'<td>'+bill_amount.toFixed(2)+'</td>'
                    +'</tr>';
            }
            
        }else{
            var totalsaving = "";
            if(total_saving > 0){
                totalsaving = "TOTAL SAVING: "+total_saving;
            }
            return  '<tr class="invoicecal">'
                        +'<td colspan="6"></td>'
                        +'<td><b>'+parseFloat(mrp_value).toFixed(2)+'</b></td>'
                        +'<td></td>'
                        +'<td><b>'+parseFloat(bill_value).toFixed(2)+'</b></td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="6"></td>'
                        +'<td colspan="2">ROUND OFF</td>'
                        +'<td>'+round_off_without_gst+'</td>'
                    +'</tr>'
                    +'<tr class="invoicecal">'
                        +'<td colspan="6"><center><b>'+totalsaving+'</b></center></td>'
                        +'<td colspan="2">BILL AMOUNT</td>'
                        +'<td><b>'+bill_amount.toFixed(2)+'</b></td>'
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

    function filterGroupFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myGroupInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myGroupDropdown");
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

    function removeGroupfilterFunction() {
        var a; 
        div = document.getElementById("myGroupDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            a[i].style.display = ""; 
        }
    }

</script>
<!-- <script type="text/javascript">
    $(window).on('beforeunload', function(){
        var invoiceStatus = ['completed', 'partial_paid', 'paid'];
        if (!invoiceStatus.find((str) => str === globalInvoiceStatus)){
            var confirm=alert();
            if(confirm){
                return true;
            } else
            return false;
        }
    });
</script> -->