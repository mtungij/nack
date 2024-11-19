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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("froat_menu") ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("froat_transaction_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("froat_transaction_menu"); ?></h2>
                        </div>
                        <div class="body">
    <?php echo form_open("oficer/transfor_money_blanch") ?>
    <div class="row">
    <div class="col-lg-4 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("from_account_menu"); ?>:</span>
        <select type="text" name="from_blanch_account"  class="form-control" required>
         <option type=""><?php echo $this->lang->line("select_menu") ?></option>
         <?php foreach ($acount as $acounts):?>
          <option value="<?php echo $acounts->receive_trans_id; ?>">
            <?php echo $acounts->account_name; ?> - <?php echo number_format($acounts->blanch_capital); ?>
            </option>
           <?php endforeach; ?>
        </select>
    </div>
    </div>
         <div class="col-lg-4 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("to_account_menu"); ?>:</span>
        <select type="number" name="to_branch_account"  class="form-control">
         <option type=""><?php echo $this->lang->line("select_menu"); ?></option>
        <?php foreach ($acount as $acounts): ?>
          <option value="<?php echo $acounts->receive_trans_id; ?>"><?php echo $acounts->account_name; ?></option>
           <?php endforeach; ?>
        </select>
    </div>
    </div>

    <div class="col-lg-2 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("amount_menu"); ?>:</span>
        <input type="number" class="form-control" placeholder="<?php echo $this->lang->line("amount_menu"); ?>" name="from_amount" autocomplete="off" required>
    </div>
    </div>

    <div class="col-lg-2 col-6">
    <div class="form-group">
      <span><?php echo $this->lang->line("charger_menu"); ?>:</span>
        <input type="number" class="form-control" placeholder="<?php echo $this->lang->line("charger_menu"); ?>" name="charger_fee" autocomplete="off" required>
    </div>
    </div>
      
     

    <input type="hidden" name="comp_id"  value="<?php echo $empl_data->comp_id; ?>">
    <input type="hidden" name="from_blanch"  value="<?php echo $empl_data->blanch_id; ?>">
    <input type="hidden" name="to_branch"  value="<?php echo $empl_data->blanch_id; ?>">
    <?php $date = date("Y-m-d"); ?>
    <input type="hidden" name="date_trans" value="<?php echo $date; ?>">            
            </div>
     <br>
    <div class="text-center">
    <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("transfor_menu"); ?></i></button>
    </div>
                            
    <?php echo form_close();  ?>
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
                <h6 class="title" id="defaultModalLabel">Filter Expenses</h6>
            </div>
            <?php echo form_open("oficer/filter_expenses_request"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6">
                    <span>From:</span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" name="from" required>    
                    <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">       
                    </div>
                    <div class="col-md-6">
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





