<?php include('incs/header.php'); ?>
<?php include('incs/nav.php'); ?>
<?php include('incs/side.php'); ?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index"); ?>"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("income_menu"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("income_deducted_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("income_deducted_menu"); ?> <?php echo $this->lang->line("from_menu"); ?>:<?php echo $from; ?> <?php echo $this->lang->line("to_menu"); ?>:<?php echo $to; ?> </h2> 
                            <div class="pull-right">
                              <a href="" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"
                                            data-toggle="modal" data-target="#addcontact1" data-original-title="Edit"><i class="icon-calendar"></i><?php echo $this->lang->line("search_menu"); ?></a> 
                            </div>   
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>    
                                                <th><?php echo $this->lang->line("customer_name_menu"); ?></th>
                                                <th><?php echo $this->lang->line("loan_amount_appy_menu"); ?></th>
                                                <th><?php echo $this->lang->line("amount_menu"); ?></th>
                                                <th><?php echo $this->lang->line("employee_menu"); ?></th>
                                                <th><?php echo $this->lang->line("date_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                              <?php $no = 1; ?>
                                    <?php foreach ($data_deducted as $detail_incomes): ?>
                                              <tr>
                                    
                                    <td><?php echo $detail_incomes->f_name; ?> <?php echo $detail_incomes->m_name; ?> <?php echo $detail_incomes->l_name; ?></td>
                                    
                                    <td><?php echo number_format($detail_incomes->loan_aprove); ?></td>
                                    <td><?php echo number_format($detail_incomes->deducted_balance); ?></td>
                                    <td>System Deducted</td>
                                    <td><?php echo $detail_incomes->deducted_date; ?></td>                                                           
                                    </tr>
   
                                         <?php endforeach; ?>
                                    </tbody>
                                    <tr>
                                             <td><b><?php echo $this->lang->line("total_menu"); ?>:</b></td>
                                             <td></td>
                                             <td><b><?php echo number_format($total_deducted->total_deducteds); ?></b></td>
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
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("search_menu"); ?></h6>
            </div>
            <?php echo form_open("oficer/filter_deducted_income"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("from_menu"); ?>:</span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" name="from" required>    
                    <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">       
                    <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">       
                    </div>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("to_menu"); ?>:</span>
                    <input type="date" class="form-control" name="to" value="<?php echo $date; ?>" required>           
                    </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("search_menu"); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


