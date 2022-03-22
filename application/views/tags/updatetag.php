<div class="row">
    <div class="col-lg-12">
        <?php if(isset($successMessage)){ ?>
            <script>document.getElementById('updateTag').reset();</script>
            <div class="alert alert-success" role="alert"><?php echo isset($successMessage)? $successMessage : ''; ?></div>
        <?php }elseif(isset($errorMessage)){ ?>
            <div class="alert alert-danger" role="alert"><?php echo isset($errorMessage)? $errorMessage : ''; ?></div>
        <?php } ?>
        <?php 
            foreach($data as $value){ 
                $uniqueCode = $value->tag_code;
                $tagName =  $value->tag_name;
                $tagColor =  $value->tag_color;
                $description = $value->description; 
            }
        ?>
        <form class="updateTag" action="" method="POST" id="updateTag">
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="validationDefault03">Unique Code <span class="requiredClass">*</span></label>
                    <input class="form-control" id="uniqueCode" name="uniqueCode" type="text" placeholder="Tag Code" style="text-transform:uppercase" value="<?php echo isset($uniqueCode)? $uniqueCode : ''; ?>" required readonly/>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">Tag Name <span class="requiredClass">*</span></label>
                    <input class="form-control" id="tagName" name="tagName" type="text" placeholder="Tag Name" value="<?php echo isset($tagName)? $tagName : ''; ?>" required/>
                </div>
                <div class="col-md-1 mb-3">
                    <label for="validationDefault03">Color<span class="requiredClass">*</span></label>
                    <input class="form-control" id="tagColor" name="tagColor" type="color" value="<?php echo isset($tagColor)? $tagColor : ''; ?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Tag Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($description)? $description : ''; ?></textarea>
            </div>
            <button type="submit" class="btn btn-warning mr-2 my-1" type="button">Update Tag</button>
        </form>
    </div>
</div>
