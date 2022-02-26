<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createClient').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <?php 
            foreach($data as $value){ 
                $account_code = $value->account_code;
                $account_name =  $value->account_name;
                $contact_number = $value->contact_number;
                $email = $value->email;
                $address = $value->address;
            }
        ?>
        <form class="createAccountHolder" action="" method="POST" id="createAccountHolder">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Unique Account Holder Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Account Holder Code" style="text-transform:uppercase" value="<?php echo isset($account_code)? $account_code : ''; ?>" required/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Account Holder Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientName" name="clientName" type="text" placeholder="Account Holder Name" value="<?php echo isset($account_name)? $account_name : ''; ?>" required/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientMobile" name="clientMobile" type="text" placeholder="Mobile" value="<?php echo isset($contact_number)? $contact_number : ''; ?>" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Email</label>
                    <input class="form-control" id="accontemail" name="accontemail" type="text" placeholder="Email" value="<?php echo isset($email)? $email : ''; ?>" />
                </div>
                <div class="col-md-8 mb-3">
                    <label for="exampleFormControlInput1">Address</label>
                    <input class="form-control" id="clientAddress" name="clientAddress" type="text" placeholder="Address" value="<?php echo isset($address)? $address : ''; ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Update Account Holder</button>
        </form>
    </div>
</div>
