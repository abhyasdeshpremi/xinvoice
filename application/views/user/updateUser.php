<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <!-- <script>document.getElementById('createFirm').reset();</script> -->
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <?php 
            foreach($data as $value){ 
                $firstName = $value->first_name;
                $lastName =  $value->last_name;
                $username = $value->username;
                $email = $value->email;
                $mobile = $value->mobile_number;
                $userRole = $value->role;
                $firm_code = $value->fk_firm_code;
                $userStatus = $value->status;
            }
        ?>
        <form class="updateUser" action="" method="POST" id="updateUser">

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Username <span class="requiredClass">*</span></label>
                    <input class="form-control" id="username" name="username" type="text" placeholder="Username" value="<?php echo isset($username)? $username : ''; ?>" required readonly/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Email <span class="requiredClass">*</span></label>
                    <input class="form-control" id="email" name="email" type="email" placeholder="Email" value="<?php echo isset($email)? $email : ''; ?>" required readonly/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="mobile" name="mobile" type="text" placeholder="Mobile" value="<?php echo isset($mobile)? $mobile : ''; ?>" required readonly/>
                </div>
                <div class="col-md-6 mb-3">
                    <?php if (isset($firmData)) { ?>
                        <label for="firmCode">Firm permission</label>
                        <select class="form-control" id="firmCode" name="firmCode">
                            <option value="">Select firm</option>
                            <?php foreach($firmData as $value){ ?>
                                <option value="<?php echo $value->firm_code; ?>" <?php if($value->firm_code == $firm_code){ echo 'selected'; } ?>><?php echo $value->name; ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">First Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firstName" name="firstName" type="text" placeholder="First Name" value="<?php echo isset($firstName)? $firstName : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Last Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="lastName" name="lastName" type="text" placeholder="Last Name" value="<?php echo isset($lastName)? $lastName : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="UserRole">Role</label>
                        <select class="form-control" id="userRole" name="userRole">
                            <option value="admin" <?php if($userRole == 'admin'){ echo 'selected'; } ?>>Admin</option>
                            <option value="coordinator" <?php if($userRole == 'coordinator'){ echo 'selected'; } ?>>Coordinator</option>
                            <option value="watcher" <?php if($userRole == 'watcher'){ echo 'selected'; } ?>>Watcher</option>
                        </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="userStatus">Status</label>
                        <select class="form-control" id="userStatus" name="userStatus">
                            <option value="active" <?php if($userStatus == 'active'){ echo 'selected'; } ?>>Active</option>
                            <option value="inactive" <?php if($userStatus == 'inactive'){ echo 'selected'; } ?>>Inactive</option>
                        </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2 my-1" type="button">Update User</button>
        </form>
    </div>
</div>
