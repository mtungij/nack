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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("expenses_menu"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("request_expenses_menu"); ?></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $this->lang->line("request_expenses_menu"); ?></h2>
                        </div>
                        <div class="body">
    <?php echo form_open("oficer/create_requstion_form") ?>
    <div class="row">
    <div class="col-lg-4 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("incometype_menu"); ?>:</span>
        <select type="text" name="deduct_type"  class="form-control" required>
         <option type=""><?php echo $this->lang->line("incometype_menu"); ?></option>
          <option value="deducted"><?php echo $this->lang->line("income_deducted_menu"); ?></option>
          <option value="non deducted"><?php echo $this->lang->line("income_non_menu"); ?></option>
        </select>
    </div>
    </div>
         <div class="col-lg-4 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("expenses_type_menu"); ?>:</span>
        <select type="number" name="ex_id"  class="form-control">
         <option type=""><?php echo $this->lang->line("expenses_type_menu"); ?></option>
        <?php foreach ($expenses as $expnss): ?>
          <option value="<?php echo $expnss->ex_id; ?>"><?php echo $expnss->ex_name; ?></option>
          <?php endforeach; ?>
        </select>
    </div>
    </div>

    <div class="col-lg-4 col-12">
    <div class="form-group">
      <span><?php echo $this->lang->line("amount_menu") ?>:</span>
        <input type="number" class="form-control" placeholder="<?php echo $this->lang->line("amount_menu") ?>" name="req_amount" autocomplete="off" required>
    </div>
    </div>
      
     <div class="col-lg-12 col-12">
    <div class="form-group">
      <span><?php echo $this->lang->line("description_menu"); ?>:</span>
        <textarea type="text" class="form-control"  rows="3" placeholder="<?php echo $this->lang->line("description_menu"); ?>" name="req_description" autocomplete="off" required></textarea>
    </div>
    </div>

    <input type="hidden" name="comp_id"  value="<?php echo $empl_data->comp_id; ?>">
    <input type="hidden" name="blanch_id"  value="<?php echo $empl_data->blanch_id; ?>">
    <input type="hidden" name="empl_id"  value="<?php echo $empl_data->empl_id; ?>">
    <?php $date = date("Y-m-d"); ?>
    <input type="hidden" name="req_date" value="<?php echo $date; ?>">
                                
                               
                                </div>
                                 <br>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-pencil"><?php echo $this->lang->line("save_menu"); ?></i></button>
                                </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>


                 <div class="col-lg-12">
                    <div class="card">
                         <div class="header">
                            <h2><?php echo $this->lang->line("today_expenses_menu"); ?></h2> 
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
                                                <th>S/no.</th>
                                                <th><?php echo $this->lang->line("incometype_menu"); ?></th>
                                                <th><?php echo $this->lang->line("expenses_menu"); ?></th>
                                                <th><?php echo $this->lang->line("amount_menu"); ?></th>
                                                <th><?php echo $this->lang->line("description_menu"); ?></th>
                                                <th><?php echo $this->lang->line("employee_menu"); ?></th>
                                                <th><?php echo $this->lang->line("date_menu"); ?></th>
                                                <th><?php echo $this->lang->line("action_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                              <?php $no = 1; ?>
                                    <?php foreach ($request_exp as $request_exps): ?>
                                              <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td>
                                        <?php if ($request_exps->deduct_type == 'deducted') {
                                            echo $this->lang->line("income_deducted_menu");
                                         ?>
                                     <?php }elseif ($request_exps->deduct_type == 'non deducted') {
                                         echo $this->lang->line("income_non_menu");
                                      ?>
                                      <?php } ?>
                                        <?php //echo $request_exps->deduct_type; ?>
                                            
                                        </td>
                                    <td><?php echo $request_exps->ex_name; ?></td>
                                    <td><?php echo number_format($request_exps->req_amount); ?></td>
                                    <td><?php echo $request_exps->req_description; ?></td>
                                    <td><?php echo $request_exps->empl_name; ?></td>
                                    <td>
                                        <?php echo $request_exps->req_date; ?>
                                    </td>
                                <td>
                                <a href="<?php echo base_url("oficer/get_remove_expenses/{$request_exps->req_id}"); ?>" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit" data-original-title="Delete" onclick="return confirm('<?php echo $this->lang->line("confirm_menu") ?>')"><i class="icon-pencil"></i>
                                        </a>
                                </td>                                                                                   
                            </tr>
   
                                         <?php endforeach; ?>
                                         <tr>
                                             <td><?php echo $this->lang->line("total_menu"); ?>:</td>
                                             <td></td>
                                             <td></td>
                                             <td><b><?php echo number_format($expenses_total->tota_expes); ?></b></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
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
url:"<?php echo base_url(); ?>admin/fetch_account_blanch",
method:"POST",
data:{blanch_id:blanch_id},
success:function(data)
{
$('#account').html(data);
//$('#district').html('<option value="">All</option>');
}
});
}
else
{
$('#account').html('<option value="">Select Account</option>');
//$('#district').html('<option value="">All</option>');
}
});

});

</script>



 <div class="modal fade" id="addcontact1" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("filter_expenses_menu"); ?></h6>
            </div>
            <?php echo form_open("oficer/filter_expenses_request"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6">
                    <span><?php echo $this->lang->line("from_menu") ?>:</span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" name="from" required>    
                    <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">       
                    </div>
                    <div class="col-md-6">
                    <span><?php echo $this->lang->line("to_menu") ?>:</span>
                    <input type="date" class="form-control" name="to" value="<?php echo $date; ?>" required>           
                    </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("search_menu") ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>





