<?php include('incs/header.php'); ?>
<?php include('incs/nav.php'); ?>
<?php include('incs/side.php'); ?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url("oficer/index"); ?>"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Report</li>
                            <li class="breadcrumb-item active">Daily Report</li>
                        </ul>
                    </div>            
                 
                </div>
            </div>
                  <?php if ($das = $this->session->flashdata('massage')): ?> 
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="alert alert-dismisible alert-success"> <a href="" class="close">&times;</a> 
                                    <?php echo $das;?> </div> 
                            </div> 
                        </div> 
                    <?php endif; ?>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                         <div class="header">
                            <?php $date = date("Y-m-d"); ?>
                            <h2>Ripoti ya Siku / FROM:<?php echo $from; ?> To:<?php echo $to; ?> </h2> 
                            <div class="pull-right">
                               <a href="" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"
                                            data-toggle="modal" data-target="#addcontact1" data-original-title="Edit"><i class="icon-calendar"></i><?php echo $this->lang->line("search_menu"); ?></a>     
                              <a href="<?php echo base_url("oficer/print_daily_report_data"); ?>" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"
                                           data-original-title="print" target="_blank"><i class="icon-printer"></i>Chapisha</a> 
                            </div>   
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover j-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>    <!-- <th>Branch Name</th> -->
                                                <th>Maelezo</th>
                                                <th>Kiasi</th>
                                        </tr>

                                    </thead>
                                   
                                    <tbody>
                                    <tr>
                                   <?php   
                               $float_tranaction = $this->queries->get_transaction_prev_blanch($blanch_id,$from,$to);
                               $float_trans = $float_tranaction->total_transfor;
                               $float_chager = $float_tranaction->total_charger;
                               //print_r($float_trans);

                                    ?>
                                    <td>ONGEZEKO KUTOKA AKAUNTI KUU</td>
                                    
                                    <td><?php echo number_format($float_trans + $float_chager); ?></td>                                                       
                                    </tr>
                                     <tr>

                                <?php 
                                $fomu_fine = $this->queries->get_transaction_income_prevBlanch($blanch_id,$from,$to);
                                $fomu_total = $fomu_fine->total_fomu_fine; 
                                $total_incomeFee = $fomu_fine->total_incomeFee; 
                                //print_r($total_incomeFee);
                                 ?>
                                    <td>ONGEZEKO KUTOKA FOMU & FAINI</td>
                                    
                                    <td><?php echo number_format($fomu_total + $total_incomeFee); ?></td>                                                     
                                    </tr>
                                   <!--  <tr>
                                    <td>ONGEZEKO KUTOKA MADENI SUGU NDANI YA MFUMO</td>
                                    <td>
                                        <?php //echo number_format(@$total_kopesha_in->total_trans_in); ?>/ Makato(<?php //echo number_format(@$total_kopesha_in->total_fee_in); ?>)
                                    </td>
                                     </tr> --> 
                                     <tr>
                                        <?php 
                                  $out_system = $this->queries->get_transaction_outSystem_prev($blanch_id,$from,$to);
                                  //print_r($out_system);
                                         ?>
                                    <td>ONGEZEKO KUTOKA MADENI SUGU NJE YA MFUMO</td>
                                    <td><?php echo number_format($out_system->total_out + $out_system->out_fee) ?> / Makato(<?php echo number_format($out_system->out_fee); ?>)</td>
                                     </tr>                                                    
                                    

                                    <tr>
                                    <td>JANA</td>
                                    <?php 
                                    $jana = $this->queries->get_cash_inhand_prev_blanc($blanch_id,$from,$to);
                                    //print_r($jana);
                                     ?>
                                    <td><?php echo number_format(@$jana->total_cashInhand); ?></td>                                                       
                                    </tr>

                                     <tr>
                                 <?php 
                               $today_deposit = $this->queries->get_total_today_deposit($blanch_id);
                              
                                  ?>
                                    <td>LEO</td>
                                    <td><?php echo number_format(@$today_deposit->total_deposit); ?></td>                                                       
                                    </tr>
                                      <tr>
                                    <td>BAKI</td>
                                    <?php 
                                    $remain_deposit = $this->queries->get_total_today_deposit_loan($blanch_id);
                                     
                                     ?>
                                    <td><?php echo number_format(@$remain_deposit->total_restratio_today); ?></td>                                                       
                                    </tr>

                                     <tr>
                                    <td>JUMLA</td>
                                    
                                    <td><?php //echo number_format(@$cash_transaction->total_float + $income->total_transaction + @$yester_day_balance->cash_amount + $today_deposit->total_deposit + @$total_kopesha_in->total_trans_in + $total_kopesha_out->total_trans_out) ?></td> 
                                    <!-- <p>@$total_today_cash->today_cash</p>                                                       -->
                                    </tr>
                                        <tr>
                                    <td>GAWA</td>
                                    
                                    <td><?php //echo number_format(@$loan_with->total_loan_with); ?></td>                                                       
                                    </tr>
                                       <tr>
                                    <td>CODY NO</td>
                                    
                                    <td><?php //echo number_format(@$loan_with->total_loan_int - @$loan_with->total_loan_with); ?></td>                                                       
                                    </tr>
                                        <tr>
                                    <td>DOUBLE</td>
                                    
                                    <td><?php //echo number_format(@$prepaid->total_prepaid); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>STOO</td>
                                    
                                    <td><?php //echo number_format(@$stoo->total_stoo); ?></td>                                                      
                                    </tr>
                                    <?php //foreach ($acount as $acounts): ?>
                                    <tr>
                                    <td>LALA <?php //echo $acounts->account_name; ?></td>
                                    <td><?php //echo number_format($acounts->blanch_capital); ?></td>                                                       
                                    </tr>
                                    <?php //endforeach; ?>
                                    <tr>
                                    <td>MIAMALA HEWA</td>
                                    
                                    <td><?php //echo number_format(@$saving_deposit_remain->total_amount_saving); ?></td>                                                      
                                    </tr>
                                    <tr>
                                        <td><b>LALA JUMLA</b></td>
                                        <td><b><?php //echo number_format(@$total_today_cash->today_cash); ?></b></td>
                                    </tr>
                                     
                                     <tr>
                                      <td><div class="text-center"><b>FOMU & FAINI</b></div></td> 
                                      <td></td>      
                                     </tr>
                                      <tr>
                                          <td>JANA FOMU</td>
                                          <td><?php //echo number_format(@$prev_deduct->deduct_balance); ?></td>
                                      </tr>
                                      <tr>
                                          <td>JANA FAINI</td>
                                          <td><?php //echo number_format(@$prev_non->non_deduct_balance); ?></td>
                                      </tr>

                                     <tr>
                                    <td>JUMLA JANA FOMU & FAINI</td>
                                    <td><?php //echo number_format(@$yesterday_income->amount); ?></td>                                                       
                                    </tr>
                                    
                                    <tr>
                                        <td>LEO FOMU</td>
                                        <td><?php //echo number_format(@$today_deduct_income->total_deductedtoday); ?></td>
                                    </tr>
                                    <tr>
                                        <td>LEO FAINI</td>
                                        <td><?php //echo number_format(@$non_today); ?></td>
                                    </tr>
                                    <tr>
                                    <td>JUMLA LEO FOMU & FAINI</td>
                                    <td><?php //echo number_format(@$today_deduct_income->total_deductedtoday + @$non_today); ?></td>                                                       
                                    </tr>

                                    <tr>
                                    <td><b>JUMLA FOMU & FAINI</b></td>
                                    <td><b><?php //echo number_format(@$yesterday_income->amount + @$today_total_income); ?></b></td>                                                       
                                    </tr>

                                     <tr>
                                      <td><div class="text-center"><b>MATUMIZI</b></div></td> 
                                      <td></td>      
                                     </tr>
                                     <?php //if ($more_expenses): ?>
                                    <?php //foreach ($more_expenses as $more_expensess): ?>
                                    <tr>
                                    <td><?php //echo $more_expensess->ex_name; ?></td>
                                    <td><?php //echo number_format($more_expensess->total_expenses); ?></td>                                                   
                                    </tr>
                                     <?php //endforeach; ?>
                                 <?php //else: ?>
                                    <tr>
                                        <td style="color:red;">Hakuna Matumizi</td>
                                        <td style="color:red;">0.00</td>
                                    </tr>
                                     <?php //endif ?>

                                    <tr>
                                    <td>KOPESHA</td>
                                    <td><?php //echo number_format($today_transactionInc->total_incTrans) ?></td>                                                     
                                    </tr>

                                    <tr>
                                    <td><b>JUMLA YA MATUMZI</b></td>
                                    <td><b><?php //echo number_format($today_expenses->tota_expes + $today_transactionInc->total_incTrans); ?></b></td>                                                       
                                    </tr>

                                    <tr>
                                    <td><b>LALA FAINI & FOMU</b></td>
                                    <td><b><?php //echo number_format($inc_lala->total_incLala); ?></b></td>                                                       
                                    </tr>

                                     <tr>
                                      <td><div class="text-center"><b>WATEJA</b></div></td> 
                                      <td></td>      
                                     </tr>

                                    <tr>
                                    <td>JUMALA YA WATEJA</td>
                                    <?php //$blanch_id = $this->session->userdata('blanch_id'); ?>
                                    <?php //$customer = $this->db->query("SELECT * FROM tbl_customer WHERE blanch_id = '$blanch_id'"); ?>
                                    <td><?php //echo $customer->num_rows(); ?></td>                                                       
                                    </tr>

                                    <tr>
                                    <td>WATEJA HAI</td>
                                    <?php //$customer_active = $this->db->query("SELECT * FROM tbl_customer WHERE blanch_id = '$blanch_id' AND customer_status = 'open'"); ?>
                                    <td><?php //echo $customer_active->num_rows(); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>NJE YA MAKATABA</td>
                                    <?php //$customer_out = $this->db->query("SELECT * FROM tbl_customer WHERE blanch_id = '$blanch_id' AND customer_status = 'out'"); ?>
                                    <td><?php //echo $customer_out->num_rows(); ?></td>                                                       
                                    </tr>
                                     </tr>
                                    <tr>
                                    <td>WALIOLETA</td>
                                   <?php //$date = date("Y-m-d"); ?>
                                    <?php //$customer_deposit = $this->db->query("SELECT * FROM tbl_loans WHERE blanch_id = '$blanch_id'AND date_show = '$date' AND dep_status = 'close'"); ?>
                                   
                                    <td><?php //echo $customer_deposit->num_rows(); ?></td>                                                       
                                    </tr>

                                     <tr>
                                    <td>WALIOLAZA</td>
                                    <?php //$date = date("Y-m-d"); ?>
                                    <?php //$loan_not_dep = $this->db->query("SELECT * FROM tbl_loans WHERE blanch_id = '$blanch_id'AND date_show = '$date' AND dep_status = 'open'"); ?>
                                    <td><?php //echo  $loan_not_dep->num_rows()?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>WATEJA WAPYA</td>

                                    <?php //$customer_new = $this->db->query("SELECT * FROM tbl_customer WHERE blanch_id = '$blanch_id' AND reg_date = '$date'"); ?>
                                    <td><?php //echo $customer_new->num_rows(); ?></td>                                                       
                                    </tr>

                                    <!--  <tr>
                                    <td>LALA NJE</td>
                                    <td><?php //echo number_format($today_recevable->total_restration); ?></td>                                                       
                                    </tr> -->
                         
                                     <tr>
                                      <td><div class="text-center"><b>MADENI SUGU NDANI YA MFUMO</b></div></td> 
                                      <td></td>      
                                     </tr>

                                     <tr>
                                    <td>JANA</td>
                                    <td><?php //echo number_format(@$yesterDay->total_balance); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>LEO</td>
                                    <td><?php //echo number_format($deposit_out->total_out_dep); ?></td>                                                       
                                    </tr>
                                     <tr>
                                    <td>BAKI</td>
                                    <td><?php //echo number_format($remain_out->total_out_rem); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td><b>JUMLA</b></td>
                                    <td><b><?php //echo number_format(@$yesterDay->total_balance + $deposit_out->total_out_dep); ?></b></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>KOPESHA</td>
                                    <td><?php //echo number_format(@$total_kopesha_in->total_trans_in + @$total_kopesha_in->total_fee_in); ?></td>                                                       
                                    </tr>
                                    <?php //foreach ($account_out_balance as $account_out_balances): ?>
                                    <tr>
                                    <td>LALA <?php //echo $account_out_balances->account_name; ?></td>
                                    <td><?php //echo number_format($account_out_balances->out_balance); ?></td>                                                       
                                    </tr>
                                    <?php //endforeach; ?>

                                    <tr>
                                    <td><b>LALA JUMLA</b></td>
                                    <td><b><?php //echo number_format($today_stoo_out->total_balance); ?></b></td>                                                       
                                    </tr>



                                    <tr>
                                      <td><div class="text-center"><b>MADENI SUGU NJE YA MFUMO</b></div></td> 
                                      <td></td>      
                                     </tr>

                                     <tr>
                                    <td>JANA</td>
                                    <td><?php //echo number_format(@$yester_dayNje->amount); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>LEO</td>
                                    <td><?php //echo number_format(@$total_nje->total_out_today); ?></td>                                                       
                                    </tr>
                                     <tr>
                                    <td>BAKI</td>
                                    <td><?php //echo number_format(@$nje_deni->out_amount - @$sum_out->total_out); ?></td>                                                       
                                    </tr>
                                    <tr>
                                    <td><b>JUMLA</b></td>
                                    <td><b><?php //echo number_format(@$yester_dayNje->amount + @$total_nje->total_out_today); ?></b></td>                                                       
                                    </tr>
                                    <tr>
                                    <td>KOPESHA</td>
                                    <td><?php //echo number_format(@$total_kopesha_out->total_trans_out + @$total_kopesha_out->total_fee_out) ?></td>                                                       
                                    </tr>
                                    <?php //foreach ($nje_account as $nje_accounts): ?>
                                    <tr>
                                    <td>LALA <?php //echo $nje_accounts->account_name; ?></td>
                                    <td><?php //echo number_format($nje_accounts->amount_receive); ?></td>                                                       
                                    </tr>
                                    <?php //endforeach; ?>

                                    <tr>
                                    <td><b>LALA JUMLA</b></td>
                                    <td><b><?php //echo number_format(@$total_out_system); ?></b></td>                                                       
                                    </tr>




                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div> 


             
            </div>
        </div>
    </div>
</div>

<?php include('incs/footer.php'); ?>



<script>
$(document).ready(function(){
$('#blanch').change(function(){
var blanch_id = $('#blanch').val();
//alert(blanch_id)
if(blanch_id != ''){

$.ajax({
url:"<?php echo base_url(); ?>admin/fetch_ward_data",
method:"POST",
data:{blanch_id:blanch_id},
success:function(data)
{
$('#customer').html(data);
//$('#district').html('<option value="">All</option>');
}
});
}
else
{
$('#customer').html('<option value="">Select customer</option>');
//$('#district').html('<option value="">All</option>');
}
});



$('#customer').change(function(){
var customer_id = $('#customer').val();
 //alert(customer_id)
if(customer_id != '')
{
$.ajax({
url:"<?php echo base_url(); ?>admin/fetch_data_vipimioData",
method:"POST",
data:{customer_id:customer_id},
success:function(data)
{
$('#loan').html(data);
//$('#malipo_name').html('<option value="">select center</option>');
}
});
}
else
{
$('#loan').html('<option value="">Select Active loan</option>');
//$('#malipo_name').html('<option value="">chagua vipimio</option>');
}
});

// $('#social').change(function(){
//  var district_id = $('#social').val();
//  if(district_id != '')
//  {
//   $.ajax({
//    url:"<?php echo base_url(); ?>user/fetch_data_malipo",
//    method:"POST",
//    data:{district_id:district_id},
//    success:function(data)
//    {
//     $('#malipo_name').html(data);
//     //$('#malipo').html('<option value="">chagua malipo</option>');
//    }
//   });
//  }
//  else
//  {
//   //$('#vipimio').html('<option value="">chagua vipimio</option>');
//   $('#malipo_name').html('<option value="">chagua vipimio</option>');
//  }
// });


});
</script>



 <div class="modal fade" id="addcontact1" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Filter Daily Report</h6>
            </div>
            <?php echo form_open("oficer/filter_daily_report"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6 col-6">
                    <span>From:</span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" name="from" required>        
                    <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">       
                    </div>
                    <div class="col-md-6 col-6">
                    <span>To:</span>
                    <input type="date" class="form-control" name="to" value="<?php echo $date; ?>" required>           
                    </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Filter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


