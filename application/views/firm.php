<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(count($data) == 1) {
    $datalist = $data[0];
?>
<div class="form-group">
    <label for="exampleInputEmail1">Firm Code</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->code; ?>" readonly>
</div>

<div class="form-group">
    <label for="exampleFormControlTextarea1">Desciption</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly><?php echo $datalist->code; ?></textarea>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Address</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->address; ?>" readonly>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">District</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->district; ?>" readonly>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">State</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->state; ?>" readonly>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Pin Code</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->pin_code; ?>" readonly>
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Mobile</label>
    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Firm Code" value="<?php echo $datalist->mobile_number; ?>" readonly>
</div>

<?php } ?>