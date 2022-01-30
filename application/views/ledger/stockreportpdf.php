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
        <span style="font:12px;">Stock Report</span><br>
        <span style="font:14px; font-style:bold;"><?php echo isset($title) ? $title : '';?></span><br>
        <span style="font:10px;">Date From:-<?php echo $start_date;?> To:- <?php echo $end_date;?></span><br><br>
    <br>  
    </center>

<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:10px;" width="99%">
<thead >
    <tr>
        <th width="8px;">SN</th>
        <th width="135px;">Item Code</th>
        <th style="text-align:right;">Name</th>
        <th style="text-align:right;" >op. qty.</th>
        <th style="text-align:right;">Purchase</th>
        <th style="text-align:right;">Sales</th>
        <th style="text-align:right;">Closing</th>
        <th width="60px;" style="text-align:right;">Value rs.</th>
    </tr>
</thead>
<tbody>
    <?php 
    $total_stock_value = 0.0;
    $i = 1;
    foreach($result as $value){
        $buy_count = floatval($value["buy_count_value"]);
        $sell_count = floatval($value["sell_count_value"]);
        $total_count = floatval($value["item_total_count"]);
        $opening_value = ($total_count + $sell_count - $buy_count);
        $bill_per_item_value = floatval($value["bill_per_item_value"]);
        $total_value = floatval($bill_per_item_value * $total_count);
        $total_stock_value = floatval($total_stock_value) + floatval($total_value);
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $value["item_code"]; ?></td>
            <td style="text-align:right;"><?php echo $value["item_name"]; ?></td>
            <td style="text-align:right;"><?php echo $opening_value; ?></td>
            <td style="text-align:right;"><?php echo $buy_count; ?></td>
            <td style="text-align:right;"><?php echo $sell_count; ?></td>
            <td style="text-align:right;"><?php echo $total_count; ?></td>
            <td style="text-align:right;"><?php echo number_format($total_value, 2); ?></td>
        </tr>
    <?php $i++; } ?>
        <tr>
            <td colspan="7"></td>
            <td style="text-align:right;"><b><?php echo number_format($total_stock_value, 2); ?></b></td>
        </tr> 
<tbody>
</table>

</body>
</html>