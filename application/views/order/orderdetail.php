<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Area</th>
                    <th>Created by</th>
                    <th>#Inv.</th>
                    <th>Amount(₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Area</th>
                    <th>Created by</th>
                    <th>#Inv.</th>
                    <th>Amount(₹)</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->client_name; ?></td>
                        <td><?php echo $value->created_at; ?></td>
                        <td class="<?php echo ($value->status === "completed") ? "yellowtext" : (( ($value->status === "paid") || ($value->status === "partial_paid"))? "greentext" : "redtext");?>">
                            <?php echo str_replace("_", " ", $value->status); ?>
                        </td>
                        <td><?php echo $value->area; ?></td>
                        <td>
                            <a href="<?php echo base_url('/account'.'/'.$value->fk_username); ?>">
                                <?php echo $value->fk_username; ?>
                            </a>
                        </td>
                        <td><?php echo $value->previous_order_ref_no; ?></td>
                        <td><?php echo (($value->status === "completed") || ($value->status === "paid") || ($value->status === "partial_paid") ) ? $value->lock_bill_amount : 0; ?></td>
                        <td>
                            <a class="btn btn-datatable btn-icon dropdown-item" href="<?php echo base_url('/createorder'."/".$value->unique_order_code.""); ?>">
                                <i data-feather="arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                <?php $page++; }; ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>