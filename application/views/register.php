<style>
    .requiredClass{
        color: red;
    }
</style>
<div class="row" style="background-color: white; border-radius: 10px;">
    <div class="col-lg-12">
        <h2 class="font-weight-light my-4">Register</h2>
    </div>
    <div class="col-lg-12"> 
        <!-- <form method="POST" > -->
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">First Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="First Name" value="" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Last Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Last Name" value="" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Username <span class="requiredClass">*</span><span id="useralertmessage"></span></label>
                    <input class="form-control" id="username" name="username" type="text" placeholder="Enter Username" value="" maxlength="20" minlength="6" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Password</label>
                    <input class="form-control" id="password" name="password" type="password" placeholder="Enter Password" value="" maxlength="20" minlength="8" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Firm Unique Code <span class="requiredClass">*</span><span id="uniquealertmessage"></span></label>
                    <input class="form-control" id="firmuniquecode" name="firmuniquecode" type="text" placeholder="Firm Unique Code" style="text-transform:uppercase" value="" maxlength="20" minlength="6" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Firm Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firmName" name="firmName" type="text" placeholder="Firm Name" value="" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="firmMobile" name="firmMobile" type="number" placeholder="Contact Number" value="" maxlength="13" minlength="10" required/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Email <span class="requiredClass">*</span><span id="firmemailalertmessage"></span></label>
                    <input class="form-control" id="firmEmail" name="firmEmail" type="email" placeholder="Email" value="" required/>
                </div>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1">Address <span class="requiredClass">*</span></label>
                <input class="form-control" id="firmAddress" name="firmAddress" type="text" placeholder="Address" value="" required/>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Area</label>
                    <input class="form-control uppercase" id="firmArea" name="firmArea" type="text" placeholder="Area" value="" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">City</label>
                    <input class="form-control uppercase" id="firmCity" name="firmCity" type="text" placeholder="City" value="" />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">District <span class="requiredClass">*</span></label>
                    <input type="text" class="form-control uppercase" id="firmdistrict" name="firmdistrict" style="text-transform:uppercase" placeholder="District" value="" required/>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">State <span class="requiredClass">*</span></label>
                    <input type="text" class="form-control uppercase" id="firmState" name="firmState" placeholder="State" value="" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Zip <span class="requiredClass">*</span></label>
                    <input type="number" class="form-control" id="firmZip" name="firmZip" placeholder="Zip" value="" required>
                </div>
            </div>
                <button class="btn btn-warning mr-2 my-1" id="register_button" type="button">Registor</button>
                <div class="small"><a href="<?php echo base_url('/login'); ?>">Have an account? Sign in!</a></div>
        <!-- </form> -->
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#firmuniquecode").keyup(function(){
                var code_without_space = $("#firmuniquecode").val().replace(/ /g, "");
                var codename_without_special_char = code_without_space.replace(/[^a-zA-Z 0-9]+/g, "");
                $("#firmuniquecode").val(codename_without_special_char);
        });
        $('#firmuniquecode').keypress(function(e) {
            if ($(this).val().length >= 20) {
                return false;
            }
            return true;
        });

        $("#firmuniquecode").focusout(function(){
            var firmuniquecode = $('#firmuniquecode').val();
            $('#uniquealertmessage').text('');
            $('#uniquealertmessage').removeClass('requiredClass');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/checkfirmuniquecode'); ?>',
                dataType  : 'json',
                data: {firmuniquecode: firmuniquecode },
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    console.log(data);
                    if (data.flag){
                        $('#uniquealertmessage').text("Please select other unique code");
                        $('#uniquealertmessage').addClass('requiredClass');
                    }
                }
            });
        });

        $("#firmEmail").focusout(function(){
            var firmEmail = $('#firmEmail').val();
            $('#firmemailalertmessage').text('');
            $('#firmemailalertmessage').removeClass('requiredClass');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/checkuseremail'); ?>',
                dataType  : 'json',
                data: {firmEmail: firmEmail },
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    console.log(data);
                    if (data.flag){
                        $('#firmemailalertmessage').text("Please select other email id");
                        $('#firmemailalertmessage').addClass('requiredClass');
                    }
                }
            });
        });

        $("#username").focusout(function(){
            var username = $('#username').val();
            $('#useralertmessage').text('');
            $('#useralertmessage').removeClass('requiredClass');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/checkusername'); ?>',
                dataType  : 'json',
                data: {username: username },
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    console.log(data);
                    if (data.flag){
                        $('#useralertmessage').text("Please select other username");
                        $('#useralertmessage').addClass('requiredClass');
                    }
                }
            });
        });

        $("#firstname, #lastname, #username, #password, #firmuniquecode, #firmName, #firmMobile, #firmEmail, #firmAddress, #firmdistrict, #firmState, #firmZip").focusout(function(){
            $("#firstname, #lastname, #username, #password, #firmuniquecode, #firmName, #firmMobile, #firmEmail, #firmAddress, #firmdistrict, #firmState, #firmZip").removeClass("borderRed");
        });

        $('#register_button').click(function(e){

            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var firmuniquecode = $("#firmuniquecode").val();
            var firmName = $("#firmName").val();
            var firmMobile = $("#firmMobile").val();
            var firmEmail = $("#firmEmail").val();

            var firmAddress = $("#firmAddress").val();
            var firmArea = $("#firmArea").val();
            var firmCity = $("#firmCity").val();
            var firmdistrict = $("#firmdistrict").val();
            var firmState = $("#firmState").val();
            var firmZip = $("#firmZip").val();
            $("#firstname, #lastname, #username, #password, #firmuniquecode, #firmName, #firmMobile, #firmEmail, #firmAddress, #firmdistrict, #firmState, #firmZip").removeClass("borderRed");

            if(firstname.length < 3){
                $("#firstname").addClass("borderRed");
                alert("Please Enter First Name.");
            }else if(lastname.length < 3){
                $("#lastname").addClass("borderRed");
                alert("Please Enter Last Name.");
            }else if(username.length < 3){
                $("#username").addClass("borderRed");
                alert("Please Enter Username.");
            }else if(password.length < 3){
                $("#password").addClass("borderRed");
                alert("Please Enter Password.");
            }else if(firmuniquecode.length < 3){
                $("#firmuniquecode").addClass("borderRed");
                alert("Please Enter Firm short name.");
            }else if(firmName.length < 3){
                $("#firmName").addClass("borderRed");
                alert("Please Enter Firm/Company Name.");
            }else if(firmMobile.length < 3){
                $("#firmMobile").addClass("borderRed");
                alert("Please Enter Mobile number.");
            }else if(firmEmail.length < 3){
                $("#firmEmail").addClass("borderRed");
                alert("Please Enter Email.");
            }else if(firmAddress.length < 3){
                $("#firmAddress").addClass("borderRed");
                alert("Please Enter Firm/Company address.");
            }else if(firmdistrict.length < 3){
                $("#firmdistrict").addClass("borderRed");
                alert("Please Enter District.");
            }else if(firmState.length < 3){
                $("#firmState").addClass("borderRed");
                alert("Please Enter State.");
            }else if(firmZip.length < 3){
                $("#firmZip").addClass("borderRed");
                alert("Please Enter Zip code.");
            }else{
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/registeruser'); ?>',
                    dataType  : 'json',
                    data: {firstname: firstname, lastname: lastname, username: username, password: password,
                        firmuniquecode: firmuniquecode, firmName: firmName, firmMobile: firmMobile,
                        firmEmail: firmEmail, firmAddress: firmAddress, firmArea: firmArea, firmCity: firmCity,
                        firmdistrict: firmdistrict, firmState: firmState, firmZip: firmZip},
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.userinsertFlag){
                            $('#useralertmessage').text("Please select other username");
                            $('#useralertmessage').addClass('requiredClass');
                        }
                    }
                });

            }
            // e.preventDefault();
        });

    });
</script>