<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createCompany').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createCompany" action="" method="POST" id="createCompany">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Company Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Company Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="companyName" name="companyName" type="text" placeholder="Company Name" value="<?php echo isset($companyName)? $companyName : ''; ?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Company Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($description)? $description : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Create Company</button>
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