<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->username; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->username; ?></td>
                        <td><?php echo $value->first_name. " ". $value->last_name; ?></td>
                        <td><?php echo $value->mobile_number; ?></td>
                        <td><?php echo $value->email; ?></td>
                        <td><?php echo $value->role; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updateuser/$value->username")?>"><button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="arrow-right"></i></button></a>
                            <button type="button" onclick='deleteUser("<?php echo $value->username;?>")' class="btn btn-datatable btn-icon btn-transparent-dark" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div><center><?php echo $links; ?></center></div>
    </div>
</div>

<script>
    function deleteUser(userName) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deleteuser'); ?>',
                data: {userName: userName},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        // $('#'+itemCode).remove();
                        var row = $('#'+userName);
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
 