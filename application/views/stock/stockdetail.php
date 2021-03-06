<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Box</th>
                    <th>Total Stock  <span class="hideshowperitem"><i class="fas fa-eye"></i></span></th>
                    <th>Amount(₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php $viewTotalStockValue = 0.0;
                foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value['item_code']; ?></td>
                        <td><?php echo $value['item_name']; ?></td>
                        <td>
                            <?php foreach($itemstag as $tmpvalue){ 
                                $itemcode = $tmpvalue->assign_tag_to_code; 
                                if($itemcode == $value['item_code']){                                
                                    ?>
                            <div id=<?php echo $tmpvalue->tags_assign_id; ?> class="badge  badge-pill pl-4 p-0" style="background-color:<?php echo $tmpvalue->tag_color; ?>; color:#FFF;">
                                <?php echo $tmpvalue->tag_name;?>
                                <button type="button" onclick="deleteInvoiceItem(<?php echo $tmpvalue->tags_assign_id; ?>)" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
                            </div>
                            <?php } } ?>
                        </td>
                        <td>
                            <?php
                                $item_total_count = $value['item_total_count'];
                                $classname = '';
                                if ($item_total_count > 0) {
                                    $classname = 'class="greentext"';
                                }else{
                                    $classname = 'class="redtext"';
                                }
                            ?>
                            <a <?php echo $classname; ?> href="<?php echo base_url('/getitemstocklog'.'/'.$value['item_code']); ?>">
                                <?php $viewTotalStockValue = $viewTotalStockValue + (float)str_replace(',', '', $value['bill_total_bill_value']);
                                echo $value['item_total_count']; ?> 
                                <span class="bill_per_item_value"> x <?php echo $value['bill_per_item_value']; ?></span>
                            </a>
                        </td>
                        <td><?php echo $value['bill_total_bill_value']; ?></td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Box</th>
                    <th>Total Stock  <span class="hideshowperitem"><i class="fas fa-eye"></i></span></th>
                    <th>Amount(₹)</th>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><b>Total(₹)</b></td>
                    <td><b><?php echo number_format($viewTotalStockValue, 2);?></b></td>
                </tr>
            </tfoot>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
&nbsp;
<div class="row">
    <div class="col-md-9 mb-3">
    </div>
    <div class="col-md-1 mb-3">
        <button type="button" class="btn btn-warning" id="hardRefresh"> <i data-feather="refresh-cw"></i></button>
    </div>
    <div class="col-md-2 mb-3">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
            Stock Adjustment
        </button>
    </div>
</div>


<!----Add item modal Start----->
<div class="modal fade" id="addItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalheader">
        <h5 class="modal-title" id="exampleModalLabel">Manually Stock Adjustment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Item</button>
                    <div id="myDropdown" class="dropdown-menu">
                        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" autocomplete="off">
                            <?php $count = 1; 
                                foreach($itemsList as $item){ ?>
                                    <a class="dropdown-item small select-dropdown-item" hreflang="<?php echo $item->item_code; ?>"><?php echo $item->name." <span style='font-size:50%;'>🍦 (".$item->item_code.") &copy; ".$item->company_code." ₹(".$item->mrp.")</span>";?></a>
                            <?php $count++; } ?>
                    </div>
                </div>
                <input type="hidden" class="form-control" aria-label="Text input with dropdown button" id="selectitemcode" name="selectitemcode" >
                <input type="text" class="form-control" aria-label="Text input with dropdown button" id="itemdescription" name="itemdescription" readonly>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Stock type</span>
                </div>
                <select class="form-control" id="stocktype" name="stocktype">
                    <option value="buy">Buy</option>
                    <option value="sell">Sell</option>
                </select>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Unit</span>
                </div>
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="stockunit" name="stockunit" value="" required>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Comment</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="stockcomment" name="stockcomment" value="" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-warning" id="add_number_of_item_to_stock">Add Stock</button>
      </div>
    </div>
  </div>
</div>

<!----Add Stock modal end----->

<script>
    
    $(document).ready(function(){

        $("#hardRefresh").click(function () {
            location.reload(true);
        });

        $('#modalheader').css("background-color", "green");
        $('#modalheader h5').css("color", "white");
        $("#stocktype").change(function(){
            var selectedstocktype = $(this).children("option:selected").val();
            if(selectedstocktype == 'buy'){
                $('#modalheader').css("background-color", "green");
            }else if(selectedstocktype == 'sell'){
                $('#modalheader').css("background-color", "red");
            }else{
                $('#modalheader').css("background-color", "green");
            }
        });



        $('.select-dropdown-item').click(function(){
            var itemCode = $(this).attr("hreflang");
            // alert("The paragraph was clicked."+itemCode);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/getitemcode'); ?>',
                dataType  : 'json',
                data: {itemcode: itemCode},
                error: function() {
                    alert('Something is wrong');
                },
                success: function (data) {
                    $('#selectitemcode').val(data[0].item_code);
                    $('#itemdescription').val(data[0].name); 
                }
            });
        });

        //Add stock 
        $('#add_number_of_item_to_stock').click(function(){
            
            var item_code = $("#selectitemcode").val();
            var item_name = $("#itemdescription").val();
            var stocktype = $("#stocktype").val();
            var stockunit = $("#stockunit").val();
            var stockcomment = $("#stockcomment").val();
            if(item_name.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please selecr item");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            if(stockunit.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add item unit");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            if(stockcomment.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add comment");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/savestock'); ?>',
                data: {item_code: item_code, item_name:item_name, stocktype:stocktype, stockunit:stockunit, stockcomment:stockcomment},
                error: function(request, error) {
                    console.log(arguments);
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Something went wrong");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        $("#selectitemcode").val('');
                        $("#itemdescription").val('');
                        $("#stocktype").val('');
                        $("#stockunit").val('');
                        $("#stockcomment").val('');
                        $("#successfullyMessage").addClass('alert-success');
                    }else{
                        $("#successfullyMessage").addClass('alert-danger');
                    }
                    $("#successfullyMessage").text(data.message);
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                }
            });
        });

        $("#addItemInput").on("hidden.bs.modal", function () {
            $("#selectitemcode").val('');
            $("#itemdescription").val('');
            $("#stocktype").val('');
            $("#stockunit").val('');
            $("#stockcomment").val('');
            $('#modalheader').css("background-color", "green");
        });

        $(".hideshowperitem").click(function () {
            $(".bill_per_item_value").toggle();
        });

        $(".bill_per_item_value").toggle();

        $('#globalsearchbutton').click(function(){
            var globalsearch = $('#globalsearch').val();
            if(globalsearch.length > 2){
                var link = '<?php echo $base_url; ?>';
                var url = link + "/" +globalsearch;
                location.replace(url);
            }
        });

        $('#globalclearhbutton').click(function(){
            var link = '<?php echo $base_url; ?>';
            location.replace(link);
        });

    });
</script>
<script>
    var input = document.getElementById("globalsearch");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("globalsearchbutton").click();
        }
    });
    
    function deleteInvoiceItem(assigneditemid) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteassignitem'); ?>',
                data: {assigneditemid: assigneditemid},
                error: function(request, error) {
                    console.log(arguments);
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.code){ 
                        var row = $('#'+assigneditemid);
                        row.addClass("bg-danger");
                        row.hide(2000, function(){
                            this.remove();
                        });
                    }else{
                        alert(data.message)
                    }
                }
            });
        }
    }
    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }

    function removefilterFunction() {
        var a; 
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            a[i].style.display = ""; 
        }
    }
</script>