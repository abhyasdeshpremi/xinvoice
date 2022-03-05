<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.png" />
    <title>Order:- <?php echo isset($invoicetitle) ? $invoicetitle : ''; ?></title>
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
        body {
        font-family: Helvetica, sans-serif;
        }
    </style>
</head>
<?php 
 $width = "width : 50%; border-right: 1px dotted black;";
if(isset($mode)){
   if($mode === "portrait"){
        $width = "width : 100%;";
   }
}

$orderTitletype = "ORDER RECEIPT";
?>
<body style="<?php echo $width; ?>" >
    <center>
        <span style="font:12px;"><?php echo $orderTitletype; ?></span><br>
        <span style="font:14px; font-style:bold;"><?php echo isset($ordertitle) ? $ordertitle : '';?></span><br>
        <span style="font:10px;"><?php echo isset($subtitle) ? $subtitle : '';?></span><br><br>
    </center>
    <hr style="text-align:left;margin-left:0; margin-right:10px; margin-top: -10px; margin-bottom: 0px;">
        <p style="font: 12px; text-transform: uppercase;">Client:- <span><?php echo $clientname; ?> 
        <?php echo isset($mobilenumber) ? ', Mob.:- '.$mobilenumber : ''; ?> 
        <?php echo isset($clientarea) ? ', Area.:- '.$clientarea : ''; ?> 
        <?php echo isset($clientarea) ? ', Area.:- '.$clientarea : ''; ?>
        <?php echo isset($orderid) ? ', ORDER NO.:- '.$orderid.'/ '.financial_year($created_at) : ''; ?>
        <?php echo isset($created_at) ? ', DATE:- '.$created_at: ''; ?>
    </span> </p>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:12px; color: #000;" width="99%">
    <thead >
        <tr>
            <th width="8px;">SN</th>
            <th width="135px;">Name</th>
            <th style="text-align:right;">C/S</th>
            <th style="text-align:right;" >QTY</th>
            <th style="text-align:right;">MRP</th>
            <th style="text-align:right;" width="50px;">MRP VAL</th>
            <th style="text-align:right;">DS%</th>
            <th width="60px;" style="text-align:right;">Bill Value</th>
        </tr>
    </thead>
    <tbody>
        <?php   $i = 1;
                $mrp_value = 0;
                $bill_value = 0;
                $basicItemsValue = 0;
                $qty_value = 0;
                $case_unit_value = 0;
        foreach($orderitemsList as $value){
            $mrp_value = $mrp_value + (float)$value->mrp_value;
            $bill_value = $bill_value + round((double)$value->bill_value, 2);
            $qty_value = $qty_value + (int)$value->quantity;
            $case_unit_value = $case_unit_value + (float)$value->case_unit;
            $basicItemValue = round((($value->bill_value * 100) / 118), 2);
            $basicItemsValue = $basicItemsValue + $basicItemValue;

            $discount_num = number_format( (int)(isset($value->discount) ? $value->discount : 0), 2);
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value->fk_item_name; ?></td>
                <td style="text-align:right;"><?php echo $value->case_unit; ?></td>
                <td style="text-align:right;"><?php echo $value->quantity; ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp_value, 2); ?></td>
                <td style="text-align:right;"><?php echo $discount_num; ?></td>
                <td style="text-align:right;"><?php echo number_format($value->bill_value, 2); ?></td>
            </tr>
        <?php $i++; } ?>
            <tr>
                <td colspan="2"></td>
                <td style="text-align:right;"><hr><b><?php echo $case_unit_value; ?></b></td>
                <td style="text-align:right;"><hr><b><?php echo $qty_value; ?></b></td>
                <td></td>
                <td style="text-align:right;"><hr><b><?php echo number_format($mrp_value, 2); ?></b></td>
                <td></td>
                <td style="text-align:right;"><hr><b><?php echo number_format($bill_value, 2); ?></b></td>
            </tr>
            <?php 
                $basic_value = number_format($basicItemsValue, 2);
                $basicValue = round((($bill_value * 100) / 118), 2);
                $cgstValue = round((($basicValue * 9) / 100), 2);
                $total_cgst_value = filter_var($basic_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) + $cgstValue;
                $sgstValue = $cgstValue;
                $total_cgst_sgst_value = ($total_cgst_value + $sgstValue);
                $bill_amount = round($total_cgst_sgst_value, 0);
                $round_off = round(($bill_amount - $total_cgst_sgst_value), 2);
            ?>
    <tbody>
</table>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
    <spna style="font:12px;">RS. (IN WORDS) : <?php echo ucwords(getIndianCurrency($bill_amount));?> </span>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
</body>
</html>