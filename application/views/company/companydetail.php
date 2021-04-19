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
                    <tr>
                        <td><?php echo $value->company_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->description; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->status; ?></div></td>
                        <td>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark mr-2"><i data-feather="more-vertical"></i></button>
                            <button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>