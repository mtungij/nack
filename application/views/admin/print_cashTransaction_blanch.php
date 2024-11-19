
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $compdata->comp_name; ?> | CASH TRANSACTION REPORT</title>
</head>
<body>

<div id="container">
<div style='width: 100%;align-items: center; display: flex;justify-content:space-between;flex-direction: row;'>
</div>
<style>
.pull{
text-align: center;
/*  margin-top: 100px;
margin-bottom: 0px;
margin-right: 150px;
margin-left: 80px;*/

}
</style>
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

<!-- <div class="pull">
<img src="<?php //echo base_url().'assets/img/'.$compdata->comp_logo ?>" style="width: 50px;height: 50px;">
<p style="font-size:14px;" class="c"> <?php //echo $compdata->comp_name; ?><br>
<?php //echo $compdata->adress; ?> <br>
<?php //$day = date("d-m-Y"); ?>
</p>
<p style="font-size:12px;">BRANCH LIST</p>
</div>  -->


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
<?php if ($blanch_data == FALSE) {
 ?>
 <p style="font-size:12px;text-align:center;" class="c">ALL BRANCH -EXPENSES REPORT From: <?php echo $from; ?> To: <?php echo $to; ?></p>
<?php }else{ ?>
<p style="font-size:12px;text-align:center;" class="c"><?php echo $blanch_data->blanch_name ?> -CASH TRANSACTION REPORT From: <?php echo $from; ?> To: <?php echo $to; ?></p>
<?php } ?>
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
padding: 2px;
}

tr:nth-child(even) {
background-color: ;
}

</style>
</head>
<body>

<hr>



<table>
                                         <thead>
                                              <tr>
                                        <th style="border: none; font-size: 12px;" class="c">S/No.</th>
                                        <th style="border: none; font-size: 12px;" class="c">Tawi</th>
                                        <th style="border: none; font-size: 12px;" class="c">Afisa</th>
                                        <th style="border: none; font-size: 12px;" class="c">Jina la Mteja</th>
                                        <th style="border: none; font-size: 12px;" class="c">Nambari Ya Simu</th>
                                        <th style="border: none; font-size: 12px;" class="c">Lipisha</th>
                                        <th style="border: none; font-size: 12px;" class="c">Akaunti Iliyo Lipisha</th>
                                        <th style="border: none; font-size: 12px;" class="c">Gawa</th>
                                        <th style="border: none; font-size: 12px;" class="c">Akaunti Iliyo Gawa</th>
                                        <!-- <th>Fomu</th>
                                        <th>Faini</th> -->
                                        <th style="border: none; font-size: 12px;">Tarehe</th>
                                        <th style="border: none; font-size: 12px;">Tarehe & Muda</th>     
                                                    
                                                 </tr>
                                        </thead>
                                                 <?php $no = 1; ?>
                                    <?php foreach ($cash as $cashs): ?>
                                              <tr>

                                    <td style="border:none; font-size: 12px;"><?php echo $no++; ?>.</td>
                                    <td style="border:none; font-size: 12px;" class="c"><?php echo $cashs->blanch_name; ?></td>
                                    <td style="border:none; font-size: 12px;"><?php echo $cashs->empl_name; ?></td>
                                    <td style="border: none; font-size: 12px;"><?php echo $cashs->f_name; ?> <?php echo $cashs->m_name; ?> <?php echo $cashs->l_name; ?></td> style="border:none; font-size: 12px;"
                                    <td style="border:none; font-size: 12px;"><?php echo $cashs->phone_no; ?></td>
                                    <td style="border:none; font-size: 12px;">    <?php if ($cashs->depost == TRUE) {
                                         ?>
                                        <?php echo number_format($cashs->depost); ?>
                                    <?php }elseif ($cashs->depost == FALSE) {
                                     ?>
                                     -
                                     <?php } ?></td>
                                     <td style="border:none; font-size: 12px;">
                                        <?php if ($cashs->deposit_account == TRUE) {
                                         ?>
                                        <?php echo $cashs->deposit_account; ?>
                                    <?php }else{ ?>
                                        -
                                        <?php } ?>
                                            
                                        </td>
                                    <td style="border:none; font-size: 12px;">
                                        <?php if ($cashs->withdraw == TRUE) {
                                         ?>
                                        <?php echo number_format($cashs->loan_aprov); ?>
                                    <?php }elseif ($cashs->withdraw == FALSE) {
                                     ?>
                                     -
                                     <?php } ?>
                                    </td>
                                    <td style="border:none; font-size: 12px;">
                                        <?php if ($cashs->withdrawal_account == TRUE) {
                                         ?>
                                        <?php echo $cashs->withdrawal_account; ?>
                                    <?php }else{ ?>
                                        -
                                        <?php } ?>
                                            
                                        </td>
                                    <td style="border:none; font-size: 12px;"><?php echo $cashs->lecod_day; ?></td>
                                    <td style="border:none; font-size: 12px;"><?php echo $cashs->time_rec; ?></td>
                                     </tr>
    
                                     <?php endforeach; ?>
                                   <tr>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"><b><?php echo number_format($total_comp_data->total_depost_com ); ?></b></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"><b><?php echo number_format($total_comp_data->total_comp_aprov); ?></b></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                       <td style="border:none; font-size:12px;"></td>
                                     
                                   </tr>


                                   <tr>
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;">MUHTASALI WA KULIPISHA</td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                       <td style="border:none; font-size: 12px;"></td> 
                                    </tr>
                                   <?php foreach ($account_deposit as $account_deposits): ?>
                                    <tr>
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"><b><?php echo $account_deposits->account_name; ?></b></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"><b><?php echo number_format($account_deposits->total_deposit_acc); ?></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                       <td style="border:none; font-size:12px;"></td> 
                                    </tr>
                                     <?php endforeach; ?>
                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>MADENI SUGU</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                          <?php $no = 1; ?>
                                     <?php foreach ($default_list as $default_lists): ?>
                                       <tr>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"> </td>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"><?php echo $default_lists->f_name; ?> <?php echo $default_lists->m_name; ?> <?php echo $default_lists->l_name; ?></td>
                                         <td style="border:none; font-size:12px;"><?php echo $default_lists->blanch_name; ?></td>
                                         <td style="border:none; font-size:12px;"><?php echo number_format($default_lists->depost); ?></td>
                                         <td style="border:none; font-size:12px;"><?php echo $default_lists->account_name; ?></td>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"></td>
                                         <td style="border:none; font-size:12px;"></td>
                                     </tr>
                                      <?php endforeach ?>
                                      <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"> </td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;">JUMLA MADENI SUGU</td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($toyal_default->total_default); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>

                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"> </td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>MIAMALA HEWA</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php //echo number_format($toyal_default->total_default); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                    <?php foreach ($miamala as $miamalas): ?>
                                         <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><?php echo $miamalas->agent; ?></td>
                                         <td style="border:none;font-size: 12px;"><?php echo $miamalas->account_name; ?></td>
                                         <td style="border:none;font-size: 12px;"><?php echo number_format($miamalas->amount); ?></td>
                                         <td style="border:none;font-size: 12px;"><?php echo $miamalas->blanch_name; ?></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                     <?php endforeach; ?>

                                        <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA MIAMALA HEWA</b><?php //echo $miamalas->agent; ?></td>
                                         <td style="border:none;font-size: 12px;"><?php //echo $miamalas->account_name; ?></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($total_miamala->total_miamala); ?></b></td>
                                         <td style="border:none;font-size: 12px;"><?php //echo $miamalas->blanch_name; ?></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;">MUHTASALI WA GAWA</td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                    <?php foreach ($withdrawal_account as $withdrawal_accounts): ?>
                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo $withdrawal_accounts->account_name; ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($withdrawal_accounts->total_with_acc); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                     <?php endforeach; ?>

                                      <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA CODE NO</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($total_code_no->total_interest); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>
                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA FOMU</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($deducted_fee->total_deducted); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>

                                     <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA FAINI</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($penart_paid->total_penart); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>


                                        <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA WATEJA WALIO LIPA HAI</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($hai_wateja->total_hai); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>

                                        <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA WATEJA WALIO LIPA SUGU</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($sugu_wateja->total_sugu); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>

                                     
                                        <tr>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b>JUMLA YA MAUZO</b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"><b><?php echo number_format($total_comp_data->total_depost_com + $total_miamala->total_miamala); ?></b></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                         <td style="border:none;font-size: 12px;"></td>
                                     </tr>

                                    
                                      
            
                                       
                   
                   </table>
</div>

</div>

</body>
</html>




