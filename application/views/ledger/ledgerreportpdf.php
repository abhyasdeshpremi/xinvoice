<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Stock Report</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        table, th{
            border: 1px dotted gray;
        }
        table, td{
            border-right-style: dotted;
            border: 1px gray;
        }
        th, td {
           padding-left: 5px;
           padding-right:5px;
        }
    </style>
</head> 
<body style="width : 100%;" >
    <center>
        <span style="font:12px;">Ledger Report</span><br>
        <span style="font:14px; font-style:bold;"><?php echo isset($title) ? $title : '';?></span><br>
        <span style="font:10px;">Date From:-<?php echo $start_date;?> To:- <?php echo $end_date;?></span><br><br>
    <br>  
    </center>

<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:10px;" width="99%">
<thead >
    <tr>
        <th width="10px;">#</th>
        <th width="50px;">DATE</th>
        <th>INVNo.</th>
        <th>PARTY NAME</th>
        <th>GSTIN</th>
        <th>MODE</th>
        <th style="text-align:right;">BASIC</th>
        <th style="text-align:right;">CGST</th>
        <th style="text-align:right;">SGST</th>
        <th style="text-align:right;">R.OFF</th>
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

    $tmpBillDate = $result[0]["bill_date"];
    foreach($result as $value){

        $basic_value_amount = floatval($value["basic_value_amount"]);
        $cgst_amount = floatval($value["cgst_amount"]);
        $sgst_amount = floatval($value["sgst_amount"]);
        $round_off_amount = floatval($value["round_off_amount"]);
        $lock_bill_amount = floatval($value["lock_bill_amount"]);

        $currentBillDate = $value["bill_date"];
        if ($tmpBillDate == $currentBillDate){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value["bill_date"]; ?></td>
                <td><?php echo $value["invoice_bill_date"]."/".$value["invoice_bill_date"]; ?></td>
                <td><?php echo $value["client_name"]; ?></td>
                <td><?php echo $value["gstnumber"]; ?></td>
                <td><?php echo $value["payment_mode"]; ?></td>
                <td style="text-align:right;"><?php echo number_format($value["basic_value_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["cgst_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["sgst_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["round_off_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["lock_bill_amount"], 2); ?></td>
            </tr>
        <?php 
        }else{ ?>
            <tr>
                <td colspan="5"></td>
                <td style="text-align:right;"><b>TOTAL</b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_basic_value_amount, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_cgst_amount, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_sgst_amount, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_round_off_amount, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_lock_bill_amount, 2); ?></b></td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value["bill_date"]; ?></td>
                <td><?php echo $value["invoice_bill_date"]."/".$value["invoice_bill_date"]; ?></td>
                <td><?php echo $value["client_name"]; ?></td>
                <td><?php echo $value["gstnumber"]; ?></td>
                <td><?php echo $value["payment_mode"]; ?></td>
                <td style="text-align:right;"><?php echo number_format($value["basic_value_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["cgst_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["sgst_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["round_off_amount"], 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value["lock_bill_amount"], 2); ?></td>
            </tr>
        <?php
            $total_basic_value_amount = 0.0;
            $total_cgst_amount = 0.0;
            $total_sgst_amount = 0.0;
            $total_round_off_amount = 0.0;
            $total_lock_bill_amount = 0.0;
            $tmpBillDate = $currentBillDate;
        }


        $total_basic_value_amount = floatval($total_basic_value_amount) + floatval($basic_value_amount);
        $total_cgst_amount = floatval($total_cgst_amount) + floatval($cgst_amount);
        $total_sgst_amount = floatval($total_sgst_amount) + floatval($sgst_amount);
        $total_round_off_amount = floatval($total_round_off_amount) + floatval($round_off_amount);
        $total_lock_bill_amount = floatval($total_lock_bill_amount) + floatval($lock_bill_amount);
    ?>
        
    <?php $i++; } ?>
        <tr>
            <td colspan="5"></td>
            <td style="text-align:right;"><b>TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_basic_value_amount, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_cgst_amount, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_sgst_amount, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_round_off_amount, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_lock_bill_amount, 2); ?></b></td>
        </tr>
<tbody>
</table>

</body>
</html>