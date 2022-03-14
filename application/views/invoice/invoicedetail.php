<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size:12px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Paid Date</th>
                    <th>Mode</th>
                    <th>Area</th>
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
                    <th>Paid Date</th>
                    <th>Mode</th>
                    <th>Area</th>
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
                        <td><span id="invoiceCreated<?php echo ($page + 1) ?>"><?php echo date("d-m-Y H:i", strtotime($value->created_at)); ?> </span>
                        <?php 
                            if(($value->status === "create") || ($value->status === "initiated") || ($value->status === "pending") || ($value->status === "force_edit") ){
                        ?>
                            <button type="button" data-toggle="modal" class="btn btn-datatable btn-icon"  data-target="#invoicecreatedat"
                            data-invoicecode="<?php echo $value->unique_invioce_code; ?>" 
                            data-refinvoice="<?php echo $value->previous_invoice_ref_no; ?>" 
                            data-created_at="<?php echo $value->created_at; ?>"
                            data-id="invoiceCreated<?php echo ($page + 1) ?>"
                            >
                                <i data-feather="calendar"></i>
                            </button>
                            
                        <?php } ?>
                        </td>
                        <td class="<?php echo ($value->status === "completed") ? "yellowtext" : (( ($value->status === "paid") || ($value->status === "partial_paid"))? "greentext" : "redtext");?>">
                            <?php echo str_replace("_", " ", $value->status); ?>
                        </td>
                        <td><?php echo $value->invoice_paid_date; ?></td>
                        <td><?php echo $value->payment_mode; ?></td>
                        <td><?php echo $value->area; ?></td>
                        <td><?php echo $value->previous_invoice_ref_no; ?></td>
                        <td><?php echo (($value->status === "completed") || ($value->status === "paid") || ($value->status === "partial_paid") ) ? $value->lock_bill_amount : 0; ?></td>
                        <td>
                            <a class="btn btn-datatable btn-icon dropdown-item" href="<?php echo base_url('/createinvoice'."/".$value->unique_invioce_code.""); ?>">
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

<div class="modal fade" id="invoicecreatedat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Date Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="" id="successfullyMessage"></span>
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Created Date:</label>
            <input type="date" class="form-control" id="createdDate" name="createdDate">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="changeDatebutton">Change Date</button>
      </div>
    </div>
  </div>
</div>

<script>
    var updateinvoceref = '';
    var updateinvoicecode = '';
    var updateCreated_at = '';
    var selectedID = '';
    $(document).ready(function () {
        $('#invoicecreatedat').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            updateinvoicecode = button.data('invoicecode');
            updateinvoceref = button.data('refinvoice');
            updateCreated_at = button.data('created_at'); 
            selectedID = button.data('id');    
            $("#createdDate").attr("value", updateCreated_at.split(" ")[0]);
            var modal = $(this);
            modal.find('.modal-title').text('Date Change #(' +updateinvoceref+ ')');
        });
        
        $('#changeDatebutton').click(function(){
            updateCreated_at = $("#createdDate").val();
            if(updateCreated_at.length < 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please select created date.");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return;
            }else{
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('/updateinvoicecreatedDate'); ?>',
                    dataType  : 'json',
                    data: {updateCreated_at: updateCreated_at, invoiceCode: updateinvoicecode},
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function (data) {
                        if (data.code){
                            console.log(data.updated_at);
                            var date_string = moment(data.updated_at, "YYYY-MM-DD H:m").format("DD-MM-YYYY H:m");
                            $("#"+selectedID).text(date_string);
                            $("#successfullyMessage").addClass('alert-success');
                            $("#successfullyMessage").text(data.message);
                            $('#successfullyMessage').fadeIn();
                            $('#successfullyMessage').delay(4000).fadeOut();
                        }else{
                            $("#successfullyMessage").addClass('alert-danger');
                            $("#successfullyMessage").text(data.message);
                            $('#successfullyMessage').fadeIn();
                            $('#successfullyMessage').delay(4000).fadeOut();
                        }
                    }
                });
            }
        });

        $('#globalsearchbutton').click(function(){
            var globalsearch = $('#globalsearch').val();
            if(globalsearch.length > 2){
                var link = '<?php echo $base_url; ?>';
                var url = link + "/" +globalsearch;
                location.replace(url);
            }
        });

        $('#globalclearhbutton').click(function(){
            var link = '<?php echo $base_url; ?>';
            location.replace(link);
        });
        

    });
</script>
<script>
var input = document.getElementById("globalsearch");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("globalsearchbutton").click();
  }
});
</script>