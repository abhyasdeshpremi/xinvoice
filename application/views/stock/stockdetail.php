<div class="row">
    <div class="col-md-9 mb-3">
    </div>
    <div class="col-md-1 mb-3">
        <button type="button" class="btn btn-primary" id="hardRefresh"> <i data-feather="refresh-cw"></i></button>
    </div>
    <div class="col-md-2 mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
            Stock Adjustment
        </button>
    </div>
</div>
<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->item_code; ?></td>
                        <td><?php echo $value->item_name; ?></td>
                        <td><?php echo $value->item_total_count; ?></td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div><center><?php echo $links; ?></center></div>
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
                    <div class="dropdown-menu">
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
        <button type="button" class="btn btn-primary" id="add_number_of_item_to_stock">Add Stock</button>
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

    });
</script>