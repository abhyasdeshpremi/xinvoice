<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Paid Date</th>
                    <th>Mode</th>
                    <th>Area</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Paid Date</th>
                    <th>Mode</th>
                    <th>Area</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php $i = 1;
                    foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->client_name; ?></td>
                        <td><?php echo $value->created_at; ?></td>
                        <td><?php echo $value->status; ?></td>
                        <td><?php echo $value->invoice_paid_date; ?></td>
                        <td><?php echo $value->payment_mode; ?></td>
                        <td><?php echo $value->area; ?></td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-transparent-dark dropdown-item" href="<?php echo base_url('/createinvoice'."/".$value->unique_invioce_code.""); ?>">
                                <i data-feather="arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                <?php $i++; }; ?>
            </tbody>
        </table>
    </div>
</div>