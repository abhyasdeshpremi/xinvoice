<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createAccountHolder').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createAccountHolder" action="" method="POST" id="createAccountHolder">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Unique Account Holder Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Account Holder Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Client Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientName" name="clientName" type="text" placeholder="Account Holder Name" value="<?php echo isset($clientName)? $clientName : ''; ?>" required/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientMobile" name="clientMobile" type="text" placeholder="Mobile" value="<?php echo isset($clientMobile)? $clientMobile : ''; ?>" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Email</label>
                    <input class="form-control" id="accontemail" name="accontemail" type="text" placeholder="Email" value="<?php echo isset($clientgst)? $clientgst : ''; ?>" />
                </div>
                <div class="col-md-8 mb-3">
                    <label for="exampleFormControlInput1">Address</label>
                    <input class="form-control" id="clientAddress" name="clientAddress" type="text" placeholder="Address" value="<?php echo isset($clientAddress)? $clientAddress : ''; ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Create Account Holder</button>
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