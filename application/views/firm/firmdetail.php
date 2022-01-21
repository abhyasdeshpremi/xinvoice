<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Firm Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Firm Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->firm_code; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->firm_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->mobile_number; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updatefirm/$value->firm_code")?>"><button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="arrow-right"></i></button></a>
                            <button type="button" onclick='deleteFirm("<?php echo $value->firm_code;?>")' class="btn btn-datatable btn-icon btn-transparent-dark" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
<script>
    function deleteFirm(firmCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deletefirm'); ?>',
                data: {firmCode: firmCode},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var row = $('#'+firmCode);
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