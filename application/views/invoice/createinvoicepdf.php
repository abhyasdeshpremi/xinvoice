<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Invoice:- <?php echo isset($invoicetitle) ? $invoicetitle : ''; ?></title>
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
 $width = "width : 50%; border-right: 1px dotted black;";
if(isset($mode)){
   if($mode === "portrait"){
        $width = "width : 100%;";
   }
} 
$globalInvoice_bill_include_tax = $this->session->userdata('bill_include_tax');
$invoiceTitle = "TAX INVOICE";
if($globalInvoice_bill_include_tax == 'no'){
    $invoiceTitle = "RETAIL INVOICE";
}
$font_style = 'style="font:10px;"';
$font_style_mob = 'style="font:10px;"';
if($paper_size == 'A5'){
    $font_style = 'style="font:12px;"';
    $font_style_mob = 'style="font:11px;"';
}
?>
<body style="<?php echo $width; ?>" >
    <center>
        <span style="font:12px;"><?php echo $invoiceTitle; ?></span><br>
        <span style="font:16px; font-style:bold;"><?php echo isset($invoicetitle) ? $invoicetitle : '';?></span><br>
        <span style="font:10px;"><?php echo $invoicesubtitle;?></span><br><br>
    </center>
    <span style="font:10px; float:left;">GSTIN : <b><?php echo isset($owninvoicegstin) ? $owninvoicegstin : ''; ?></b></span>
    <span style="font:10px; float:right; margin-right:10px;">ORIGINAL FOR RECIPIENT</span>
    <center style="margin-right:0px;">
        <span style="font:10px; margin-right:0px;">MOB.NO.: <b><?php echo $owninvoicemobileno; echo $paper_size; ?></b></span>
    </center>
   
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
        <div style="height:64px; font: 9px;">
            <div style="width:50%; height: 64px; float:left;"> To,
                <div style="margin-right:10px;">
                    <span style="font:10px;"><b><?php echo $clientname; ?></b></span><br>
                    <span><?php echo $clintaddress; ?></span><br>
                    <span><?php echo $clientcity." ".$clientarea; ?></span><br>
                    <span><?php echo $clientDistrict. " ".$clientpincode; ?></span><br>
                    <span>GSTIN : <?php echo $gstin; ?></span>
                </div>
            </div>
            <div style="width:50%; height: 64px; float:right;"> 
                    <span>INVOICE NO. &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; : <span <?php echo $font_style; ?>><b><?php echo $invoicerefNumber; ?> / <?php echo financial_year($created_at); ?></b></span></span><br>
                    <span>DATE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <span style="font:10px;"><b><?php echo date("d-m-Y H:i", strtotime($created_at)); ?></b></span></span><br>
                    <span>PAYMENT MODE &nbsp;&nbsp;: <?php echo $paymentmode; ?></span><br>
                    <span>VAHICLE NO. &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $vehicleno; ?></span><br>
                    <span>PAN NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $pannumber; ?></span><br>
                    <span>MOB NO. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; : <span <?php echo $font_style_mob; ?>><b><?php echo $mobilenumber; ?></b></span></span>
            </div>
        </div>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:11px;" width="99%">
    <thead >
        <tr>
            <th width="8px;">SN</th>
            <th width="190px;">Name</th>
            <th style="text-align:right;">C/S</th>
            <th style="text-align:right;" >QTY</th>
            <th style="text-align:right;">MRP</th>
            <th style="text-align:right;" width="50px;">MRP VAL</th>
            <th style="text-align:right;">DS%</th>
            <?php if($globalInvoice_bill_include_tax == 'yes'){ ?> <th style="text-align:right;">Bas. Val</th> <?php } ?>
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
            $bill_value = $bill_value + round((double)$value->bill_value, 2);
            $qty_value = $qty_value + (int)$value->quantity;
            $case_unit_value = $case_unit_value + (float)$value->case_unit;
            $basicItemValue = round((($value->bill_value * 100) / 118), 2);
            $basicItemsValue = $basicItemsValue + $basicItemValue;
            $discount_num = number_format( (int)(isset($value->discount) ? $value->discount : 0), 2);
            ?>
            <tr>
                <td style="text-align:initial;"><?php echo $i; ?></td>
                <td><?php echo $value->fk_item_name; ?></td>
                <td style="text-align:right;"><b><?php echo $value->case_unit; ?></b></td>
                <td style="text-align:right;"><?php echo $value->quantity; ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp, 2); ?></td>
                <td style="text-align:right;"><?php echo number_format($value->mrp_value, 2); ?></td>
                <td style="text-align:right;"><?php echo $discount_num; ?></td>
                <?php if($globalInvoice_bill_include_tax == 'yes'){ ?> <td style="text-align:right;"><?php echo number_format($basicItemValue, 2); ?></td> <?php } ?>
                <td style="text-align:right;"><b><?php echo number_format($value->bill_value, 2); ?></b></td>
            </tr>
        <?php $i++; } ?>
            <tr>
                <td colspan="2"></td>
                <td style="text-align:right;"><hr><b><?php echo $case_unit_value; ?></b></td>
                <td style="text-align:right;"><hr><b><?php echo $qty_value; ?></b></td>
                <td></td>
                <td style="text-align:right;"><hr><b><?php echo number_format($mrp_value, 2); ?></b></td>
                <td></td>
                <?php if($globalInvoice_bill_include_tax == 'yes'){ ?><td style="text-align:right;"><hr><b><?php echo number_format($basicItemsValue, 2); ?></b></td> <?php } ?>
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

                

                $bill_amout = round($bill_value);
                $savingAmount = number_format(($mrp_value - $bill_amout), 2);
                $round_off_without_gst = round(($bill_amout - $bill_value), 2);
                
                $bonusString = '';
                if(isset($bonus_percent)){
                    if($bonus_percent > 0){
                        $percentage_value = round(($mrp_value * $bonus_percent) / 100);
                        if($percentage_value > 0){
                            $bonusString = "BONUS AMOUNT: " .number_format($percentage_value, 2);
                        }
                    }
                }
            ?>

            <?php if($globalInvoice_bill_include_tax == 'yes'){ ?>
            <tr style="border-right-style:none;">
                <td colspan="5" rowspan="6" ></td>
                <td colspan="3">BASIC VALUE RS.</td>
                <td style="text-align:right;"><?php echo $basic_value; ?></td>
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
            <?php } else { ?>
                <tr style="border-right-style:none;">
                    <td colspan="6" ></td>
                    <td>ROUND OFF</td>
                    <td style="text-align:right;"><?php echo $round_off_without_gst; ?></td>
                </tr>
                <tr style="border-right-style:none; font:13px;">
                    <td colspan="6" > <center><b>TOTAL SAVING: <?php echo $savingAmount; ?> &nbsp;&nbsp; <?php echo $bonusString; ?></b></center></td>
                    <td><b>BILL AMOUNT</b></td>
                    <td style="text-align:right;"><b> <?php echo number_format($bill_amout, 2); ?></b></td>
                </tr>
            <?php } ?>

    <tbody>
</table>
    <hr style="text-align:left;margin-left:0; margin-right:12px;">
    <spna style="font:12px;">RS. (IN WORDS) : <?php echo ucwords(getIndianCurrency($bill_amount));?> </span>
    <hr style="text-align:left;margin-left:0; margin-right:12px;">
    <spna style="font:10px;"><?php echo $this->session->userdata('tc_title'); ?></span>
    <div style="margin-top:10px; height: 60px;">
        <div style="width:50%; height: 60px; float:left;">
            <span style="font:10px;"><?php echo ($this->session->userdata('line1')) ? 'Term & Conditions :-': ''; ?></span><br>
            <span style="font:8px;"><?php echo ($this->session->userdata('line1')) ? '1. '.$this->session->userdata('line1') : ''; ?></span><br>
            <span style="font:8px;"><?php echo ($this->session->userdata('line2')) ? '2. '.$this->session->userdata('line2') : ''; ?></span><br>
            <span style="font:8px;"><?php echo ($this->session->userdata('line3')) ? '3. '.$this->session->userdata('line3') : ''; ?></span><br>
            <span style="font:8px;"><?php echo ($this->session->userdata('line4')) ? '4. '.$this->session->userdata('line4') : ''; ?></span><br>
        </div>
        <div style="width:50%; height: 60px; float:right;">
            <center>
                <span style="font:12px; margin:20px;">For <?php echo $invoicetitle;?></span><br><br><br>
                <span style="font:12px;">AUTHORIZED SIGNATORY</span>
            </center>
        </div>
    </div>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
    <div style="margin-top:10px; height: 10px;">
        <div style="width:33%; height: 10px; float:left;">
        RECEIVER'S SIGNATURE
        </div>
        <div style="width:33%; height: 10px; float:left;">
        IN TIME : 
        </div>
        <div style="width:33%; height: 10px; float:left;">
        OUT TIME : 
        </div>
    </div>

</body>
</html>