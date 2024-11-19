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
                            
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("applyloan_menu") ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan_form_menu"); ?></li>
                        </ul>
                    </div>            
                 <?php 
$customer_loan = $this->queries->get_loan_customer_old($customer_id);
@$total_penart = $this->queries->get_total_penart_data($customer_loan->loan_id);
$total_penart = @$total_penart->Total_Penart;
@$paid_penart = $this->queries->get_total_penart_paid_loan($customer_loan->loan_id);
$paid = @$paid_penart->total_PaidPenart;

@$msamaha = $this->queries->get_penart_check($customer_loan->loan_id);

// echo "<pre>";
// print_r($paid);
    
 ?>
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
                     <?php if ($das = $this->session->flashdata('mass')): ?> 
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="alert alert-dismisible alert-danger"> <a href="" class="close">&times;</a> 
                                    <?php echo $das;?> </div> 
                            </div> 
                        </div> 
                    <?php endif; ?>

            <div class="row clearfix">

                   <?php if (@$loan_option->loan_status == 'done') {
               ?>

                   <?php if ($total_penart <= $paid || $msamaha == TRUE) {
                    ?>

                    <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $this->lang->line("loan_form_menu"); ?></h2>
                        </div>
                        <div class="body">
            <?php echo form_open("oficer/create_loanapplication/{$customer->customer_id}"); ?>
                  <div class="row">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_category_menu") ?>:</span>
                                      <select type="number" name="category_id" class="form-control select2" required>
                                        <option value=""><?php echo $this->lang->line("loan_category_menu") ?></option>
                                        <?php foreach ($loan_category as $loan_categorys): ?>
                                        <option value="<?php echo $loan_categorys->category_id; ?>"><?php echo $loan_categorys->loan_name; ?> / <?php echo $loan_categorys->loan_price; ?> - <?php echo $loan_categorys->loan_perday; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>

                                    
                                  <!--   <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">*Group:</label>
                                        <select type="number" name="group_id" class="form-control select2">
                                            <option value="">Select Group</option>
                                            <?php //foreach ($group as $groups): ?>
                                            <option value="<?php //echo $groups->group_id; ?>"><?php //echo $groups->group_name; ?></option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("employee_menu"); ?>:</span>
                                        <select type="number" name="empl_id" class="form-control select2">
                                            <option value="<?php echo $customer->empl_id; ?>"><?php echo $customer->empl_name; ?></option>
                                            <?php foreach ($mpl_data_blanch as $mpl_data_blanchs): ?>
                                            <option value="<?php echo $mpl_data_blanchs->empl_id; ?>"><?php echo $mpl_data_blanchs->empl_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                    <input type="hidden" name="blanch_id" value="<?php echo $customer->blanch_id; ?>">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_amount_appy_menu"); ?>:</span>
                                        <input type="number" name="how_loan" placeholder="Loan Amount Applied" autocomplete="off" class="form-control input-sm" required>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_duration_menu") ?>:</span>
                                    <select type="number" name="day" class="form-control" required class="form-control input-sm">
                                    <option value=""><?php echo $this->lang->line("loan_duration_menu") ?></option>
                                    <option value="1"><?php echo $this->lang->line("daily_menu"); ?></option>
                                    <option value="7"><?php echo $this->lang->line("weekly_menu") ?></option>
                                    <?php 
                                    $month = date("m");
                                     $year = date("Y");
                                     $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                                     ?>
                                    <option value="<?php echo $d; ?>"><?php echo $this->lang->line("monthly_menu"); ?></option>
                                    
                                </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("number_repayment_menu"); ?>:</span>
                                <input type="number" name="session" placeholder="Enter Number of Repayments" autocomplete="off" class="form-control input-sm" required>
                                    </div>
                                 
                                 <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("interst_formular_menu"); ?>:</b></span>
                                        <select type="number" name="rate" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line("interst_formular_select_menu"); ?></option>
                                            <?php foreach ($formular as $formulars): ?> 
                                            <option value="<?php echo $formulars->formular_name; ?>"><?php if ($formulars->formular_name == 'SIMPLE') {
                                                 ?>
                                                 SIMPLE FORMULAR
                                                <?php }elseif($formulars->formular_name == 'FLAT RATE'){ ?>
                                                 FLAT RATE FORMULAR
                                                    <?php }elseif ($formulars->formular_name == 'REDUCING') {
                                                     ?>
                                                     REDUCING FORMULAR
                                                     <?php } ?>
                                                        
                                                     </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("makato_menu"); ?>?:</b></span>
                                        <select type="number" name="fee_status" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line("select_menu"); ?></option>
                                            <?php if ($loan_fee_category->fee_category == 'GENERAL') {
                                             ?>
                                            <option value="YES"><?php echo $this->lang->line("yes_menu"); ?></option>
                                            <!-- <option value="NO">NO</option> -->
                                        <?php }elseif ($loan_fee_category->fee_category == 'LOAN PRODUCT') {
                                         ?>
                                         <option value="NO"><?php echo $this->lang->line("yes_menu"); ?></option>
                                         <?php }else{ ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("reason_loan_menu"); ?>:</span>
                                   <input type="text" name="reason" autocomplete="off"  class="form-control input-sm" placeholder="<?php echo $this->lang->line("reason_loan_menu"); ?>" required>
                                    </div> 
                              </div>
                           </div>
                               <br>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("next_menu"); ?></i></button>
                        </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>

                <?php }else{ ?>
                    
                     <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="text-center">
                            <h2>
                                <div class="alert alert-dismisible alert-danger">
                                  Ndugu, <b><?php echo $customer_loan->f_name; ?> <?php echo $customer_loan->m_name; ?> <?php echo $customer_loan->l_name; ?></b> Jumla ya Faini Unadaiwa <b>(<?php echo number_format($total_penart - $paid); ?>)</b> Tafadhari lipa Deni Ili uendelee Kufurahia Huduma Ahsante</div></a>
                                  <a href="<?php echo base_url("oficer/loan_application"); ?>" class="btn btn-primary"><?php echo $this->lang->line("back_menu"); ?></a>
                              </h2>
                            </div>
                        </div>
                        <div class="body">
                       <div class="row">
                       </div>
                           </div>
                        <br>     
                    </div>
                    </div>
                    <?php } ?>


                <?php }elseif (@$loan_option == FALSE) {
                 ?>

                      <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $this->lang->line("loan_form_menu"); ?></h2>
                        </div>
                        <div class="body">
            <?php echo form_open("oficer/create_loanapplication/{$customer->customer_id}"); ?>
            <div class="row">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_category_menu"); ?>:</span>
                                      <select type="number" name="category_id" class="form-control select2" required>
                                        <option value=""><?php echo $this->lang->line("select_menu"); ?></option>
                                        <?php foreach ($loan_category as $loan_categorys): ?>
                                        <option value="<?php echo $loan_categorys->category_id; ?>"><?php echo $loan_categorys->loan_name; ?> / <?php echo $loan_categorys->loan_price; ?> - <?php echo $loan_categorys->loan_perday; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>

                                    
                                  <!--   <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">*Group:</label>
                                        <select type="number" name="group_id" class="form-control select2">
                                            <option value="">Select Group</option>
                                            <?php //foreach ($group as $groups): ?>
                                            <option value="<?php //echo $groups->group_id; ?>"><?php //echo $groups->group_name; ?></option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("employee_menu"); ?>:</span>
                                        <select type="number" name="empl_id" class="form-control select2">
                                            <option value="<?php echo $customer->empl_id; ?>"><?php echo $customer->empl_name; ?></option>
                                            <?php foreach ($mpl_data_blanch as $mpl_data_blanchs): ?>
                                            <option value="<?php echo $mpl_data_blanchs->empl_id; ?>"><?php echo $mpl_data_blanchs->empl_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                    <input type="hidden" name="blanch_id" value="<?php echo $customer->blanch_id; ?>">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_amount_appy_menu"); ?>:</span>
                                        <input type="number" name="how_loan" placeholder="<?php echo $this->lang->line("loan_amount_appy_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_duration_menu"); ?>:</span>
                                    <select type="number" name="day" class="form-control" required class="form-control input-sm">
                                    <option value=""><?php echo $this->lang->line("select_menu"); ?></option>
                                    <option value="1"><?php echo $this->lang->line("daily_menu"); ?></option>
                                    <option value="7"><?php echo $this->lang->line("weekly_menu"); ?></option>
                                    <?php 
                                    $month = date("m");
                                     $year = date("Y");
                                     $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                                     ?>
                                    <option value="<?php echo $d; ?>"><?php echo $this->lang->line("monthly_menu"); ?></option>
                                    
                                </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("number_repayment_menu"); ?>:</span>
                                <input type="number" name="session" placeholder="<?php echo $this->lang->line("number_repayment_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                    </div>
                                 
                                 <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("interst_formular_menu"); ?>:</b></span>
                                        <select type="number" name="rate" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line("select_menu"); ?></option>
                                            <?php foreach ($formular as $formulars): ?> 
                                            <option value="<?php echo $formulars->formular_name; ?>"><?php if ($formulars->formular_name == 'SIMPLE') {
                                                 ?>
                                                 SIMPLE FORMULAR
                                                <?php }elseif($formulars->formular_name == 'FLAT RATE'){ ?>
                                                 FLAT RATE FORMULAR
                                                    <?php }elseif ($formulars->formular_name == 'REDUCING') {
                                                     ?>
                                                     REDUCING FORMULAR
                                                     <?php } ?>
                                                        
                                                     </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("makato_menu"); ?>?:</b></span>
                                        <select type="number" name="fee_status" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line("select_menu"); ?></option>
                                            <?php if ($loan_fee_category->fee_category == 'GENERAL') {
                                             ?>
                                            <option value="YES"><?php echo $this->lang->line("yes_menu"); ?></option>
                                            <!-- <option value="NO">NO</option> -->
                                        <?php }elseif ($loan_fee_category->fee_category == 'LOAN PRODUCT') {
                                         ?>
                                         <option value="NO"><?php echo $this->lang->line("yes_menu"); ?></option>
                                         <?php }else{ ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("reason_loan_menu"); ?>:</span>
                                   <input type="text" name="reason" autocomplete="off"  class="form-control input-sm" placeholder="<?php echo $this->lang->line("reason_loan_menu"); ?>" required>
                                    </div> 
                              </div>
                           </div>
                               <br>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("next_menu"); ?></i></button>
                        </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>

             <?php }elseif ($loan_option->loan_status == 'open') {
              ?>
                    <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $this->lang->line("loan_form_menu"); ?></h2>
                        </div>
                        <div class="body">
            <?php echo form_open("oficer/modify_loanapplication/{$customer->customer_id}/{$skip_next->loan_id}"); ?>
            <div class="row">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_category_menu"); ?>:</span>
                                      <select type="number" name="category_id" class="form-control select2" required>
                                        <option value="<?php echo $skip_next->category_id; ?>">
                                            <?php echo $skip_next->loan_name; ?> / <?php echo $skip_next->loan_price; ?> -  <?php echo $skip_next->loan_perday; ?>
                                        </option>
                                        <?php foreach ($loan_category as $loan_categorys): ?>
                                        <option value="<?php echo $loan_categorys->category_id; ?>"><?php echo $loan_categorys->loan_name; ?> / <?php echo $loan_categorys->loan_price; ?> - <?php echo $loan_categorys->loan_perday; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>

                                    
                                  <!--   <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">*Group:</label>
                                        <select type="number" name="group_id" class="form-control select2">
                                            <option value="">Select Group</option>
                                            <?php //foreach ($group as $groups): ?>
                                            <option value="<?php //echo $groups->group_id; ?>"><?php //echo $groups->group_name; ?></option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("employee_menu"); ?>:</span>
                                        <select type="number" name="empl_id" class="form-control select2">
                                            <option value="<?php echo $customer->empl_id; ?>"><?php echo $customer->empl_name; ?></option>
                                            <?php foreach ($mpl_data_blanch as $mpl_data_blanchs): ?>
                                            <option value="<?php echo $mpl_data_blanchs->empl_id; ?>"><?php echo $mpl_data_blanchs->empl_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                    <input type="hidden" name="loan_status" value="open">
                                    <input type="hidden" name="blanch_id" value="<?php echo $customer->blanch_id; ?>">
                                  
                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_amount_appy_menu"); ?>:</span>
                                        <input type="number" name="how_loan" value="<?php echo $skip_next->how_loan; ?>" placeholder="Loan Amount Applied" autocomplete="off" class="form-control input-sm" required>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_duration_menu"); ?>:</span>
                                    <select type="number" name="day" class="form-control"  required class="form-control input-sm">
                                    <option value="<?php echo $skip_next->day; ?>">
                                        <?php if ($skip_next->day == '1') {
                                            echo $this->lang->line("daily_menu");
                                          ?>
                                        <?php }elseif($skip_next->day == '7'){
                                             echo  $this->lang->line("weekly_menu");
                                         ?>
                                         <?php }elseif($skip_next->day == '30' || $skip_next->day == '31' || $skip_next->day == '28' || $skip_next->day == '29' ){
                                            echo $this->lang->line("monthly_menu");
                                          ?>
                                            <?php } ?>
                                    </option>
                                    <option value="1"><?php echo $this->lang->line("daily_menu"); ?></option>
                                    <option value="7"><?php echo $this->lang->line("weekly_menu"); ?></option>
                                    <?php 
                                    $month = date("m");
                                     $year = date("Y");
                                     $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                                     ?>
                                    <option value="<?php echo $d; ?>"><?php echo $this->lang->line("monthly_menu"); ?></option>
                                    
                                </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("number_repayment_menu"); ?>:</span>
                                <input type="number" name="session" value="<?php echo $skip_next->session; ?>" placeholder="<?php echo $this->lang->line("number_repayment_menu"); ?>" autocomplete="off" class="form-control input-sm" required>
                                    </div>
                                 
                                 <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("interst_formular_menu"); ?>:</b></span>
                                        <select type="number" name="rate" class="form-control" required>
                                            <option value="<?php echo $skip_next->rate; ?>">
                                                <?php if ($skip_next->rate == 'SIMPLE') {
                                                 ?>
                                                <?php echo "SIMPLE FORMULAR"; ?>
                                                <?php }elseif ($skip_next->rate == 'FLAT RATE') {
                                                    echo "FLAT RATE FORMULAR";
                                                 ?>
                                                 <?php }elseif($skip_next->rate == 'REDUCING'){ ?>
                                                    <?php echo "REDUCING FORMULAR"; ?>
                                                    <?php } ?>
                                            </option>
                                            <?php foreach ($formular as $formulars): ?> 
                                            <option value="<?php echo $formulars->formular_name; ?>"><?php if ($formulars->formular_name == 'SIMPLE') {
                                                 ?>
                                                 SIMPLE FORMULAR
                                                <?php }elseif($formulars->formular_name == 'FLAT RATE'){ ?>
                                                 FLAT RATE FORMULAR
                                                    <?php }elseif ($formulars->formular_name == 'REDUCING') {
                                                     ?>
                                                     REDUCING FORMULAR
                                                     <?php } ?>
                                                        
                                                     </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("makato_menu"); ?>?:</b></span>
                                        <select type="number" name="fee_status" class="form-control" required>
                                            <option value="<?php echo $skip_next->fee_status;?>"><?php echo $skip_next->fee_status;?></option>
                                            <?php if ($loan_fee_category->fee_category == 'GENERAL') {
                                             ?>
                                            <option value="YES"><?php echo $this->lang->line("yes_menu"); ?></option>
                                            <!-- <option value="NO">NO</option> -->
                                        <?php }elseif ($loan_fee_category->fee_category == 'LOAN PRODUCT') {
                                         ?>
                                         <option value="NO"><?php echo $this->lang->line("yes_menu"); ?></option>
                                         <?php }else{ ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("reason_loan_menu"); ?>:</span>
                                   <input type="text" name="reason" autocomplete="off" value="<?php echo $skip_next->reason; ?>"  class="form-control input-sm" placeholder="<?php echo $this->lang->line("reason_loan_menu"); ?>" required>
                                    </div> 
                              </div>
                           </div>
                               <br>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("update_menu"); ?></i></button>
                        <a href="<?php echo base_url("oficer/collelateral_session/{$skip_next->loan_id}") ?>" class="btn btn-primary btn-elevate btn-pill"><?php echo $this->lang->line("skip_menu"); ?></a>
                        </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>


              <?php }elseif (@$reject_skip->loan_status == 'reject') {
               ?>
                      <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $this->lang->line("loan_form_menu"); ?></h2>
                        </div>
                        <div class="body">
            <?php echo form_open("oficer/modify_loanapplication/{$customer->customer_id}/{$reject_skip->loan_id}"); ?>
            <div class="row">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_category_menu"); ?>:</span>
                                      <select type="number" name="category_id" class="form-control select2" required>
                                        <option value="<?php echo $reject_skip->category_id; ?>">
                                            <?php echo $reject_skip->loan_name; ?> / <?php echo $reject_skip->loan_price; ?> -  <?php echo $reject_skip->loan_perday; ?>
                                        </option>
                                        <?php foreach ($loan_category as $loan_categorys): ?>
                                        <option value="<?php echo $loan_categorys->category_id; ?>"><?php echo $loan_categorys->loan_name; ?> / <?php echo $loan_categorys->loan_price; ?> - <?php echo $loan_categorys->loan_perday; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>

                                    
                                  <!--   <div class="col-lg-3 form-group-sub">
                                        <label class="form-control-label">*Group:</label>
                                        <select type="number" name="group_id" class="form-control select2">
                                            <option value="">Select Group</option>
                                            <?php //foreach ($group as $groups): ?>
                                            <option value="<?php //echo $groups->group_id; ?>"><?php //echo $groups->group_name; ?></option>
                                            <?php //endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("employee_menu"); ?>:</span>
                                        <select type="number" name="empl_id" class="form-control select2">
                                            <option value="<?php echo $customer->empl_id; ?>"><?php echo $customer->empl_name; ?></option>
                                            <?php foreach ($mpl_data_blanch as $mpl_data_blanchs): ?>
                                            <option value="<?php echo $mpl_data_blanchs->empl_id; ?>"><?php echo $mpl_data_blanchs->empl_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                                    <input type="hidden" name="blanch_id" value="<?php echo $customer->blanch_id; ?>">

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_amount_appy_menu"); ?>:</span>
                                        <input type="number" name="how_loan" value="<?php echo $reject_skip->how_loan; ?>" placeholder="Loan Amount Applied" autocomplete="off" class="form-control input-sm" required>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("loan_duration_menu"); ?>:</span>
                                    <select type="number" name="day" class="form-control"  required class="form-control input-sm">
                                    <option value="<?php echo $reject_skip->day; ?>">
                                        <?php if ($reject_skip->day == '1') {
                                            echo $this->lang->line("daily_menu");
                                          ?>
                                        <?php }elseif($reject_skip->day == '7'){
                                             echo $this->lang->line("weekly_menu");
                                         ?>
                                         <?php }elseif($reject_skip->day == '30' || $reject_skip->day == '31' || $reject_skip->day == '28' || $reject_skip->day == '29' ){
                                            echo $this->lang->line("monthly_menu");
                                          ?>
                                            <?php } ?>
                                    </option>
                                    <option value="1"><?php echo $this->lang->line("daily_menu") ?></option>
                                    <option value="7"><?php echo $this->lang->line("weekly_menu") ?></option>
                                    <?php 
                                    $month = date("m");
                                     $year = date("Y");
                                     $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                                     ?>
                                    <option value="<?php echo $d; ?>"><?php echo $this->lang->line("monthly_menu") ?></option>
                                    
                                </select>
                                 <input type="hidden" name="loan_status" value="open">
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("number_repayment_menu") ?>:</span>
                                <input type="number" name="session" value="<?php echo $reject_skip->session; ?>" placeholder="Enter Number of Repayments" autocomplete="off" class="form-control input-sm" required>
                                    </div>
                                 
                                 <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("interst_formular_menu") ?>:</b></span>
                                        <select type="number" name="rate" class="form-control" required>
                                            <option value="<?php echo $reject_skip->rate; ?>">
                                                <?php if ($reject_skip->rate == 'SIMPLE') {
                                                 ?>
                                                <?php echo "SIMPLE FORMULAR"; ?>
                                                <?php }elseif ($reject_skip->rate == 'FLAT RATE') {
                                                    echo "FLAT RATE FORMULAR";
                                                 ?>
                                                 <?php }elseif($reject_skip->rate == 'REDUCING'){ ?>
                                                    <?php echo "REDUCING FORMULAR"; ?>
                                                    <?php } ?>
                                            </option>
                                            <?php foreach ($formular as $formulars): ?> 
                                            <option value="<?php echo $formulars->formular_name; ?>"><?php if ($formulars->formular_name == 'SIMPLE') {
                                                 ?>
                                                 SIMPLE FORMULAR
                                                <?php }elseif($formulars->formular_name == 'FLAT RATE'){ ?>
                                                 FLAT RATE FORMULAR
                                                    <?php }elseif ($formulars->formular_name == 'REDUCING') {
                                                     ?>
                                                     REDUCING FORMULAR
                                                     <?php } ?>
                                                        
                                                     </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3 form-group-sub">
                                        <span><b><?php echo $this->lang->line("makato_menu") ?>?:</b></span>
                                        <select type="number" name="fee_status" class="form-control" required>
                                            <option value="<?php echo $reject_skip->fee_status;?>"><?php echo $reject_skip->fee_status;?></option>
                                            <?php if ($loan_fee_category->fee_category == 'GENERAL') {
                                             ?>
                                            <option value="YES"><?php echo $this->lang->line("yes_menu") ?></option>
                                           <!--  <option value="NO">NO</option> -->
                                        <?php }elseif ($loan_fee_category->fee_category == 'LOAN PRODUCT') {
                                         ?>
                                         <option value="NO"><?php echo $this->lang->line("yes_menu") ?></option>
                                         <?php }else{ ?>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 form-group-sub">
                                        <span><?php echo $this->lang->line("reason_loan_menu") ?>:</span>
                                   <input type="text" name="reason" autocomplete="off" value="<?php echo $reject_skip->reason; ?>"  class="form-control input-sm" placeholder="Reason of Applying Loan:" required>
                                    </div> 
                              </div>
                           </div>
                               <br>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("update_menu") ?></i></button>
                        <a href="<?php echo base_url("oficer/collelateral_session/{$reject_skip->loan_id}") ?>" class="btn btn-info btn-elevate btn-pill btn-sm"><?php echo $this->lang->line("skip_menu") ?></a>
                        </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>

               <?php }else{ ?>
                    <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="text-center">
                            <h2>
                                <div class="alert alert-dismisible alert-danger">
                                  OOPS! <?php echo $this->lang->line("clamed_menu"); ?></div></a>
                                  <a href="<?php echo base_url("oficer/loan_application"); ?>" class="btn btn-primary"><?php echo $this->lang->line("back_menu") ?></a>
                              </h2>
                            </div>
                        </div>
                        <div class="body">
                       <div class="row">
                       </div>
                           </div>
                        <br>     
                    </div>
                    </div>
                <?php } ?>
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