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
        <span style="font:12px; text-transform: uppercase;">Party Ledger Report</span><br>
        <span style="font:14px; font-style:bold; text-transform: uppercase;"><?php echo isset($title) ? $title : '';?></span><br>
        <span style="font:10px; text-transform: uppercase;">Date From:- <?php echo date("d-m-Y", strtotime($start_date)); ?> To:- <?php echo date("d-m-Y", strtotime($end_date)); ?></span><br><br>
    <br>  
    </center>
    <p>NAME: <b><?php echo $result[0]["fk_client_name"]; ?></b>, &nbsp; DISTRICT: <?php echo $result[0]["district"]; ?></p>
<table class="table table-bordered" id="dataTable" cellspacing="0" style="font:14px;" width="99%">
<thead >
    <tr>
        <th width="8px;">#</th>
        <th width="90px;" style="text-align:left;">DATE</th>
        <th>NOTES</th>
        <th width="80px;" style="text-align:right;">DEBIT</th>
        <th width="80px;" style="text-align:right;">CREDIT</th>
        <th width="100px;" style="text-align:right;">BALANCE</th>
    </tr>
</thead>
<tbody>
    
    <?php  $i = 1;
    foreach($result as $value){ 
        $result_account_history = $value["accounthistory"];
        $opening_balance = $value["opening_balace_value"];
        $symbol = "CR";
        if($opening_balance < 0){
            $symbol = "DR";
            $tmpopening_balance = -($opening_balance);
        }
    ?>
        <tr>
            <td>1</td>
            <td></td>
            <td>OPENING BALANCE</td>
            <td></td>
            <td></td>
            <td style="text-align:right;"><b><?php echo number_format($tmpopening_balance, 2); echo " ".$symbol;?></b></td>
        </tr>

        <?php $j = 2;
            foreach($result_account_history as $history){ 
                $paymenttype = $history->payment_type;
                $amount = $history->amount;
                $creditAmount = '';
                $debitAmount = '';
                if($paymenttype === "debit"){
                    $debitAmount = floatval($amount);
                    $opening_balance = floatval($opening_balance) - floatval($amount);
                }else if($paymenttype === "credit"){
                    $creditAmount = floatval($amount);
                    $opening_balance = floatval($opening_balance) + floatval($amount);
                } 
                $symbol = "CR";
                if($opening_balance < 0){
                    $symbol = "DR";
                    $tmpopening_balance = -($opening_balance);
                }
                ?>

                <tr>
                    <td><?php echo $j; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($history->payment_date)); ?></td>
                    <td><?php echo $history->notes; ?></td>
                    <td style="text-align:right;"><?php echo $debitAmount; ?></td>
                    <td style="text-align:right;"><?php echo $creditAmount; ?></td>
                    <td style="text-align:right;"><b><?php echo number_format($tmpopening_balance, 2); echo " ".$symbol;?></b></td>
                </tr>
        <?php $j++; } ?>

    <?php $i++; } ?>

<tbody>
</table>

</body>
</html>