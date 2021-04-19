<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="purchaseinvoice" action="" method="POST" id="purchaseinvoice">

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Invoice Title <span class="requiredClass">*</span></label>
                    <input class="form-control" id="invoicetitle" name="invoicetitle" type="text" placeholder="Invoice Title" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Invoice Sub Title <span class="requiredClass">*</span></label>
                    <input class="form-control" id="invoicesubtitle" name="invoicesubtitle" type="text" placeholder="Invoice Sub Title" value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationDefault03">GST IN</label>
                    <input class="form-control" id="gstin" name="gstin" type="text" placeholder="GST IN" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault03">PAN No.</label>
                    <input class="form-control" id="panno" name="panno" type="text" placeholder="Pan No." value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Vehicle No.</label>
                    <input class="form-control" id="panno" name="panno" type="text" placeholder="Pan No." value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Payment mode</label>
                    <input class="form-control" id="panno" name="panno" type="text" placeholder="Pan No." value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="validationDefault03">Invoice Title <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueItemCode" name="uniqueItemCode" type="text" placeholder="Item Code" style="text-transform:uppercase" value="<?php echo isset($uniqueItemCode)? $uniqueItemCode : ''; ?>" required/>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="validationDefault03">Item Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="itemName" name="itemName" type="text" placeholder="Item Name" value="<?php echo isset($itemName)? $itemName : ''; ?>" required/>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="validationDefault03">Item Desciption</label>
                    <input class="form-control" id="itemsubdescription" name="itemsubdescription" type="text" placeholder="Item Sub Name" value="<?php echo isset($itemsubdescription)? $itemsubdescription : ''; ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2 my-1" type="button">Create Item</button>
        </form>
    </div>
</div>
