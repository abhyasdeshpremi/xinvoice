<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('createClient').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>

        <form class="createClient" action="" method="POST" id="createClient">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Client Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required/>
                </div>
                <div class="col-md-8 mb-3">
                    <label for="validationDefault03">Client Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientName" name="clientName" type="text" placeholder="Client Name" value="<?php echo isset($clientName)? $clientName : ''; ?>" required/>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="userStatus">Client Type</label>
                        <select class="form-control" id="clienttype" name="clienttype" style="text-transform: capitalize;">
                            <?php $count = 0; 
                            foreach($roleTypes as $roleType){ ?>
                                <option value="<?php echo $roleType;?>" <?php if(isset($clienttype)){ if($clienttype == $roleType){ echo "selected"; }}?>><?php echo $roleType;?></option>
                            <?php $count++; } ?>
                        </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Mobile <span class="requiredClass">*</span></label>
                    <input class="form-control" id="clientMobile" name="clientMobile" type="text" placeholder="Client Mobile" value="<?php echo isset($clientMobile)? $clientMobile : ''; ?>" required/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">GST IN</label>
                    <input class="form-control" id="clientgst" name="clientgst" type="text" placeholder="Client GST" value="<?php echo isset($clientgst)? $clientgst : ''; ?>" />
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Pan Number</label>
                    <input class="form-control" id="clientPan" name="clientPan" type="text" placeholder="Pan Number" value="<?php echo isset($clientPan)? $clientPan : ''; ?>"/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Aadhar Number</label>
                    <input class="form-control" id="clientaadhar" name="clientaadhar" type="text" placeholder="Aadhar Number" value="<?php echo isset($clientaadhar)? $clientaadhar : ''; ?>" />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">FSSAI Number</label>
                    <input class="form-control" id="clientfssai" name="clientfssai" type="text" placeholder="FSSAI Number" value="<?php echo isset($clientfssai)? $clientfssai : ''; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1">Address</label>
                <input class="form-control" id="clientAddress" name="clientAddress" type="text" placeholder="Address" value="<?php echo isset($clientAddress)? $clientAddress : ''; ?>" />
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Area</label>
                    <input class="form-control uppercase" id="clientArea" name="clientArea" type="text" placeholder="Area" value="<?php echo isset($clientArea)? $clientArea : ''; ?>" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">City</label>
                    <input class="form-control uppercase" id="clientCity" name="clientCity" type="text" placeholder="City" value="<?php echo isset($clientCity)? $clientCity : ''; ?>" />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">District</label>
                    <input type="text" class="form-control uppercase" id="clientdistrict" name="clientdistrict" placeholder="District" value="<?php echo isset($clientdistrict)? $clientdistrict : ''; ?>" />
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault04">State</label>
                    <input type="text" class="form-control uppercase" id="clientState" name="clientState" placeholder="State" value="<?php echo isset($clientState)? $clientState : ''; ?>" >
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Zip</label>
                    <input type="number" class="form-control" id="clientZip" name="clientZip" placeholder="Zip" value="<?php echo isset($clientZip)? $clientZip : ''; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2 my-1" type="button">Create Client</button>
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