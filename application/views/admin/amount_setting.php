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
                            <li class="breadcrumb-item active">Settup Amount</li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Branch Account</h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("admin/modify_blanch_account") ?>
                            <div class="row">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select type="number" class="form-control select2" name="blanch_id" id="blanch" required>
                                        <option value="">Select Branch</option>
                                        <?php foreach ($blanch as $blanchs): ?>
                                        <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label>Account</label>
                                    <select type="number" class="form-control" id="account" name="receive_trans_id">
                                        <option value="">Select Account</option>
                                    </select>
                                </div>
                                </div>
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch Capital</label>
                                    <input type="number" name="blanch_capital" autocomplete="off" class="form-control" placeholder="Eg.1000000" required>
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer">Update</i></button>
                                </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Cash In Hand</h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("admin/modify_cash_inhand") ?>
                            <div class="row">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select type="number" class="form-control select2" name="blanch_id" id="blanch" required>
                                        <option value="">Select Branch</option>
                                        <?php foreach ($blanch as $blanchs): ?>
                                        <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                </div>
                                
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="cash_amount" autocomplete="off" class="form-control" placeholder="Eg.1000000" required>
                                </div>
                                </div>
                                <input type="hidden" name="comp_id" value="<?php echo $_SESSION['comp_id']; ?>">
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>date</label>
                                    <?php $date = date("Y-m-d"); ?>
                                    <input type="date" name="cash_day" value="<?php echo $date ?>" autocomplete="off" class="form-control" placeholder="" required>
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer">Update</i></button>
                                </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>

                   <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Fomu</h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("admin/modify_fomu"); ?>
                            <div class="row">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select type="number" class="form-control select2" name="blanch_id" id="blanch" required>
                                        <option value="">Select Branch</option>
                                        <?php foreach ($blanch as $blanchs): ?>
                                        <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                </div>
                                
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="deduct_balance" autocomplete="off" class="form-control" placeholder="Eg.1000000" required>
                                </div>
                                </div>
                                <input type="hidden" name="comp_id" value="<?php echo $_SESSION['comp_id']; ?>">
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>date</label>
                                    <?php $date = date("Y-m-d"); ?>
                                    <input type="date" name="date_deduct" value="<?php echo $date ?>" autocomplete="off" class="form-control" placeholder="" required>
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer">Update</i></button>
                                </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>


                  <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Faini</h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("admin/modify_faini"); ?>
                            <div class="row">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select type="number" class="form-control select2" name="blanch_id" id="blanch" required>
                                        <option value="">Select Branch</option>
                                        <?php foreach ($blanch as $blanchs): ?>
                                        <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                </div>
                                
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="non_deduct_balance" autocomplete="off" class="form-control" placeholder="Eg.1000000" required>
                                </div>
                                </div>
                                <input type="hidden" name="comp_id" value="<?php echo $_SESSION['comp_id']; ?>">
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>date</label>
                                    <?php $date = date("Y-m-d"); ?>
                                    <input type="date" name="non_date" value="<?php echo $date ?>" autocomplete="off" class="form-control" placeholder="" required>
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer">Update</i></button>
                                </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>

                  <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Jumla faini and Fomu</h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("admin/modify_jumla_income"); ?>
                            <div class="row">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select type="number" class="form-control select2" name="blanch_id" id="blanch" required>
                                        <option value="">Select Branch</option>
                                        <?php foreach ($blanch as $blanchs): ?>
                                        <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                </div>
                                
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" autocomplete="off" class="form-control" placeholder="Eg.1000000" required>
                                </div>
                                </div>
                                <input type="hidden" name="comp_id" value="<?php echo $_SESSION['comp_id']; ?>">
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label>date</label>
                                    <?php $date = date("Y-m-d"); ?>
                                    <input type="date" name="date" value="<?php echo $date ?>" autocomplete="off" class="form-control" placeholder="" required>
                                </div>
                                </div>
                                </div>
                                
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer">Update</i></button>
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


