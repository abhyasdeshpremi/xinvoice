<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock</th>
                    <th>Entry Type</th>
                    <th>Bill Value(₹)</th>
                    <th>Date&Time</th>
                    <th>By</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_stock = 0;
                    foreach($data as $value){ 
                    
                    if($value->invoice_type == "sell"){
                        $total_stock = (int)$total_stock - (int)$value->quantity;
                    }else if($value->invoice_type == "purchase"){
                        $total_stock = (int)$total_stock + (int)$value->quantity;
                    }
                    ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->fk_item_code; ?></td>
                        <td><?php echo $value->fk_item_name; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->invoice_type; ?></td>
                        <td><?php echo number_format($value->bill_value, 2); ?></td>
                        <td><?php echo date('d M Y h:i:s A', strtotime($value->created_at)); ?></td>
                        <td>
                            <a href="<?php echo base_url('/account'.'/'.$value->fk_username); ?>">
                                <?php echo $value->fk_username; ?>
                            </a>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Total Stock(<?php echo $total_stock; ?>)</th>
                    <th>Entry Type</th>
                    <th>Bill Value(₹)</th>
                    <th>Date&Time</th>
                    <th>By</th>
                </tr>
            </tfoot>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>