<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Tag Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th width="110px;">Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Tag Code</th>
                    <th>Name</th>
                    <th>Desciption</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr id="<?php echo $value->tag_code; ?>">
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->tag_code; ?></td>
                        <td><div class="badge badge-primary badge-pill" style="background-color:<?php echo $value->tag_color; ?>"><?php echo $value->tag_name; ?></div></td>
                        <td><?php echo $value->description; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <a  href="<?php echo base_url("/updatetag/$value->tag_code")?>"><button class="btn btn-datatable btn-icon mr-2"><i data-feather="edit"></i></button></a>
                            <button type="button" onclick='deleteTag("<?php echo $value->tag_code;?>")' class="btn btn-datatable btn-icon" id="deleteItemlistkjsdksdj" ><i data-feather="trash-2"></i></button>
                            <a  href="<?php echo base_url("/assigntotag/$value->tag_code")?>"><button class="btn btn-datatable btn-icon mr-2"><i data-feather="arrow-right"></i></button></a>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
<script>
    function deleteTag(tagCode) {
        if(confirm("Are you sure you want to delete this?")){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/deletetag'); ?>',
                data: {tagCode: tagCode},
                error: function(request, error) {
                    console.log(arguments);
                    
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if(data.code){
                        var row = $('#'+tagCode);
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