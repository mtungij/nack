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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("customer_menu"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("registercustomer_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("registercustomer_menu"); ?></h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("oficer/create_customer") ?>
                            <div class="row">

                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("first_name_menu"); ?>:</span>
                            <input type="text" name="f_name" placeholder="<?php echo $this->lang->line("first_name_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("midle_name_menu"); ?>:</span>
                                    <input type="text" name="m_name" placeholder="<?php echo $this->lang->line("midle_name_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("last_name_menu"); ?>:</span>
                                    <input type="text" name="l_name" placeholder="<?php echo $this->lang->line("last_name_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                </div>

                                <!-- <div class="col-lg-3 col-6">
                                    <span>Branch:</span>
                                <select type="number" name="blanch_id" class="form-control select2 input-sm" id="blanch" required class="form-control input-sm">
                                <option value="">Select Blanch</option>
                                <?php foreach ($blanch as $blanchs): ?>
                                <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                <?php endforeach;?>
                            </select>
                                </div> -->

                                <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">

                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("employee_menu") ?>:</span>
                                <select type="number" name="empl_id" class="form-control select2 input-sm" id="empl" required class="form-control input-sm">
                                <option value="<?php echo $empl_data->empl_id; ?>"><?php echo $empl_data->empl_name; ?></option>
                                <?php foreach ($employee as $employees): ?>
                                <option value="<?php echo $employees->empl_id; ?>"><?php echo $employees->empl_name; ?></option>
                                <?php endforeach; ?>
                                
                            </select>
                                </div>
                        
                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("gender_menu"); ?>:</span>
                                <select type="text" name="gender" class="form-control select2 input-sm" required class="form-control input-sm">
                                <option value=""><?php echo $this->lang->line("selectgender_menu"); ?></option>
                                <option value="male"><?php echo $this->lang->line("male_menu") ?></option>
                                <option value="female"><?php echo $this->lang->line("female_menu") ?></option>
                            </select>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("date_birth_menu"); ?>:</span>
                            <input type="date" name="date_birth" onchange="getDate(this.value)" placeholder="Date of Birth" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("year_customer_menu"); ?>:</span>
                            <input type="" id="age" name="age" readonly class="form-control input-sm" value="" required>
                            <?php $date = date("Y-m-d"); ?>
                            <input type="hidden" name="reg_date" value="<?php echo $date; ?>">
                                </div>
                                    <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("phone_number_menu"); ?>:</span>
                            <input type="number" name="phone_no" placeholder="Eg,7538, 6283" autocomplete="off" class="form-control input-sm" required >
                                </div>
                             <!--        <div class="col-lg-4 form-group-sub">
                                    <label class="form-control-label">*Region:</label>
                            <select type="number" name="region_id" class="form-control select2 input-sm" required>
                                <option value="">Select Region</option>
                                <?php //foreach ($region as $regions): ?>
                                <option value="<?php //echo $regions->region_id; ?>"><?php //echo $regions->region_name; ?></option>
                                <?php //endforeach;?>
                            </select>
                                </div> -->
                                <input type="hidden" name="region_id" value="1">
                                    <div class="col-lg-4 col-6">
                                    <span><?php echo $this->lang->line("district_menu"); ?>:</span>
                            <input type="text" name="district" placeholder="<?php echo $this->lang->line("district_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                    <div class="col-lg-6 col-6">
                                    <span><?php echo $this->lang->line("ward_menu"); ?>:</span>
                            <input type="text" name="ward" placeholder="<?php echo $this->lang->line("ward_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                        <div class="col-lg-6 col-12">
                                    <span><?php echo $this->lang->line("street_menu"); ?>:</span>
                            <input type="text" name="street" placeholder="street" autocomplete="off" class="form-control input-sm" required>
                                </div>
                                <br>
                                </div>
                            </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-pencil"><?php echo $this->lang->line("next_menu"); ?></i></button>
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
    function getDate(data){
  let now = new Date();
  let bod = (new Date(data));

  let age = now.getFullYear() - bod.getFullYear();
   let _age = document.querySelector("#age");
   _age.value = age;
 //alert(age)
}
</script>


<script>
$(document).ready(function(){
$('#blanch').change(function(){
var blanch_id = $('#blanch').val();
//alert(blanch_id)
if(blanch_id != ''){

$.ajax({
url:"<?php echo base_url(); ?>admin/fetch_employee_blanch",
method:"POST",
data:{blanch_id:blanch_id},
success:function(data)
{
$('#empl').html(data);
//$('#district').html('<option value="">All</option>');
}
});
}
else
{
$('#empl').html('<option value="">Select Employee</option>');
//$('#district').html('<option value="">All</option>');
}
});



// $('#customer').change(function(){
// var customer_id = $('#customer').val();
//  //alert(customer_id)
// if(customer_id != '')
// {
// $.ajax({
// url:"<?php echo base_url(); ?>admin/fetch_data_vipimioData",
// method:"POST",
// data:{customer_id:customer_id},
// success:function(data)
// {
// $('#loan').html(data);
// //$('#malipo_name').html('<option value="">select center</option>');
// }
// });
// }
// else
// {
// $('#loan').html('<option value="">Select Active loan</option>');
// //$('#malipo_name').html('<option value="">chagua vipimio</option>');
// }
// });

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


