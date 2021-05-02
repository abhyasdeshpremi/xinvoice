<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF from View in CodeIgniter Example</title>
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
<body style="width:50%; border-right: 1px dotted black;" >
    <center>
        <span style="font:12px;">TAX INVOICE</span><br>
        <span style="font:14px; font-style:bold;">SATYAM ENTERPRISES</span><br>
        <span style="font:12px;">NEAR KST COLLEGE, SALEMPUR, BIHAR SHARIF</span><br>
        <span style="font:12px;">NALANDA, BIHAR - 803108</span><br>
    </center>
    <span style="font:8px; float:left; margin-left:10px;">GSTIN : 10ARFPK1062N1Z1</span>
    <span style="font:8px; float:right; margin-right:10px;">MOB.NO.: 9098773922<br>ORIGINAL FOR RECIPIENT</span>
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
                    <span>INVOICE NO. : <?php echo $invoicepkid; ?> / 21-22</span><br>
                    <span>DATE : <?php echo $created_at; ?></span><br>
                    <span>PAYMENT MODE : <?php echo $paymentmode; ?></span><br>
                    <span>VAHICLE NO. : <?php echo $vehicleno; ?></span><br>
                    <span>PAN NO. : <?php echo $pannumber; ?></span>
            </div>
        </div>
    <hr style="text-align:left;margin-left:0; margin-right:10px;">
<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:9px;">
    <thead >
        <tr>
            <th>SNO.</th>
            <th width="70px;">Item Code</th>
            <th width="140px;">Name</th>
            <th >C/S</th>
            <th >QTY</th>
            <th>MRP</th>
            <th width="50px;">MRP VAL</th>
            <th>DS%</th>
            <th>Bill Value</th>
        </tr>
    </thead>
    <tbody>
        <?php   $i = 1;
                $mrp_value = 0;
                $bill_value = 0;
        foreach($invoiceitemsList as $value){
            $mrp_value = $mrp_value + $value->mrp_value;
            $bill_value = $bill_value + $value->bill_value;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value->fk_item_code; ?></td>
                <td><?php echo $value->fk_item_name; ?></td>
                <td>20</td>
                <td><?php echo $value->quantity; ?></td>
                <td><?php echo $value->mrp; ?></td>
                <td><?php echo $value->mrp_value; ?></td>
                <td><?php echo $value->discount; ?></td>
                <td><?php echo $value->bill_value; ?></td>
            </tr>
        <?php $i++; } ?>
            <tr>
                <td colspan="6"></td>
                <td><hr><b><?php echo $mrp_value; ?></b></td>
                <td></td>
                <td><hr><b><?php echo $bill_value; ?></b></td>
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
                <td colspan="5" rowspan="7" ></td>
                <td colspan="3">BASIC VALUE RS.</td>
                <td><?php echo $basicValue; ?></td>
            </tr>
            <tr>
                <td colspan="3">CGST 9.00%</td>
                <td><?php echo $cgstValue; ?></td>
            </tr>
            <tr>
                <td colspan="3">SGST 9.00%</td>
                <td><?php echo $sgstValue; ?></td>
            </tr>
            <tr>
                <td colspan="3">TOTAL RS.</td>
                <td><?php echo $total_cgst_sgst_value; ?></td>
            </tr>
            <tr>
                <td colspan="3">ROUND OFF</td>
                <td><?php echo $round_off; ?></td>
            </tr>
            <tr>
                <td colspan="3"><b>BILL AMOUNT RS.</b></td>
                <td><b><?php echo $bill_amount; ?></b></td>
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
                <span style="font:12px; margin:20px;">For SATYAM ENTERPRISES</span><br><br>
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