<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('termconditions').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
            <?php 
                foreach($data as $value){ 
                    $title = $value->tc_title;
                    $line1 =  $value->line1;
                    $line2 = $value->line2;
                    $line3 = $value->line3;
                    $line4 = $value->line4;
                }
            ?>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Title</label>
                    <input class="form-control" id="title" name="title" type="text" placeholder="Enter title of term & condition" style="text-transform:uppercase" value="<?php echo isset($title)? $title : ''; ?>" />
                </div>
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Line 1 </label>
                    <input class="form-control" id="line1" name="line1" type="text" placeholder="Line 1" style="text-transform:uppercase" value="<?php echo isset($line1)? $line1 : ''; ?>" />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Line 2 </label>
                    <input class="form-control" id="line2" name="line2" type="text" placeholder="Line 2" style="text-transform:uppercase" value="<?php echo isset($line2)? $line2 : ''; ?>" />
                </div>
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Line 3 </label>
                    <input class="form-control" id="line3" name="line3" type="text" placeholder="Line 3" style="text-transform:uppercase" value="<?php echo isset($line3)? $line3 : ''; ?>" />
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationDefault03">Line 4</label>
                    <input class="form-control" id="line4" name="line4" type="text" placeholder="Line 4" style="text-transform:uppercase" value="<?php echo isset($line4)? $line4 : ''; ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" id="savetermcondition" type="button">Save</button>
    </div>
</div>
<script>
    $(document).ready(function(){ 
        $('#title, #line1, #line2, #line3, #line4').keypress(function(e) {
            if ($(this).val().length >= 80) {
                return false;
            }
            return true;
        });

        //form header value check
        $('#savetermcondition').click(function(){
            var title = $("#title").val();
            var line1 = $('#line1').val();
            var line2 = $('#line2').val();
            var line3 = $('#line3').val();
            var line4 = $('#line4').val();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/savetermconditions'); ?>',
                dataType  : 'json',
                data: { title: title, line1:  line1, line2: line2, line3:  line3, line4: line4},
                error: function(data) {
                    console.log(data);
                },
                success: function (data) {
                    alert(data.message);
                }
            });
        });

    });
</script>