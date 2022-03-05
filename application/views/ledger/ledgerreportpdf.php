<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Ledger Report</title>
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
<body style="width : 100%;" >
    <center>
        <span style="font:12px; text-transform: uppercase;">Ledger Report</span><br>
        <span style="font:14px; font-style:bold; text-transform: uppercase;"><?php echo isset($title) ? $title : '';?></span><br>
        <span style="font:10px; text-transform: uppercase;">Date From:- <?php echo date("d-m-Y", strtotime($start_date)); ?> To:- <?php echo date("d-m-Y", strtotime($end_date)); ?></span><br><br>
    <br>  
    </center>

<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:11px;" width="99%">
<thead >
    <tr>
        <th width="8px;">SN</th>
        <th width="195px;" style="text-align:left;">NAME</th>
        <th>TYPE</th>
        <th style="text-align:right;" >DISTRICT</th>
        <th style="text-align:right;">OP. BAL</th>
        <th width="55px;" style="text-align:right;">TTL CR.</th>
        <th width="55px;" style="text-align:right;">TTL DR.</th>
        <th width="90px;" style="text-align:right;">CL. BAL</th>
    </tr>
</thead>
<tbody>
    <?php 
    
    $i = 1;
    
    $total_opening_amount = 0.0;
    $total_credit_count_value = 0.0;
    $total_debit_count_value = 0.0;
    $total_amount_value = 0.0;
    $tmpDistrict = $result[0]["district"];
    foreach($result as $value){
        $credit_count_value = floatval($value["credit_count_value"]);
        $debit_count_value = floatval($value["debit_count_value"]);
        $total_amount = floatval($value["total_amount"]);
        $opening_amount = ($total_amount + $debit_count_value - $credit_count_value);


        $currentDistrict = $value["district"];
        if ($tmpDistrict == $currentDistrict){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td style="text-align:left;"><?php echo $value["fk_client_name"]; ?></td>
                <td ><?php echo $value["client_type"]; ?></td>
                <td style="text-align:left;"><?php echo $value["district"]; ?></td>
                <td style="text-align:right;"><?php echo $opening_amount; ?></td>
                <td style="text-align:right;"><?php echo $credit_count_value; ?></td>
                <td style="text-align:right;"><?php echo $debit_count_value; ?></td>
                <td style="text-align:right;"><?php echo number_format($total_amount, 2); ?></td>
            </tr>
        <?php 
        }else{ ?>
            <tr>
                <td colspan="3"></td>
                <td style="text-align:right;"><b>TOTAL</b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_opening_amount, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_credit_count_value, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_debit_count_value, 2); ?></b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_amount_value, 2); ?></b></td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $i; ?></td>
                <td style="text-align:left;"><?php echo $value["fk_client_name"]; ?></td>
                <td ><?php echo $value["client_type"]; ?></td>
                <td style="text-align:left;"><?php echo $value["district"]; ?></td>
                <td style="text-align:right;"><?php echo $opening_amount; ?></td>
                <td style="text-align:right;"><?php echo $credit_count_value; ?></td>
                <td style="text-align:right;"><?php echo $debit_count_value; ?></td>
                <td style="text-align:right;"><?php echo number_format($total_amount, 2); ?></td>
            </tr>
        <?php
            $total_opening_amount = 0.0;
            $total_credit_count_value = 0.0;
            $total_debit_count_value = 0.0;
            $total_amount_value = 0.0;
            $tmpDistrict = $currentDistrict;
        }


        $total_opening_amount = floatval($total_opening_amount) + floatval($opening_amount);
        $total_credit_count_value = floatval($total_credit_count_value) + floatval($credit_count_value);
        $total_debit_count_value = floatval($total_debit_count_value) + floatval($debit_count_value);
        $total_amount_value = floatval($total_amount_value) + floatval($total_amount);
    ?>
        
    <?php $i++; } ?>
        <tr>
            <td colspan="3"></td>
            <td style="text-align:right;"><b>TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_opening_amount, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_credit_count_value, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_debit_count_value, 2); ?></b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_amount_value, 2); ?></b></td>
        </tr>
<tbody>
</table>

</body>
</html>