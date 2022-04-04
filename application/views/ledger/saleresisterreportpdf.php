
<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Sale Report</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        table, th{
            border: 1px dashed black;
        }
        table, td{
            border-right-style: dashed;
            border: 1px black;
        }
        th, td {
           padding-left: 5px;
           padding-right:5px;
        }
        body {
        font-family: Helvetica, sans-serif;
        }
    </style>
</head> 
<?php 
$globalInvoice_bill_include_tax = $this->session->userdata('bill_include_tax');
$tax = false;
$colspan = 4;
$othercolspan = 5;
if($globalInvoice_bill_include_tax == 'yes'){
    $tax = true;
    $colspan = 5;
    $othercolspan = 8;
}
?>
<body style="width : 100%;" >
    <center>
        <span style="font:12px; text-transform: uppercase;">Sale Report</span><br>
        <span style="font:14px; font-style:bold; text-transform: uppercase;"><?php echo isset($title) ? $title : '';?></span><br>
        <span style="font:10px; text-transform: uppercase;">Date From:- <?php echo date("d-m-Y", strtotime($start_date)); ?> To:- <?php echo date("d-m-Y", strtotime($end_date)); ?></span><br><br>
    <br>  
    </center>

<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:11px;" width="99%">
<thead >
    <tr>
        <th width="10px;">#</th>
        <th width="55px;">DATE</th>
        <th>INVNo.</th>
        <th>PARTY NAME</th>
        <?php if($tax){ ?><th>GSTIN</th><?php } ?>
        <th style="text-align:left;">MODE</th>
        <th style="text-align:right;">MRP</th>
        <?php if($tax){ ?><th style="text-align:right;">BASIC</th><?php } ?>
        <?php if($tax){ ?><th style="text-align:right;">CGST</th><?php } ?>
        <?php if($tax){ ?><th style="text-align:right;">SGST</th><?php } ?>
        <?php if($tax){ ?><th style="text-align:right;">R.OFF</th><?php } ?>
        <th style="text-align:right;" width="70px;">NET AMOUNT</th>
    </tr>
</thead>
<tbody>
    <?php 
    
    $i = 1;
    
    $total_basic_value_amount = 0.0;
    $total_cgst_amount = 0.0;
    $total_sgst_amount = 0.0;
    $total_round_off_amount = 0.0;
    $total_lock_bill_amount = 0.0;
    $final_total_lock_bill_amount = 0.0;
    $total_lock_mrp_amount = 0.0;
    $final_total_lock_mrp_amount = 0.0;

    $tmpBillDate = $result[0]["bill_date"];
    foreach($result as $value){

        $basic_value_amount = floatval($value["basic_value_amount"]);
        $cgst_amount = floatval($value["cgst_amount"]);
        $sgst_amount = floatval($value["sgst_amount"]);
        $round_off_amount = floatval($value["round_off_amount"]);
        $lock_bill_amount = floatval($value["lock_bill_amount"]);
        $lock_mrp_amount = floatval($value["lock_mrp_amount"]);

        $currentBillDate = $value["bill_date"];
        if ($tmpBillDate == $currentBillDate){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value["bill_date"]; ?></td>
                <td><?php echo $value["previous_invoice_ref_no"]."/".$value["financial_year"]; ?></td>
                <td><?php echo $value["client_name"]; ?></td>
                <?php if($tax){ ?><td><?php echo $value["gstnumber"]; ?></td><?php } ?>
                <td><?php echo $value["payment_mode"]; ?></td>
                <td style="text-align:right;"><?php echo number_format($value["lock_mrp_amount"], 2); ?></td>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["basic_value_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["cgst_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["sgst_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["round_off_amount"], 2); ?></td><?php } ?>
                <td style="text-align:right;"><?php echo number_format($value["lock_bill_amount"], 2); ?></td>
            </tr>
        <?php 
        }else{ ?>
            <tr>
                <td colspan="<?php echo $colspan; ?>"></td>
                <td style="text-align:right;"><b>TOTAL</b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_lock_mrp_amount, 2); ?></b></td>
                <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_basic_value_amount, 2); ?></b></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_cgst_amount, 2); ?></b></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_sgst_amount, 2); ?></b></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_round_off_amount, 2); ?></b></td><?php } ?>
                <td style="text-align:right;"><b><?php echo number_format($total_lock_bill_amount, 2); ?></b></td>
            </tr>
            <tr>
                <td colspan="<?php echo $othercolspan; ?>">&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value["bill_date"]; ?></td>
                <td><?php echo $value["previous_invoice_ref_no"]."/".$value["financial_year"]; ?></td>
                <td><?php echo $value["client_name"]; ?></td>
                <?php if($tax){ ?><td><?php echo $value["gstnumber"]; ?></td><?php } ?>
                <td><?php echo $value["payment_mode"]; ?></td>
                <td style="text-align:right;"><?php echo number_format($value["lock_mrp_amount"], 2); ?></td>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["basic_value_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["cgst_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["sgst_amount"], 2); ?></td><?php } ?>
                <?php if($tax){ ?><td style="text-align:right;"><?php echo number_format($value["round_off_amount"], 2); ?></td><?php } ?>
                <td style="text-align:right;"><?php echo number_format($value["lock_bill_amount"], 2); ?></td>
            </tr>
        <?php
            $total_basic_value_amount = 0.0;
            $total_cgst_amount = 0.0;
            $total_sgst_amount = 0.0;
            $total_round_off_amount = 0.0;
            $total_lock_bill_amount = 0.0;
            $total_lock_mrp_amount = 0.0;
            $tmpBillDate = $currentBillDate;
        }


        $total_basic_value_amount = floatval($total_basic_value_amount) + floatval($basic_value_amount);
        $total_cgst_amount = floatval($total_cgst_amount) + floatval($cgst_amount);
        $total_sgst_amount = floatval($total_sgst_amount) + floatval($sgst_amount);
        $total_round_off_amount = floatval($total_round_off_amount) + floatval($round_off_amount);
        $total_lock_bill_amount = floatval($total_lock_bill_amount) + floatval($lock_bill_amount);
        $final_total_lock_bill_amount = floatval($final_total_lock_bill_amount) + floatval($lock_bill_amount);

        $total_lock_mrp_amount = floatval($total_lock_mrp_amount) + floatval($lock_mrp_amount);
        $final_total_lock_mrp_amount = floatval($final_total_lock_mrp_amount) + floatval($lock_mrp_amount);
    ?>
        
    <?php $i++; } ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>"></td>
            <td style="text-align:right;"><b>TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_lock_mrp_amount, 2); ?></b></td>
            <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_basic_value_amount, 2); ?></b></td><?php } ?>
            <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_cgst_amount, 2); ?></b></td><?php } ?>
            <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_sgst_amount, 2); ?></b></td><?php } ?>
            <?php if($tax){ ?><td style="text-align:right;"><b><?php echo number_format($total_round_off_amount, 2); ?></b></td><?php } ?>
            <td style="text-align:right;"><b><?php echo number_format($total_lock_bill_amount, 2); ?></b></td>
        </tr>
        <tr>
            <td colspan="<?php echo ($colspan + 1); ?>" style="text-align:right;"><b>FINAL TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($final_total_lock_mrp_amount, 2); ?></b></td>
            <?php if($tax){ ?> <td colspan="4"> <?php } ?>
            <td style="text-align:right;"><b><?php echo number_format($final_total_lock_bill_amount, 2); ?></b></td>
        </tr>
<tbody>
</table>

</body>
</html>