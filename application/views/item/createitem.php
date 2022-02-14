<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createItem" action="" method="POST" id="createItem">
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueItemCode" name="uniqueItemCode" type="text" placeholder="Product Code" style="text-transform:uppercase" value="<?php echo isset($uniqueItemCode)? $uniqueItemCode : ''; ?>" required/>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="validationDefault03">Product Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="itemName" name="itemName" type="text" placeholder="Product Name" value="<?php echo isset($itemName)? $itemName : ''; ?>" required/>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="validationDefault03">Product Desciption</label>
                    <input class="form-control" id="itemsubdescription" name="itemsubdescription" type="text" placeholder="Product Sub Name" value="<?php echo isset($itemsubdescription)? $itemsubdescription : ''; ?>" />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="itemCompanyCode">Product's company <a  href="<?php echo base_url('/createcompany'); ?>">Add New Company</a></label>
                        <select class="form-control" id="itemCompanyCode" name="itemCompanyCode">
                            <?php $count = 0; 
                            foreach($companiesList as $company){ ?>
                                <option value="<?php echo $company->company_code;?>" ><?php echo $company->name;?></option>
                            <?php $count++; } ?>
                        </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Weight in litter</label>
                    <input class="form-control" id="weightinlitter" name="weightinlitter" type="number" placeholder="Weight in litter" value="<?php echo isset($weightinlitter)? $weightinlitter : ''; ?>" min="0" max="100000" step="any" />
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Unit/Case</label>
                    <input type="number" class="form-control" id="itemunitcase" name="itemunitcase" placeholder="Unit/Case" value="<?php echo isset($itemunitcase)? $itemunitcase : ''; ?>" min="0" max="100000" step="any" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">MRP</label>
                    <input type="number" class="form-control" id="itemmrp" name="itemmrp" placeholder="MRP" value="<?php echo isset($itemmrp)? $itemmrp : ''; ?>" min="0" max="100000" step="any" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Cost Price</label>
                    <input type="number" class="form-control" id="itemcostprice" name="itemcostprice" placeholder="Cost Price" value="<?php echo isset($itemcostprice)? $itemcostprice : ''; ?>" min="0" max="100000" step="any" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Op. Balance in Quantity</label>
                    <input type="number" class="form-control" id="itemopbalanceinquantity" name="itemopbalanceinquantity" placeholder="Op. Balance in Quantity" value="<?php echo isset($itemopbalanceinquantity)? $itemopbalanceinquantity : ''; ?>" min="0" max="100000" step="any" />
                </div>
            </div>

            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Create Product</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#uniqueItemCode").keyup(function(){
                var code_without_space = $("#uniqueItemCode").val().replace(/ /g, "");
                var codename_without_special_char = code_without_space.replace(/[^a-zA-Z 0-9]+/g, "");
                $("#uniqueItemCode").val(codename_without_special_char);
        });
        $('#uniqueItemCode').keypress(function(e) {
            if ($(this).val().length >= 20) {
                return false;
            }
            return true;
        });
    });
</script>