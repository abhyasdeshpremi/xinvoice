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
        <th style="text-align:right;" >GSTIN</th>
        <th width="155px;" style="text-align:right;">SALE AMOUNT</th>
    </tr>
</thead>
<tbody>
    <?php 
    
    $i = 1;
    
    $total_debit_count_value = 0.0;
    $final_total_debit_count_value = 0.0;
    $tmpDistrict = $result[0]["district"]; ?>

        <tr>
            <td></td>
            <td><b><?php echo $tmpDistrict; ?></b></td>
            <td colspan="3"></td>
        </tr>
    <?php 
    foreach($result as $value){
        $debit_count_value = floatval($value["debit_count_value"]);
        $currentDistrict = $value["district"];
        if ($tmpDistrict == $currentDistrict){ ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td style="text-align:left;"><?php echo $value["fk_client_name"]; ?></td>
                <td ><?php echo $value["client_type"]; ?></td>
                <td style="text-align:left;"><?php echo $value["gst_no"]; ?></td>
                <td style="text-align:right;"><?php echo $debit_count_value; ?></td>
            </tr>
        <?php 
        }else{ $i = 1; ?>
            <tr>
                <td colspan="3"></td>
                <td style="text-align:right;"><b>TOTAL</b></td>
                <td style="text-align:right;"><b><?php echo number_format($total_debit_count_value, 2); ?></b></td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td><b><?php echo $currentDistrict; ?></b></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td><?php echo $i; ?></td>
                <td style="text-align:left;"><?php echo $value["fk_client_name"]; ?></td>
                <td ><?php echo $value["client_type"]; ?></td>
                <td style="text-align:left;"><?php echo $value["gst_no"]; ?></td>
                <td style="text-align:right;"><?php echo $debit_count_value; ?></td>
            </tr>
        <?php
            $total_debit_count_value = 0.0;
            $tmpDistrict = $currentDistrict;
        }

        $total_debit_count_value = floatval($total_debit_count_value) + floatval($debit_count_value);
        $final_total_debit_count_value = floatval($final_total_debit_count_value) + floatval($debit_count_value);
    ?>
        
    <?php $i++; } ?>
        <tr>
            <td colspan="3"></td>
            <td style="text-align:right;"><b>TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($total_debit_count_value, 2); ?></b></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align:right;"><b>FINAL TOTAL</b></td>
            <td style="text-align:right;"><b><?php echo number_format($final_total_debit_count_value, 2); ?></b></td>
        </tr>
<tbody>
</table>

</body>
</html>