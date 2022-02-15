<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('changepassword').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="changepassword" action="" method="POST" id="changepassword">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Old Password <span class="requiredClass">*</span></label>
                    <input class="form-control" id="oldpassword" name="oldpassword" type="password" placeholder="Enter Old Password" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">New Password <span class="requiredClass">*</span></label>
                    <input class="form-control" id="newpassword" name="newpassword" type="password" placeholder="Enter New Password" value="<?php echo isset($firmName)? $firmName : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Re-Enter New Password <span class="requiredClass">*</span></label>
                    <input class="form-control" id="reenternewpassword" name="reenternewpassword" type="password" placeholder="Re-Enter New Password" value="<?php echo isset($firmMobile)? $firmMobile : ''; ?>" required/>
                </div> 
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Change password</button>
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