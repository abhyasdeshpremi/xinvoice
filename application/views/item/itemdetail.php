<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Company Code</th>
                    <th>Weight(ml)</th>
                    <th>Unit/Case</th>
                    <th>MRP(&#8377;)</th>
                    <th>Cost(&#8377;)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Company Code</th>
                    <th>Weight</th>
                    <th>Unit/Case</th>
                    <th>MRP(&#8377;)</th>
                    <th>Cost(&#8377;)</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php 
                    foreach($data as $value){ ?>
                    <tr id="<?php echo $value->item_code; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->item_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->company_code; ?></td>
                        <td><?php echo (((Int)$value->weight_in_ltr) * 1000); ?></td>
                        <td><?php echo $value->unit_case; ?></td>
                        <td><?php echo $value->mrp; ?></td>
                        <td><?php echo $value->cost_price; ?></td>
                        <td>
                            <a  href="<?php echo base_url("/updateitem/$value->item_code")?>"><button class="btn btn-datatable btn-icon mr-2"><i data-feather="arrow-right"></i></button></a>
                            <button type="button" onclick='deleteItem("<?php echo $value->item_code;?>")' class="btn btn-datatable btn-icon" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php $page = $page + 1; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>

<script>
    function deleteItem(itemCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteitem'); ?>',
                data: {item_code: itemCode},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        // $('#'+itemCode).remove();
                        var row = $('#'+itemCode);
                        row.addClass("bg-danger");
                        row.hide(2000, function(){
                            this.remove(); 
                        });
                        // alert(data.message)
                    }else{
                        alert(data.message)
                    }
                }
            });
        }
    }
</script>
 