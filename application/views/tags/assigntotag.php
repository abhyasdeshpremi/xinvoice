<?php 
    foreach($data as $value){ 
        $uniqueCode = $value->tag_code;
        $tagName =  $value->tag_name;
        $tagColor =  $value->tag_color;
        $description = $value->description; 
    }
?>
<input type="hidden" id="defaultproductgroup" name="defaultproductgroup" value="<?php echo $uniqueCode; ?>" />
<div class="card">
    <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <button class="btn btn-link collapsed" style="color:<?php echo $tagColor; ?>" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
                    Assign tag(#<?php echo $tagName; ?>) to Items or other
                    </button>
                </div>
                <div class="col-md-3 mb-3">
                </div>
                <div class="col-md-3 mb-3"> 
                </div>
                <div class="col-md-2 mb-3">
                    <button type="button" onclick="" class="btn btn-warning add-item-button" data-toggle="modal" data-target="#addItemInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
                        Select Product
                    </button>
                </div>
            </div>
        </h5>
    </div>

    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
            <!--- invoice table item--->
            <div class="row" id="tagitemlist"> 
                
            </div>
            <!----invoice table item-->
        </div>
    </div>

</div>




<!----Add item modal Start----->
<div class="modal fade" id="addItemInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="forceclosegolobal">
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
                <input type="text" class="form-control" aria-label="Text input with dropdown button" id="itemdescription" name="itemdescription" value="" readonly>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-warning" id="add_tag_to_assignproduct">Assign tag</button>
      </div>
    </div>
  </div>
</div>
<script>

    var globaltagcode = "<?php echo $uniqueCode; ?>";
    var tagColor = "<?php echo $tagColor; ?>";
    var tagName = "<?php echo $tagName; ?>";
    var assignedItemData = <?php echo json_encode($assigneditemsList); ?>;
    console.log(assignedItemData);
    $(document).ready(function(){
        $('.select-dropdown-item').click(function(){
            var itemCode = $(this).attr("hreflang");
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
                    // invoiceCalculation();
                    // alert(data[0].name);
                }
            });
        });

        $('#add_tag_to_assignproduct').click(function(){
            var item_code = $("#selectitemcode").val();
            var item_name = $("#itemdescription").val();
            console.log(item_code + " product " + globaltagcode);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/assigntagtoproduct'); ?>',
                dataType  : 'json',
                data: {itemcode: item_code, globaltagcode: globaltagcode, tagName: tagName, item_name: item_name, tagColor: tagColor },
                error: function() {
                    console.log(arguments);
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Something went wrong");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                },
                success: function (data) {
                    if(data.code){
                            console.log(data.previewData);
                            assignedItemData.push(data.previewData);
                            addTagitem();
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

        function addTagitem(){
            $('#tagitemlist').empty();
            for(i=0;i<assignedItemData.length; i++) {
                $('#tagitemlist').append(addproductrow(assignedItemData[i], (i + 1) ));
            }
        }
        

        function addproductrow(oneRow, numberOne){
            return '<div id="'+oneRow["tags_assign_id"]+'" class="badge  badge-pill pl-4 p-0 m-2" style="background-color:'+oneRow['tag_color']+'; color:#FFF;">'+oneRow['itemname']
            +'<button type="button" onclick="deleteInvoiceItem('+oneRow["tags_assign_id"]+')" class="btn btn-datatable btn-icon deleteItemlistkjsdksdj" ></button>'
            +'</div>'
        }
        $('#forceclose, #forceclosegolobal').click(function(){
            $("#selectitemcode").val('');
                    $("#itemdescription").val('');
        }); 

        $("#myDropdown").attrchange({
            trackValues: true,
            callback: function(evnt) {
                if(evnt.attributeName == "class") { 
                    console.log("input"+evnt.newValue.search(/show/i));
                    if(evnt.newValue.search(/show/i) == 14) { 
                        $('#myInput').focus(); 
                    }
                }
            }
        });

        addTagitem();
    });
</script>
<script>
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
                        var deleteIndex = -1;
                        for(j=0;j<assignedItemData.length; j++) {
                            var tags_assign_id = assignedItemData[j]["tags_assign_id"];
                            if (parseInt(assigneditemid) === parseInt(assigneditemid)) {
                                deleteIndex = j;
                            }
                        }
                        assignedItemData.splice(deleteIndex, 1);

                        var row = $('#'+assigneditemid);
                        row.addClass("bg-danger");
                        row.hide(2000, function(){
                            this.remove(); 
                            addTagitem();
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