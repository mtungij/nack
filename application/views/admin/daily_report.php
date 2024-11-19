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
                            <li class="breadcrumb-item active">Ripoti ya Siku</li>
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
                            <h2>Ripoti ya Siku / <?php echo $date; ?></h2> 
                            <div class="pull-right">
                            <a href="" data-toggle="modal" data-target="#addcontact1" class="btn btn-primary"><i class="icon-calendar">Tafuta</i></a>
                              <a href="<?php echo base_url("admin/print_daily_report"); ?>" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"
                                           data-original-title="print" target="_blank"><i class="icon-printer"></i>Chapisha
                                       </a>
                    



                            </div>   
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover j-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
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
                                    <tbody>
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
                                    <?php $blanch_out = $this->queries->get_today_deposit_blanch($blanch_recs->blanch_id);
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
                                    </tbody>
                                    <tr>
                                        <td><b>JUMLA:</b></td>
                                        <td></td>
                                        <td><b><?php echo number_format($sum_withdrawls->total_aprove); ?></b></td>
                                        <td><b><?php echo number_format($deducted_fee->total_deducted); ?></b></td>
                                        <td><b><?php echo  number_format($total_code_no->total_interest); ?></b></td>
                                        <td><b><?php echo number_format($sum_withdrawls->total_deposit); ?></b></td>
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
                                     <?php foreach ($account_deposit as $account_deposits): ?>  
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
                <h6 class="title" id="defaultModalLabel">Tafuta</h6>
            </div>
            <?php echo form_open("admin/filter_daily_report"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6 col-6">
                    <span>From:</span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" name="from" required>        
                      
                    </div>
                    <div class="col-md-6 col-6">
                    <span>To:</span>
                    <input type="date" class="form-control" name="to" value="<?php echo $date; ?>" required>           
                    </div>
                    <input type="hidden" name="comp_id" value="<?php echo $_SESSION['comp_id']; ?>">
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


