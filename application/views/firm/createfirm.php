<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createFirm" action="" method="POST" id="createFirm">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Firm Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
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
            <button type="submit" class="btn btn-primary mr-2 my-1" type="button">Create Firm</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#uniqueCode").keyup(function(){
                var code_without_space = $("#uniqueCode").val().replace(/ /g, "");
                var codename_without_special_char = code_without_space.replace(/[^a-zA-Z 0-9]+/g, "");
                $("#uniqueCode").val(codename_without_special_char);
        });
        $('#uniqueCode').keypress(function(e) {
            if ($(this).val().length >= 20) {
                return false;
            }
            return true;
        });
    });
</script>