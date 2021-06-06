<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Comany Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Comany Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->company_code; ?>">
                        <td><?php echo $value->company_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updatecompany/$value->company_code")?>"><button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="arrow-right"></i></button></a>
                            <button type="button" onclick='deleteCompany("<?php echo $value->company_code;?>")' class="btn btn-datatable btn-icon btn-transparent-dark" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function deleteCompany(companyCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deletecompany'); ?>',
                data: {companyCode: companyCode},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var row = $('#'+companyCode);
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