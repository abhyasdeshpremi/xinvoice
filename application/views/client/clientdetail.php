<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Client Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Client Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Client Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Client Type</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->code; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->mobile_no; ?></td>
                        <td><?php echo $value->address; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->client_type; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updateclient/$value->code")?>"><button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="arrow-right"></i></button></a>
                            <button type="button" onclick='deleteClient("<?php echo $value->code;?>")' class="btn btn-datatable btn-icon btn-transparent-dark" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
<script>
    function deleteClient(clientCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteclient'); ?>',
                data: {client_code: clientCode},
                error: function(request, error) {
                    console.log(arguments);
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var row = $('#'+clientCode);
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