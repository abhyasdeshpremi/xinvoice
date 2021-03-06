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
                                <span id="<?php echo $value->fk_client_code; ?>"><?php echo $value->total_amount; ?></span>
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
        ???+
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
                    <div id="myDropdown" class="dropdown-menu">
                        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" autocomplete="off">
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
                <input type="date" class="form-control" aria-label="Small"  id="paymentdate" name="paymentdate" required>
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
            $("#submit_payment").attr('disabled','disabled');
            if(client_name.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please selecr Client");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                $("#submit_payment").removeAttr('disabled');
                return false;
            }
            if(paymentdate.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please select payment date");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                $("#submit_payment").removeAttr('disabled');
                return false;
            }
            if(paymentamout.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add payment amount");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                $("#submit_payment").removeAttr('disabled');
                return false;
            }
            if(paymentcomment.length <= 0){
                $("#successfullyMessage").addClass('alert-danger');
                $("#successfullyMessage").text("Please add payment notes");
                $('#successfullyMessage').fadeIn();
                $('#successfullyMessage').delay(4000).fadeOut();
                $("#submit_payment").removeAttr('disabled');
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
                    $("#submit_payment").removeAttr('disabled');
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
                        if($('#'+client_code).length){
                            $('#'+client_code).text(data.totalAmount);
                        }
                        $("#successfullyMessage").addClass('alert-success');
                    }else{
                        $("#successfullyMessage").addClass('alert-danger');
                    }
                    $("#successfullyMessage").text(data.message);
                    $('#successfullyMessage').fadeIn();
                    $('#successfullyMessage').delay(4000).fadeOut();
                    $("#submit_payment").removeAttr('disabled');
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

    var input = document.getElementById("globalsearch");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("globalsearchbutton").click();
        }
    });

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }

    function removefilterFunction() {
        var a; 
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            a[i].style.display = ""; 
        }
    }
</script>