<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <?php 
            foreach($data as $value){ 
                $uniqueCode = $value->firm_code;
                $firmName =  $value->name;

                $firmMobile = $value->mobile_number;
                $firmEmail =  $value->firm_email;
                $description = $value->description;

                $firmAddress =  $value->address;
                $firmArea = $value->area;
                $firmCity =  $value->city;
                $firmdistrict = $value->district;
                $firmState =  $value->state;
                $firmZip = $value->pin_code;
                $firmStatus = $value->status;
                $billIncludeTax = $value->bill_include_tax;
                $firmbonus = $value->bonus_percent;
                $firmbusiness_type = $value->business_type;
                $feature_group_for_item = $value->feature_group_for_item;
                $feature_capture_saved_amount = $value->feature_capture_saved_amount;
                $invoice_format = $value->invoice_format;
                $invoice_pdf_format = $value->invoice_pdf_format;
                $cgstrate = $value->cgstrate;
                $sgstrate = $value->sgstrate;
                $igstrate = $value->igstrate;
            }
        ?>
        <form class="updateFirm" action="" method="POST" id="updateFirm">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Firm Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required readonly/>
                </div>
                <div class="col-md-4 mb-3">
                <label for="userStatus">Business Type</label>
                    <select class="form-control" id="business_type" name="business_type">
                        <?php foreach($business_types as $business_type){ ?>
                        <option value="<?php echo $business_type->business_code; ?>" <?php if($firmbusiness_type == $business_type->business_code){ echo 'selected'; } ?>><?php echo $business_type->business_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firmName" name="firmName" type="text" placeholder="Firm Name" value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firmMobile" name="firmMobile" type="text" placeholder="Firm Mobile" value="<?php echo isset($firmMobile)? $firmMobile : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Email</label>
                    <input class="form-control" id="firmEmail" name="firmEmail" type="email" placeholder="Firm Email" value="<?php echo isset($firmEmail)? $firmEmail : ''; ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($description)? $description : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1">Address</label>
                <input class="form-control" id="firmAddress" name="firmAddress" type="text" placeholder="Address" value="<?php echo isset($firmAddress)? $firmAddress : ''; ?>" />
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Area</label>
                    <input class="form-control uppercase" id="firmArea" name="firmArea" type="text" placeholder="Area" value="<?php echo isset($firmArea)? $firmArea : ''; ?>" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">City</label>
                    <input class="form-control uppercase" id="firmCity" name="firmCity" type="text" placeholder="City" value="<?php echo isset($firmCity)? $firmCity : ''; ?>" />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">District</label>
                    <input type="text" class="form-control uppercase" id="firmdistrict" name="firmdistrict" placeholder="District" value="<?php echo isset($firmdistrict)? $firmdistrict : ''; ?>" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">State</label>
                    <input type="text" class="form-control uppercase" id="firmState" name="firmState" placeholder="State" value="<?php echo isset($firmState)? $firmState : ''; ?>" >
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Zip</label>
                    <input type="number" class="form-control" id="firmZip" name="firmZip" placeholder="Zip" value="<?php echo isset($firmZip)? $firmZip : ''; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                <label for="userStatus">Status</label>
                    <select class="form-control" id="firmstatus" name="firmstatus">
                        <option value="pending" <?php if($firmStatus == 'pending'){ echo 'selected'; } ?>>Pending</option>
                        <option value="active" <?php if($firmStatus == 'active'){ echo 'selected'; } ?>>Active</option>
                        <option value="inactive" <?php if($firmStatus == 'inactive'){ echo 'selected'; } ?>>Inactive</option>
                        <option value="warning" <?php if($firmStatus == 'warning'){ echo 'selected'; } ?>>Warning</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                <label for="userStatus">Group of products</label>
                    <select class="form-control" id="feature_group_for_item" name="feature_group_for_item">
                        <option value="yes" <?php if($feature_group_for_item == 'yes'){ echo 'selected'; } ?>>Yes</option>
                        <option value="no" <?php if($feature_group_for_item == 'no'){ echo 'selected'; } ?>>No</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Bonus % &nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" title="Bonus for vendor as per sell invoice"></i></label>
                    <input type="number" class="form-control" id="firmbonus" name="firmbonus" placeholder="Bonus %" value="<?php echo isset($firmbonus)? $firmbonus : ''; ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="userStatus">Capture Saved Amount</label>
                    <select class="form-control" id="feature_capture_saved_amount" name="feature_capture_saved_amount">
                        <option value="yes" <?php if($feature_capture_saved_amount == 'yes'){ echo 'selected'; } ?>>Yes</option>
                        <option value="no" <?php if($feature_capture_saved_amount == 'no'){ echo 'selected'; } ?>>No</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="userStatus">Invoice Format</label>
                    <select class="form-control" id="invoice_format" name="invoice_format">
                        <option value="standard" <?php if($invoice_format == 'standard'){ echo 'selected'; } ?>>Standard</option>
                        <option value="compact" <?php if($invoice_format == 'compact'){ echo 'selected'; } ?>>Compact</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="userStatus">Invoice Pdf Format</label>
                    <select class="form-control" id="invoice_pdf_format" name="invoice_pdf_format">
                        <option value="standard" <?php if($invoice_pdf_format == 'standard'){ echo 'selected'; } ?>>Standard</option>
                        <option value="compact" <?php if($invoice_pdf_format == 'compact'){ echo 'selected'; } ?>>Compact</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="userStatus">Bill Include Tax</label>
                    <select class="form-control" id="billIncludeTax" name="billIncludeTax">
                        <option value="yes" <?php if($billIncludeTax == 'yes'){ echo 'selected'; } ?>>Yes</option>
                        <option value="no" <?php if($billIncludeTax == 'no'){ echo 'selected'; } ?>>No</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">CGST Rate (%) &nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" title="Bonus for vendor as per sell invoice"></i></label>
                    <input type="text" class="form-control" id="cgstrate" name="cgstrate" placeholder="CGST Rate (%)" value="<?php echo isset($cgstrate)? ( ($cgstrate > 0) ? $cgstrate : '' ) : ''; ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">SGST / UTGST Rate (%) &nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" title="Bonus for vendor as per sell invoice"></i></label>
                    <input type="text" class="form-control" id="sgstrate" name="sgstrate" placeholder="SGST / UTGST Rate (%)" value="<?php echo isset($sgstrate)? ( ($sgstrate > 0) ? $sgstrate : '' ) : ''; ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">IGST Rate (%) &nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" title="Bonus for vendor as per sell invoice"></i></label>
                    <input type="text" class="form-control" id="igstrate" name="igstrate" placeholder="IGST Rate (%)" value="<?php echo isset($igstrate)? ( ($igstrate > 0) ? $igstrate : '' ) : ''; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Update Firm</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>