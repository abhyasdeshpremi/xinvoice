<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock</th>
                    <th>Entry Type</th>
                    <th>Comment</th>
                    <th>Date&Time</th>
                    <th>By</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock</th>
                    <th>Entry Type</th>
                    <th>Comment</th>
                    <th>Date&Time</th>
                    <th>By</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->item_code; ?></td>
                        <td><?php echo $value->item_name; ?></td>
                        <td><?php echo $value->item_count; ?></td>
                        <td><?php echo $value->entry_type; ?></td>
                        <td><?php echo $value->comment; ?></td>
                        <td><?php echo date('d M Y h:i:s A', strtotime($value->created_at)); ?></td>
                        <td><?php echo $value->fk_username; ?></td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>