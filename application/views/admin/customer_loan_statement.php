<?php include('incs/header.php'); ?>
<?php include('incs/nav.php'); ?>
<?php include('incs/side.php'); ?>

<div id="main-content" class="profilepage_2 blog-page">
<div class="container-fluid">
<div class="block-header">
<div class="row">
<div class="col-lg-6 col-md-8 col-sm-12">
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url("admin/index"); ?>"><i class="icon-home"></i></a></li>

<li class="breadcrumb-item active">Report</li>
<li class="breadcrumb-item active">Customer Account Statement</li>
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
<?php if ($das = $this->session->flashdata('error')): ?> 
<div class="row"> 
<div class="col-md-12"> 
<div class="alert alert-dismisible alert-danger"> <a href="" class="close">&times;</a> 
    <?php echo $das;?> </div> 
</div> 
</div> 
<?php endif; ?>

<div class="row clearfix">

<style>
.sam{
display: flex;
}
</style>  
<div class="col-lg-12">
<div class="card">
<div class="body">


<div class="table-responsive">
<table class="table table-hover j-basic-example dataTable table-custom">
    <thead class="thead-primary">
        <tr>
        <th>Customer Name</th>
        <th>Phone Number</th>
        <th>Loan Amount</th>
        <th>Paid Amount</th>
        <th>Remain Amount</th>
        </tr>
    </thead>
   
    <tbody>

      <?php @$customer_loan = $this->queries->get_loan_account_statement($loan_id);
         @$total_deposit = $this->queries->get_total_amount_paid_loan($loan_id);
         $customer_id = @$customer_loan->customer_id;
         $customer = $this->queries->search_CustomerLoan($customer_id);

        // @$out_stand = $this->queries->get_outstand_loan_customer($customer_loan->loan_id);
       ?>



   <?php //print_r($out_stand); ?>
        <tr>
            <td><?php echo @$customer->f_name; ?> <?php echo @$customer->m_name; ?> <?php echo @$customer->l_name; ?></td>
            <td><?php echo @$customer->phone_no; ?></td> 
                
            <td><?php echo number_format($customer_loan->loan_int); ?></td>
            <td><?php echo number_format($total_deposit->total_Deposit) ?></td>
            <td><?php echo number_format(($customer_loan->loan_int) - ($total_deposit->total_Deposit) ) ?></td>
        
        </tr>
    </tbody>
</table>
</div>
</div>

</div>
</div>





<div class="col-lg-12">

<div class="card">
<div class="body">
<div class="pull-right">
<a href="<?php echo base_url("admin/print_account_statement/{$customer_id}/{$loan_id}"); ?>" target="_blank" class="btn btn-primary" target="_blank"><i class="icon-printer"></i></a> 
<a href="<?php echo base_url("admin/customer_profile/{$customer_id}") ?>" class="btn btn-primary"><i class="icon-arrow-left"></i></a>
</div>
<div class="table-responsive">
<table class="table table-hover j-basic-example dataTable table-custom">
    <thead class="thead-primary">
        <tr>
        <th>Date</th>
        <th>Description</th>
        <th>Deposit</th>
        <th>Withdrawal</th>
        <th>Balance</th> 
        </tr>
    </thead>
   
    <tbody>

      <?php @$loan_desc = $this->queries->get_total_pay_description_acount_statement($loan_id);
      //@$remain_balance = $this->queries->get_total_remain_with($customer_loan->loan_id);
      //@$total_recovery = $this->queries->get_total_loan_pend($customer_loan->loan_id);
      //@$total_penart =   $this->queries->get_total_penart_loan($customer_loan->loan_id);
      //@$total_deposit_penart =  $this->queries->get_total_paypenart($customer_loan->loan_id);
      //@$end_deposit = $this->queries->get_end_deposit_time($customer_loan->loan_id);
       ?>

    <?php //print_r($loan_desc); ?>

           <?php foreach ($loan_desc as $payisnulls): ?>
            <tr>
              <td class="c"><?php echo $payisnulls->date_data; ?></td>
              <td class="c">  <?php echo $payisnulls->emply; ?>
              <?php if ($payisnulls->emply == TRUE) {   
               ?>
               /
           <?php }else{ ?>
            <?php } ?>
               <?php echo $payisnulls->description; ?>
               <?php if($payisnulls->p_method == TRUE){ ?>
                /<?php echo $payisnulls->account_name; ?>
                <?php }else{ ?> 
                     
                    <?php } ?>
               <?php if ($payisnulls->fee_id == TRUE || $payisnulls->fee_id == '0' ) {
              ?>
              / <?php echo $payisnulls->fee_desc; ?> <?php echo $payisnulls->fee_percentage; ?> <?php echo $payisnulls->symbol; ?>
          <?php }else{ ?>
            <?php } ?>
            <?php if($payisnulls->p_method == FALSE){ ?>
            <?php }else{ ?>
               / 
               <?php } ?>
               <?php //echo @$payisnulls->description; ?>  <?php echo @$payisnulls->loan_name ; ?>
         <?php if(@$payisnulls->day == 1){
           echo "Daily";
    }elseif(@$payisnulls->day == 7){
         echo "Weekly";
    }elseif (@$payisnulls->day == 30 || @$payisnulls->day == 31 || @$payisnulls->day == 28 || @$payisnulls->day == 29) {
        echo "Monthly";
     ?> 
    <?php } ?><?php //echo $payisnulls->session; ?>  / AC/No. <?php echo @$payisnulls->loan_code; ?>
        
    </td>

              <td>
                <?php if($payisnulls->depost == TRUE){ ?>
                <?php echo round(@$payisnulls->depost,2); ?>
            <?php }elseif($payisnulls->depost == FALSE){ ?>
            0.00
                <?php } ?>
            </td>
              <td>
                <?php if (@$payisnulls->withdrow == TRUE) {
                 ?>
                <?php echo round(@$payisnulls->withdrow,2); ?>
                <?php }elseif (@$payisnulls->withdrow == FALSE) {
                 ?>
                 0.00
            <?php } ?>
            </td>
              <td>
                <?php if (@$payisnulls->balance == TRUE) {
                 ?>
                <?php echo round(@$payisnulls->balance,2); ?>
                <?php }elseif (@$payisnulls->balance == FALSE) {
                 ?>
                 0.00
                 <?php } ?>
            </td>
              </tr>
        <?php endforeach; ?>

    </tbody>
</table>
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

$('#customer').change(function(){
var customer_id = $('#customer').val();
//alert(customer_id)
if(customer_id != '')
{
$.ajax({
url:"<?php echo base_url(); ?>admin/fetch_data_loanActive",
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



$('#blanch').change(function(){
var blanch_id = $('#blanch').val();
//alert (blanch_id)
if(blanch_id != '')
{
$.ajax({
url:"<?php echo base_url(); ?>admin/fetch_blanch_account",
method:"POST",
data:{blanch_id:blanch_id},
success:function(data)
{
$('#account').html(data);
//$('#malipo').html('<option value="">chagua malipo</option>');
}
});
}
else
{
//$('#vipimio').html('<option value="">chagua vipimio</option>');
$('#account').html('<option value="">Select Account</option>');
}
});


});
</script>














