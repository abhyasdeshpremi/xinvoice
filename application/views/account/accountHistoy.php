<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Total Amount</th>
                    <th>Entry Type</th>
                    <th>Notes</th>
                    <th>Payment Date</th>
                    <th>By</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Total Amount</th>
                    <th>Entry Type</th>
                    <th>Notes</th>
                    <th>Payment Date</th>
                    <th>By</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ((int)$page + 1); ?></td>
                        <td><?php echo $value->fk_client_code; ?></td>
                        <td><?php echo $value->fk_client_name; ?></td>
                        <td class="<?php 
                            if ($value->payment_type == "debit"){
                                echo "redtext";
                            }else if ($value->payment_type == "credit"){
                                echo "greentext";
                            }
                            ?>" >
                            <?php echo $value->amount; ?>
                        </td>
                        <td><?php echo $value->payment_mode; ?></td>
                        <td><?php echo $value->notes; ?></td>
                        <td><?php echo date('d M Y h:i:s A', strtotime($value->payment_date)); ?></td>
                        <td><?php echo $value->fk_username; ?></td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>