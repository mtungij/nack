
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $compdata->comp_name; ?> | DEFAULT LOAN REPORT
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
<p style="font-size:12px;text-align:center;" class="c">DEFAULT LOAN REPORT</p>
<p style="font-size:12px;text-align:center;" class="c">
  <?php if ($blanch_id == 'all') {
   echo "ALL BRANCH";
  }else{ ?>
  <?php echo $blanch_data->blanch_name ?>
  <?php } ?> 
    
  </p>
<p style="font-size:12px;text-align:center;" class="c"> From: <?php echo $from; ?> -  To: <?php echo $to; ?></p>
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
  padding: 5px;
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
    <th style="font-size:13px;border: none;">S/No.</th>
     <th style="font-size:13px;border: none;">Branch</th>
     <th style="font-size:13px;border: none;">Customer</th>
    <th style="font-size:13px;border: none;">Employee</th>
    <th style="font-size:13px;border: none;">Loan Ac</th>
    <th style="font-size:13px;border: none;">Loan Product</th>
    <th style="font-size:13px;border: none;">Loan Interest</th>
    <th style="font-size:13px;border: none;">Loan Withdrawal</th>
    <th style="font-size:13px;border: none;">Principal + interest</th>
    <th style="font-size:13px;border: none;">Method</th>
    <th style="font-size:13px;border: none;">Duration Type</th>
    <th style="font-size:13px;border: none;">Number of Repayment</th>
    <th style="font-size:13px;border: none;">Remain Debt</th>
    <th style="font-size:13px;border: none;">Withdrawal Date</th>
    <th style="font-size:13px;border: none;">End Date</th>

  </tr>
  </thead>

   <?php $no = 1; ?>
  
  <?php foreach ($default_blanch as $loan_aproveds):
   ?>
 <tr>
    <td style="font-size:13px;border: none;" class="c"><?php echo $no++; ?>.</td>
    <td style="font-size:13px;border: none;" class="c"><?php echo $loan_aproveds->blanch_name; ?></td>
    
    <td style="font-size:13px;border: none;" class="c">
      <?php echo $loan_aproveds->f_name; ?> <?php echo substr($loan_aproveds->m_name, 0,1); ?> <?php echo $loan_aproveds->l_name; ?> 
      </td>
      <td style="font-size:13px;border: none;" class="c">
      <?php echo $loan_aproveds->empl_name; ?>
      </td>
      <td style="font-size:13px;border: none;" class="c">
      <?php echo $loan_aproveds->loan_code; ?>
      </td>
    <td style="font-size:13px;border: none;" class="c"><?php echo $loan_aproveds->loan_name ?></td>
    <td style="font-size:13px;border: none;" class="c"><?php echo $loan_aproveds->interest_formular; ?>%</td>
    <td style="font-size:13px;border: none;" class="c">
      <?php echo number_format($loan_aproveds->loan_aprove); ?>
                                              
      </td>

    <td style="font-size:13px;border: none;">
      <?php echo number_format($loan_aproveds->loan_int); ?>
        
      </td>
    
    
    <td style="font-size:13px;border: none;">
      <?php echo $loan_aproveds->account_name; ?>
    </td>
    <td style="font-size:13px;border: none;">
    <?php if ($loan_aproveds->day == 1) {
                                                 echo "Daily";
                                             ?>
                                            <?php }elseif($loan_aproveds->day == 7){
                                                  echo "Weekly";
                                             ?>
                                            
                                        <?php }elseif($loan_aproveds->day == 30 || $loan_aproveds->day == 31 || $loan_aproveds->day == 29 || $loan_aproveds->day == 28){
                                                echo "Monthly"; 
                                            ?>
                                            <?php } ?>
    </td>
    <td style="font-size:13px;border: none;">
      <?php echo $loan_aproveds->session; ?>
    </td>
    <td style="font-size:13px;border: none;"><?php echo number_format($loan_aproveds->remain_amount); ?></td>
    <td style="font-size:13px;border: none;"><?php echo $loan_aproveds->loan_stat_date; ?></td>
    <td style="font-size:13px;border: none;"><?php echo substr($loan_aproveds->loan_end_date, 0,10); ?></td>
    
  </tr>
 <?php endforeach; ?>
 <tr>
    
    <td style="font-size:12px;border: none;" class="c"><b>TOTAL</b></td>
    <td style="font-size:13px;border: none;" class="c"><b></b></td>
    <td style="font-size:12px;border: none;" class="c">
       
      </td>
      <td style="font-size:12px;border: none;" class="c">
       
      </td>
    <td style="font-size:12px;border: none;" class="c"><b><?php //echo number_format($total_disburse->total_loan); ?></b></td>
   <!--  <td style="font-size:12px;border: none;"><?php //echo $customers->date_birth; ?></td> -->
    <td style="font-size:12px;border: none;"><b><?php //echo number_format($total_repayment->principal); ?></b></td>
    <td style="font-size:12px;border: none;"><b><?php //echo number_format($total_repayment->loan_interest); ?></b></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->region_name; ?></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->district; ?></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->ward; ?></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->ward; ?></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->ward; ?></td>
    <td style="font-size:12px;border: none;"><b><?php echo number_format($total_blanch->total_remain); ?></b></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->ward; ?></td>
    <td style="font-size:12px;border: none;"><?php //echo $customers->ward; ?></td>
  </tr>

</table>

  </div>

</div>

</body>
</html>




