<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createFirm').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createUser" action="" method="POST" id="createUser">

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
                    <label for="validationDefault03">Username <span class="requiredClass">*</span></label>
                    <input class="form-control" id="username" name="username" type="text" placeholder="Username" value="<?php echo isset($username)? $username : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Email <span class="requiredClass">*</span></label>
                    <input class="form-control" id="email" name="email" type="email" placeholder="Email" value="<?php echo isset($email)? $email : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="mobile" name="mobile" type="text" placeholder="Mobile" value="<?php echo isset($mobile)? $mobile : ''; ?>" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Password <span class="requiredClass">*</span></label>
                    <input class="form-control" id="password" name="password" type="password" placeholder="Password" value="<?php echo isset($password)? $password : ''; ?>" required/>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="UserRole">Role</label>
                        <select class="form-control" id="userRole" name="userRole">
                            <option value="admin">Admin</option>
                            <option value="coordinator">Coordinator</option>
                            <option value="watcher">Watcher</option>
                        </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="userStatus">Status</label>
                        <select class="form-control" id="userStatus" name="userStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                </div>
            </div>

            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Create User</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#username").keyup(function(){
                var code_without_space = $("#username").val().replace(/ /g, "");
                var codename_without_special_char = code_without_space.replace(/[^a-zA-Z 0-9]+/g, "");
                $("#username").val(codename_without_special_char);
        });
        $('#username').keypress(function(e) {
            if ($(this).val().length >= 20) {
                return false;
            }
            return true;
        });
    });
</script>