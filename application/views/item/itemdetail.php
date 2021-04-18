<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Company Code</th>
                    <th>Weight(ml)</th>
                    <th>Unit/Case</th>
                    <th>MRP(&#8377;)</th>
                    <th>Cost(&#8377;)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Company Code</th>
                    <th>Weight</th>
                    <th>Unit/Case</th>
                    <th>MRP(&#8377;)</th>
                    <th>Cost(&#8377;)</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo $value->item_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->company_code; ?></td>
                        <td><?php echo ($value->weight_in_ltr * 1000); ?></td>
                        <td><?php echo $value->unit_case; ?></td>
                        <td><?php echo $value->mrp; ?></td>
                        <td><?php echo $value->cost_price; ?></td>
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