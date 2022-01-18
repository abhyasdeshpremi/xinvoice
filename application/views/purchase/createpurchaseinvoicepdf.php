<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Invoice:- <?php echo isset($invoicetitle) ? $invoicetitle : ''; ?></title>
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
<?php 
 $width = "width : 50%; border-right: 1px dotted black;";
if(isset($mode)){
   if($mode === "portrait"){
        $width = "width : 100%;";
   }
} ?>
<body style="<?php echo $width; ?>" >
    <center>
        <span style="font:12px;">TAX INVOICE</span><br>
        <span style="font:14px; font-style:bold;"><?php echo isset($invoicetitle) ? $invoicetitle : '';?></span><br>
        <span style="font:10px;"><?php echo $invoicesubtitle;?></span><br><br>
    </center>
    <span style="font:8px; float:left;">GSTIN : <?php echo isset($owninvoicegstin) ? $owninvoicegstin : ''; ?></span>
    <span style="font:8px; float:right; margin-right:10px;">MOB.NO.: <?php echo $owninvoicemobileno; ?><br>ORIGINAL FOR RECIPIENT</span>
    <br>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
        <div style="height:60px; font: 8px;">
            <div style="width:50%; height: 60px; float:left;"> To,
                <div style="margin-right:10px;">
                    <span><?php echo $clientname; ?></span><br>
                    <span><?php echo $clintaddress; ?></span><br>
                    <span><?php echo $clientcity." ".$clientarea; ?></span><br>
                    <span><?php echo $clientDistrict. " ".$clientpincode; ?></span><br>
                    <span>GSTIN : <?php echo $gstin; ?></span>
                </div>
            </div>
            <div style="width:50%; height: 60px; float:right;"> 
                    <span>INVOICE NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $invoicepkid; ?> / 21-22</span><br>
                    <span>DATE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $created_at; ?></span><br>
                    <span>PAYMENT MODE &nbsp; &nbsp;: <?php echo $paymentmode; ?></span><br>
                    <span>VAHICLE NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $vehicleno; ?></span><br>
                    <span>PAN NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $pannumber; ?></span><br>
                    <span>MOB NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; : <?php echo $mobilenumber; ?></span>
            </div>
        </div>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:10px;" width="99%">
    <thead >
        <tr>
            <th width="8px;">SN</th>
            <th width="135px;">Name</th>
            <th style="text-align:right;">C/S</th>
            <th style="text-align:right;" >QTY</th>
            <th style="text-align:right;">MRP</th>
            <th style="text-align:right;" width="50px;">MRP VAL</th>
            <th style="text-align:right;">DS%</th>
            <th style="text-align:right;">Bas. Val</th>
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
        foreach($invoiceitemsList as $value){
            $mrp_value = $mrp_value + (float)$value->mrp_value;
            $bill_value = $bill_value + (double)$value->bill_value;
            $qty_value = $qty_value + (int)$value->quantity;
            $case_unit_value = $case_unit_value + (float)$value->case_unit;
            $basicItemValue = round((($value->bill_value * 100) / 118), 2);
            $basicItemsValue = $basicItemsValue + $basicItemValue;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value->fk_item_name; ?></td>
                <td style="text-align:right;"><?php echo $value->case_unit; ?></td>
                <td style="text-align:right;"><?php echo $value->quantity; ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp_value, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value->discount, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($basicItemValue, 2); ?></td>
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
                <td style="text-align:right;"><hr><b><?php echo number_format($basicItemsValue, 2); ?></b></td>
                <td style="text-align:right;"><hr><b><?php echo number_format($bill_value, 2); ?></b></td>
            </tr>
            <?php 
                $basicValue = round((($bill_value * 100) / 118), 2);
                $cgstValue = round((($basicValue * 9) / 100), 2);
                $total_cgst_value = $basicValue + $cgstValue;
                $sgstValue = $cgstValue;
                $total_cgst_sgst_value = ($total_cgst_value + $sgstValue);
                $bill_amount = round($total_cgst_sgst_value, 0);
                $round_off = round(($bill_amount - $total_cgst_sgst_value), 2);
            ?>


            <tr style="border-right-style:none;">
                <td colspan="5" rowspan="6" ></td>
                <td colspan="3">BASIC VALUE RS.</td>
                <td style="text-align:right;"><?php echo number_format($basicValue, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3">CGST 9.00%</td>
                <td style="text-align:right;"><?php echo number_format($cgstValue, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3">SGST 9.00%</td>
                <td style="text-align:right;"><?php echo number_format($sgstValue, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3">TOTAL RS.</td>
                <td style="text-align:right;"><?php echo number_format($total_cgst_sgst_value, 2); ?></td>
            </tr>
            <tr>
                <td colspan="3">ROUND OFF</td>
                <td style="text-align:right;"><?php echo $round_off; ?></td>
            </tr>
            <tr>
                <td colspan="3"><b>BILL AMOUNT RS.</b></td>
                <td style="text-align:right;"><b><?php echo number_format($bill_amount, 2); ?></b></td>
            </tr>
    <tbody>
</table>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
    <spna style="font:10px;">RS. (IN WORDS) : <?php echo ucwords(getIndianCurrency($bill_amount));?> </span>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
    <spna style="font:10px;">HSN CODE: ICE CREAM (2015) & FROZEN DESSERT (2015) & ICE CANDEY (2015)</span>
    <div style="margin-top:10px; height: 60px;">
        <div style="width:50%; height: 60px; float:left;">
            <span style="font:8px;">NOTE :-</span><br>
            <span style="font:6px;">1. GOOD ONCE SOLD WILL NOT BE TAKEN BACK OR EXCHANGED.</span><br>
            <span style="font:6px;">2. SELLER IS NOT RESPONSIBLE FOR ANY LOSS OR DAMAGE OF GOODS IN TRANSIT.</span><br>
            <span style="font:6px;">3. DISPUTE OF ANY CASE WILL BE SUBJECT TO BIHAR SHARIF JURISDICTION.</span><br>
            <span style="font:6px;">4. THIS IS A COMPUTER GENERATED INVOICE.</span><br>
        </div>
        <div style="width:50%; height: 60px; float:right;">
            <center>
                <span style="font:12px; margin:20px;">For <?php echo $invoicetitle;?></span><br><br>
                <span style="font:12px;">AUTHORIZED SIGNATORY</span>
            </center>
        </div>
    </div>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
    <div style="margin-top:2px; height: 10px;">
        <div style="width:33%; height: 10px; float:left;">
        IN TIME : 
        </div>
        <div style="width:33%; height: 10px; float:left;">
        OUT TIME : 
        </div>
        <div style="width:33%; height: 10px; float:left;">
        RECEIVER'S SIGNATURE
        </div>
    </div>

</body>
</html>