<div class="row justify-content-center">
    <div class="col-lg-5">
        <!-- Basic login form-->
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">Login</h3></div>
            <div class="card-body">
                <!-- Login form-->
                <form class="user" action="" method="POST" id="login">
                    <!-- Form Group (email address)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                        <!-- <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter email address" /> -->
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                                    placeholder="Enter Email Address..." value="<?php echo isset($email)? $email : ''; ?>" required>
                    </div>
                    <!-- Form Group (password)-->
                    <div class="form-group">
                        <label class="small mb-1" for="inputPassword">Password</label>
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                    </div>
                   <!-- Form Group (remember password checkbox)-->
                   <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="remember_me" name="remember_me" type="checkbox" />
                            <label class="custom-control-label" for="remember_me">Remember password</label>
                        </div>
                    </div>
                    <!-- Form Group (login box)-->
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="auth-password-basic.html">Forgot Password?</a>
                        <!-- <a class="btn btn-primary" href="index.html">Login</a> -->
                        <button type="submit" class="btn btn-warning" value="Login">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>
            </div>
        </div>
    </div>
</div>