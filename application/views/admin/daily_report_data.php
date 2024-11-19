
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $compdata->comp_name; ?> |DAILY REPORT
 </title>
</head>
<body>

<div id="container">
  <style>
    .display{
      display: flex;
      
    }
  </style>
     <style>
             .c {
               text-transform: uppercase;
               }
                
      </style>
<table  style="border: none">
<tr style="border: none">
<td style="border: none">


<div style="width: 20%;">
<img src="<?php echo base_url().'assets/img/'.$compdata->comp_logo ?>" style="width: 100px;height: 80px;">
</div> 

</td>
<td style="border: none">
<div class="pull">
<p style="font-size:14px;" class="c"><b> <?php echo $compdata->comp_name; ?></b><br>
<b><?php echo $compdata->adress; ?></b> <br>
<?php $day = date("d-m-Y"); ?>
</p>
<p style="font-size:12px;text-align:center;" class="c">ALL BRANCH - MAUZO YA SIKU </p>
 <p style="font-size:12px;text-align:center;" class="c"> From: <?php echo $from; ?> - To: <?php echo $to; ?></p>
 </div>
</td>
</tr>
</table>

    
 
  <div id="body">
  <style> 
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 1px;
}

tr:nth-child(even) {
  background-color: #dddddd ;
}

</style>
</head>
<body>
 <hr>

                                    <table>
                                    <thead>
                                        <tr>    
                                                <th>S/no.</th>
                                                <th>Tawi</th>
                                                <th>Gawa</th>
                                                <th>Fomu</th>
                                                <th>Code No</th>
                                                <th>Lipisha</th>
                                                <th>Faini</th>
                                                <th>Stoo</th>
                                                <th>Miamala Hewa</th>
                                                
                                        </tr>

                                    </thead>
                              
                                        <?php $no =1; ?>
                            <?php foreach ($blanch_rec as $blanch_recs): ?>
                                    <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td class="c"><?php echo $blanch_recs->blanch_name ?></td>
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    <td></td>                                                       
                                    </tr>
                                    <?php $blanch_out = $this->queries->get_today_deposit_blanch_prev($blanch_recs->blanch_id,$from,$to);
                                    // echo "<pre>";
                                    // print_r($blanch_out);
                                    //           exit();
                                     ?>
                                    <?php foreach ($blanch_out as $blanch_outs): ?>  
                                    <tr>
                                    <td><?php //echo $no++; ?></td>
                                    <td class="c"><?php //echo $blanch_recs->blanch_name ?></td>
                                    <td><?php echo number_format($blanch_outs->total_gawa); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->total_fomu); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->code_no); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->total_lipisha); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->total_faini); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->total_stoo); ?></td>                                                       
                                    <td><?php echo number_format($blanch_outs->total_miamala); ?></td>                                                       
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                   
                                    <tr>
                                        <td><b>JUMLA:</b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($total_code_no->total_with); ?></b></td>
                                        <td><b><?php echo number_format($deducted_fee->total_deducted); ?></b></td>
                                        <td><b><?php echo  number_format($total_code_no->total_interest); ?></b></td>
                                        <td><b><?php echo number_format($total_code_no->total_depost); ?></b></td>
                                        <td><b><?php echo number_format($penart_paid->total_penart); ?></b></td>
                                        <td><b><?php echo number_format($total_stoo->total_stoo_paid); ?></b></td>
                                        <td><b><?php echo number_format($total_miamala->total_miamala); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>MUHTASALI WA KULIPISHA</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                     <?php  foreach($account_deposit as $account_deposits): ?>  
                                     <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo $account_deposits->account_name; ?></b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($account_deposits->total_deposit_acc); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>JUMLA YA MADENI SUGU</b></td>
                                        <td></td>
                                        <td><b><?php echo $toyal_default->total_default; ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>JUMLA YA MIAMALA HEWA</b></td>
                                        <td></td>
                                        <td><b><?php echo $total_miamala->total_miamala; ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>MUHTASALI WA GAWA</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php foreach ($withdrawal_account as $withdrawal_accounts): ?>
                                     <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo $withdrawal_accounts->account_name; ?></b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($withdrawal_accounts->total_with_acc); ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>JUMLA YA CODE NO</b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($total_code_no->total_interest); ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>JUMLA YA FOMU</b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($deducted_fee->total_deducted); ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>JUMLA YA FAINI</b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($penart_paid->total_penart); ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>

  </div>

</div>

</body>
</html>




