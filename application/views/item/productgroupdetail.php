<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Product Group Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Product Group Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->pk_gfi_unique_code; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->pk_gfi_unique_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updateproductgroup/$value->pk_gfi_unique_code")?>"><button class="btn btn-datatable btn-icon mr-2"><i data-feather="edit"></i></button></a>
                            <button type="button" onclick='deleteproductgroup("<?php echo $value->pk_gfi_unique_code;?>")' class="btn btn-datatable btn-icon" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                            <a  href="<?php echo base_url("/addproducttoproductgroup/$value->pk_gfi_unique_code")?>"><button class="btn btn-datatable btn-icon mr-2"><i data-feather="arrow-right"></i></button></a>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
<script>
    function deleteproductgroup(productgroupCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteproductgroup'); ?>',
                data: {productgroupCode: productgroupCode},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var row = $('#'+productgroupCode);
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
</script>