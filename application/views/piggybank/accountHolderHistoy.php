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
            <tbody>
                <?php $total_amount = 0;
                    foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ((int)$page + 1); ?></td>
                        <td><?php echo $value->fk_piggy_account_code; ?></td>
                        <td><?php echo $value->fk_piggy_account_name; ?></td>
                        <td class="<?php 
                            if ($value->payment_type == "debit"){
                                echo "redtext";
                                $total_amount = $total_amount - (int)$value->amount;
                            }else if ($value->payment_type == "credit"){
                                echo "greentext";
                                $total_amount = $total_amount + (int)$value->amount;
                            }
                            ?>" >
                            <?php echo $value->amount; ?>
                        </td>
                        <td><?php echo $value->payment_mode; ?></td>
                        <td><?php echo $value->notes; ?></td>
                        <td><?php echo date('d M Y h:i:s A', strtotime($value->payment_date)); ?></td>
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
                    <th>Account Code</th>
                    <th>Account Name</th>
                    <th>Total Amount(<?php echo $total_amount; ?>)</th>
                    <th>Entry Type</th>
                    <th>Notes</th>
                    <th>Payment Date</th>
                    <th>By</th>
                </tr>
            </tfoot>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>