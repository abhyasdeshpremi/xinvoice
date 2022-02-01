<div class="datatable">
    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:50px;">Sr.</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Client Type</th>
                    <th>District</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.</th>
                    <th>Client Code</th>
                    <th>Client Name</th>
                    <th>Client Type</th>
                    <th>District</th>
                    <th>Total Amount</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($data as $value){ ?>
                    <tr>
                        <td><?php echo ($page + 1); ?></td>
                        <td><?php echo $value->fk_client_code; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><div class="badge badge-primary badge-pill"><?php echo $value->client_type; ?></div></td>
                        <td><?php echo $value->district; ?></td>
                        <td>
                            <a href="<?php echo base_url('/getclientaccounthistory'.'/'.$value->fk_client_code); ?>">
                                <?php echo $value->total_amount; ?>
                            </a>
                        </td>
                    </tr>
                <?php $page++; } ?>
            </tbody>
        </table>
        <div class="pagelist"><center><?php echo $links; ?></center></div>
    </div>
</div>
<div class="row">
    <div class="col-md-10 mb-3">
    </div>
    <div class="col-md-1 mb-3">
        <button type="button" class="btn btn-warning" id="hardRefreshAccount"> <i data-feather="refresh-cw"></i></button>
    </div>
    <div class="col-md-1 mb-3">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addAccountInput" data-whatever="@mdo" data-backdrop="static" data-keyboard="false">
        ₹+
        </button>
    </div>
</div>


<!----Add item modal Start----->
<div class="modal fade" id="addAccountInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalheader">
        <h5 class="modal-title" id="exampleModalLabel">Manually Account Adjustment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <span class="" id="successfullyMessage"></span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Client</button>
                    <div class="dropdown-menu">
                            <?php $count = 1;
                                foreach($clientsList as $client){ ?>
                                    <a class="dropdown-item small select-dropdown-item" hreflang="<?php echo $client->code; ?>"><?php echo $client->name;?></a>
                            <?php $count++; } ?>
                    </div>
                </div>
                <input type="hidden" class="form-control" aria-label="Text input with dropdown button" id="selectclientcode" name="selectclientcode" >
                <input type="text" class="form-control" aria-label="Text input with dropdown button" id="clientdescription" name="clientdescription" readonly>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Payment Mode</span>
                </div>
                <select class="form-control" id="paymentmode" name="paymentmode">
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                    <option value="partialcash">Partial Cash</option>
                </select>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Payment Date</span>
                </div>
                <input type="text" class="form-control datepicker" data-date-format="mm/dd/yyyy" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-provide="datepicker" id="paymentdate" name="paymentdate" value="" required>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Amount</span>
                </div>
                <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="paymentamount" name="paymentamount" value="" required>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Comment</span>
                </div>
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="paymentcomment" name="paymentcomment" value="" required>
            </div>
            <div class="input-group input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Payment Type</span>
                </div>
                <select class="form-control" id="paymenttype" name="paymenttype">
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="forceclose">Close</button>
        <button type="button" class="btn btn-warning" id="submit_payment">Submit</button>
      </div>
    </div>
  </div>
</div>

<!----Add Stock modal end----->

<script>
    
    $(document).ready(function(){
        $("#datepicker").datepicker({ 
            autoclose: true, 
            todayHighlight: true
        }).datepicker('update', new Date());
        
        $("#hardRefreshAccount").click(function () {
            location.reload(true);
        });

        $('#modalheader').css("background-color", "green");
        $('#modalheader h5').css("color", "white");
        $("#paymenttype").change(function(){
            var selectedpaymentmode = $(this).children("option:selected").val();
            if(selectedpaymentmode == 'credit'){
                $('#modalheader').css("background-color", "green");
            }else if(selectedpaymentmode == 'debit'){
                $('#modalheader').css("background-color", "red");
            }else{
                $('#modalheader').css("background-color", "green");
            }
        });



        $('.select-dropdown-item').click(function(){
            var clientList = <?php echo json_encode($clientsList); ?>;
            var clientcode = $(this).attr("hreflang");
            var clientName = "";
            for(var i = 0; i < clientList.length; i++) {
                if (clientcode == clientList[i]["code"]){
                    $('#selectclientcode').val(clientcode);
                    $('#clientdescription').val(clientList[i]["name"]);
                }
            }
        });

        //Add stock 
        $('#submit_payment').click(function(){
            var client_code = $("#selectclientcode").val();
            var client_name = $("#clientdescription").val();
            var paymentmode = $("#paymentmode").val();
            var paymenttype = $("#paymenttype").val();
            var paymentdate = $("#paymentdate").val();
            var paymentamout = $("#paymentamount").val();
            var paymentcomment = $("#paymentcomment").val();
            if(client_name.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please selecr Client");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            if(paymentdate.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please select payment date");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            if(paymentamout.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add payment amount");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            if(paymentcomment.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add payment notes");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('/saveamount'); ?>',
                data: {fk_client_code: client_code, fk_client_name:client_name, payment_mode:paymentmode, payment_date:paymentdate, amount:paymentamout, notes:paymentcomment, paymenttype:paymenttype},
                error: function(request, error) {
                    console.log(arguments);
                    $("#successfullyMessage").addClass('alert-danger');
                    $("#successfullyMessage").text("Something went wrong");
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                },
                success: function (data) {
                    var data = JSON.parse(data);
                    if(data.code){
                        $("#selectclientcode").val('');
                        $("#clientdescription").val('');
                        $("#paymentmode").val('');
                        $("#paymentdate").val('');
                        $("#paymentamount").val('');
                        $("#paymentcomment").val('');
                        $("#successfullyMessage").addClass('alert-success');
                    }else{
                        $("#successfullyMessage").addClass('alert-danger');
                    }
                    $("#successfullyMessage").text(data.message);
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                }
            });
        });

        $("#addAccountInput").on("hidden.bs.modal", function () {
            $("#selectitemcode").val('');
            $("#itemdescription").val('');
            $("#paymentmode").val('');
            $("#stockunit").val('');
            $("#stockcomment").val('');
            $('#modalheader').css("background-color", "green");
        });

    });
</script>