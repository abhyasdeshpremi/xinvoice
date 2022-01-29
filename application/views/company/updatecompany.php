<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createCompany').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <?php 
            foreach($data as $value){ 
                $uniqueCode = $value->company_code;
                $companyName =  $value->name;
                $description = $value->description; 
            }
        ?>
        <form class="updateCompany" action="" method="POST" id="updateCompany">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Company Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required readonly/>
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
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Update Company</button>
        </form>
    </div>
</div>
