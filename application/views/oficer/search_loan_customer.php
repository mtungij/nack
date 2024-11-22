<?php include('incs/header.php'); ?>
<?php include('incs/nav.php'); ?>
<?php include('incs/side.php'); ?>

    <div id="main-content" class="profilepage_2 blog-page">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url("oficer/index"); ?>"><i class="icon-home"></i></a></li>
                            
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("teller_menu") ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("customer_profile_menu") ?></li>
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
                <div class="col-lg-12 col-md-12">

                    <div class="card">
                        <div class="row profile_state">
                            <div class="col-lg-6 col-6">
                                <div class="body">
                                   <!--  <i class="fa fa-thumbs-up"></i> -->
                                   <?php if ($customer->passport == TRUE) {
                                     ?>
                                <div class="profile-image"> <img src="<?php echo base_url().$customer->passport; ?>" class="rounded-circle" alt="customer image" style="width: 130px;height: 130px;">
                                      </div>
                                 <?php }else{ ?>
                                <div class="profile-image"> <img src="<?php echo base_url().'assets/img/male.jpeg'; ?>" class="rounded-circle" alt="customer image" style="width: 130px;height: 130px;">
                                      </div>
                                    <?php } ?>
                                    <small><?php echo @$customer->f_name; ?> <?php echo @$customer->m_name; ?> <?php echo @$customer->l_name; ?></small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="body">
                                    <!-- <i class="fa fa-star"></i> -->
                                   <div class="profile-image"> <img src="<?php echo base_url().'assets/img/sig.jpg'; ?>" class="rounded-circle" alt="Gualantors image" style="width: 130px;height: 130px;">
                                      </div>
                                    <small><?php echo $this->lang->line("signature_menu") ?></small>
                                </div>
                            </div>
                           
                            
                        </div>
                    </div>
                </div>

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
                                        <th><?php echo $this->lang->line("phone_number_menu"); ?></th>
                                        <th><?php echo $this->lang->line("customerId_menu"); ?></th>
                                        <th><?php echo $this->lang->line("with_date_menu"); ?></th>
                                        <th><?php echo $this->lang->line("end_date_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_amount_appy_menu"); ?></th>
                                        <th><?php echo $this->lang->line("restoration_menu"); ?></th>
                                        <th><?php echo $this->lang->line("amount_paid_menu"); ?></th>
                                        <th><?php echo $this->lang->line("remain_debit_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                
                                      <?php @$customer_loan = $this->queries->get_loan_active_customer($customer->customer_id);
                                         @$total_deposit = $this->queries->get_total_amount_paid_loan($customer_loan->loan_id);

                                         @$out_stand = $this->queries->get_outstand_loan_customer($customer_loan->loan_id);
                                       ?>



                                   <?php //print_r($out_stand); ?>
                                        <tr>
                                            <td><?php echo @$customer->phone_no; ?></td>

                                            <td>
                                                <<?php if (@$customer_loan == FALSE) {
                                                 ?>
                                                 C-(XXXXXX)
                                             <?php }else{ ?>
                                            <?php if (@$customer_loan->loan_status == 'withdrawal' || $customer_loan->loan_status == 'done' || $customer_loan->loan_status == 'out') {
                                                 ?>
                                        <?php echo @$customer->customer_code; ?>
                                             <?php }else{ ?>
                                                  C-(XXXXXX)
                                                <?php }} ?> 
                                             </td>
                                            <td>
                                            <?php if (@$customer_loan->loan_stat_date == TRUE) {
                                                 ?>
                                                <?php echo @$customer_loan->loan_stat_date; ?>
                                            <?php }elseif (@$customer_loan->loan_stat_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?>
                                                    
                                                </td>
                                            <td>
                                            <?php if (@$customer_loan->loan_end_date == TRUE) {
                                                 ?>
                                                 <?php echo substr(@$customer_loan->loan_end_date, 0,10); ?>
                                            <?php }elseif (@$customer_loan->loan_end_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?>
                                                </td>
                                            <td><?php echo number_format(@$customer_loan->loan_int); ?></td>
                                            <td><?php echo number_format(@$customer_loan->restration); ?></td>
                                            <td>
                                        <?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                        <?php echo number_format(@$customer_loan->loan_int); ?>
                                         <span style="color: red">(<?php echo number_format(@$total_deposit->total_Deposit - @$customer_loan->loan_int); ?>)<span>
                                             <?php }else{ ?>
                                                <?php echo number_format(@$total_deposit->total_Deposit); ?>
                                                <?php } ?>   
                                                </td>
                                            <td>
                                                <?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                                 0.00
                                                 <?php }else{ ?>
                                                <?php echo number_format(@$customer_loan->loan_int - @$total_deposit->total_Deposit ); ?>
                                                <?php } ?>
                                                    
                                                </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="card">
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover j-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                       <th><?php echo $this->lang->line("opening_menu"); ?></th>
                                        <th><?php echo $this->lang->line("deposit_menu"); ?></th>
                                        <th><?php echo $this->lang->line("withdrawal_menu"); ?></th>
                                        <th><?php echo $this->lang->line("closing_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                
                                      
                                        <tr>
                                            <td><?php //echo $customer->phone_no; ?>0.00</td>
                                            <td><?php //echo $customer->phone_no; ?>0.00</td>
                                            <td><?php //echo $customer->empl_name; ?>0.00</td>
                                            <td><?php //echo $customer->blanch_name; ?>0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>



                  <div class="col-lg-12">
                    <div class="text-center">
                                        <img id="loaderIcon" style="visibility:hidden; display:none;width: 60px; height: 60px;"
                                    src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="Please wait" />
                                </div>
                    <?php echo form_open("oficer/search_customerData",['id'=>'login_form']); ?>
                            <div class="sam">
                                <select type="number" class="form-control select2" name="customer_id" required>
                                    <option><?php echo $this->lang->line("search_customer_menu"); ?></option>
                                            <?php foreach ($customery as $customer_datas): ?>          
                                    <option value="<?php echo $customer_datas->customer_id; ?>">
                                             <?php echo strtoupper($customer_datas->f_name . ' ' . $customer_datas->m_name . ' ' . $customer_datas->l_name . ' / ' . $customer_datas->customer_code); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="icon-magnifier-add"><?php echo $this->lang->line("search_menu"); ?></i></button>
                                
                            </div>
                            <?php echo form_close(); ?>
                    <div class="card">

                          <div class="body">

                             <div class="pull-right">
                                <?php if (@$customer_loan->loan_status == 'withdrawal' || @$customer_loan->loan_status == 'out') {
                                 ?>
                             <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addcontact1"><i class="icon-pencil"><?php echo $this->lang->line("deposit_menu"); ?></i></a>
                         <?php }elseif (@$customer_loan->loan_status == 'disbarsed') {
                          ?>
                             <a href="" class="btn btn-success" data-toggle="modal" data-target="#addcontact2"><i class="icon-pencil"><?php echo $this->lang->line("withdrawal_menu"); ?></i></a> 
                             <?php }else{ ?>
                             <?php } ?>   
                            <!--  <a href="" class="btn btn-info" data-toggle="modal" data-target="#addcontact3"><i class="icon-pencil">Adjust</i></a> -->    
                             </div>
                            <div class="table-responsive">
                                <table class="table table-hover j-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                        <th><?php echo $this->lang->line("date_menu"); ?></th>
                                        <th><?php echo $this->lang->line("description_menu"); ?></th>
                                        <th><?php echo $this->lang->line("deposit_menu"); ?></th>
                                        <th><?php echo $this->lang->line("withdrawal_menu"); ?></th>
                                        <th><?php echo $this->lang->line("balance_menu"); ?></th> 
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                
                                      <?php @$loan_desc = $this->queries->get_total_pay_description($customer_loan->loan_id);
                                      @$remain_balance = $this->queries->get_total_remain_with($customer_loan->loan_id);
                                      @$total_recovery = $this->queries->get_total_loan_pend($customer_loan->loan_id);
                                      @$total_penart =   $this->queries->get_total_penart_loan($customer_loan->loan_id);
                                      @$total_deposit_penart =  $this->queries->get_total_paypenart($customer_loan->loan_id);
                                      @$end_deposit = $this->queries->get_end_deposit_time($customer_loan->loan_id);
                                      @$today_dep = $this->queries->get_end_deposit_time_date($customer_loan->loan_id);
                                       ?>

                                    <?php //print_r($today_dep); ?>

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
                                    <?php } ?><?php echo $payisnulls->session; ?>  / AC/No. <?php echo @$payisnulls->loan_code; ?></td>
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

 <div class="modal fade" id="addcontact1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h7 class="title" id="defaultModalLabel"><?php echo $customer->f_name; ?> <?php echo $customer->m_name; ?> <?php echo $customer->l_name; ?><br><?php echo $this->lang->line("with_date_menu"); ?>:<?php if (@$customer_loan->loan_stat_date == TRUE) {
                                                 ?>
                                                <?php echo @$customer_loan->loan_stat_date; ?>
                                            <?php }elseif (@$customer_loan->loan_stat_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?> - <?php echo $this->lang->line("end_date_menu"); ?>:  <?php if (@$customer_loan->loan_end_date == TRUE) {
                                                 ?>
                                                 <?php echo substr(@$customer_loan->loan_end_date, 0,10); ?>
                                            <?php }elseif (@$customer_loan->loan_end_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?> <br> <?php echo $this->lang->line("end_deposit_amount_menu"); ?> : <?php echo number_format(@$end_deposit->depost); ?> <br><?php echo $this->lang->line("deposit_date_menu") ?> : <?php echo @$end_deposit->deposit_day; ?></h7>
            </div>
                                     <div class="text-center">
                                        <img id="loaderIcons" style="visibility:hidden; display:none;width: 100px; height: 100px;"
                                    src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="Please wait" />
                                </div>
            <?php echo form_open("oficer/deposit_loan/{$customer->customer_id}",['id'=>'login_data']); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-4 col-6">
                    <span><?php echo $this->lang->line("total_loan_menu"); ?></span>
                    <input type="text" class="form-control" value="<?php echo number_format(@$customer_loan->loan_int); ?>" readonly>     
                    </div>
                     <div class="col-md-4 col-6">
                    <span><?php echo $this->lang->line("amount_paid_menu"); ?></span>
                    <input type="text" class="form-control" value="<?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                        <?php echo number_format(@$customer_loan->loan_int); ?>
                                         (<?php echo number_format(@$total_deposit->total_Deposit - @$customer_loan->loan_int); ?>)
                                             <?php }else{ ?><?php echo number_format(@$total_deposit->total_Deposit); ?>
                                                 <?php } ?>" readonly>     
                    </div>
                     <div class="col-md-4 col-12">
                    <span><?php echo $this->lang->line("remain_debit_menu"); ?></span>
                    <input type="text" class="form-control" value="<?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                                 0.00
                                                 <?php }else{ ?><?php echo number_format(@$customer_loan->loan_int - @$total_deposit->total_Deposit ); ?>
                                                <?php } ?>" readonly>     
                    </div>
                     <div class="col-md-6 col-6">
                   
                     <?php if ($customer_loan->loan_status == 'withdrawal') {
                      ?>
                <span><?php echo $this->lang->line("recovery_menu"); ?></span>
                    <input type="text" class="form-control" value="<?php echo number_format($total_recovery->total_pending); ?>.00" readonly style="color:red"> 
                <?php }elseif ($customer_loan->loan_status == 'out') {
                 ?>
                  <span style="color:red;"><?php echo $this->lang->line("outstand_menu"); ?></span>
                <input type="text" class="form-control" value="<?php echo number_format($out_stand->total_out); ?>.00" readonly style="color:red"> 
                 <?php }else{ ?>
                    <span><?php echo $this->lang->line("recovery_menu"); ?></span>
                    <input type="text" class="form-control" value="0.00" readonly style="color:red"> 
                    <?php } ?>

                    </div>

                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("penart_menu"); ?></span>
                    <input type="text" class="form-control" value="<?php echo number_format($total_penart->total_penart - $total_deposit_penart->total_penart_paid); ?>.00" readonly style="color:red">     
                    </div>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("deposit_amount_menu"); ?> </span>
                    <!-- <input type="number" class="form-control" name="depost" placeholder="<?php //echo $this->lang->line("deposit_amount_menu"); ?>" required> -->
                    <input x-mask:dynamic="$money($input)" placeholder="<?php echo $this->lang->line("deposit_amount_menu"); ?>" name="depost" class="form-control">     
                    </div>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("Account_menu"); ?>:</span>
                    <select type="number" class="form-control" name="p_method" required>
                        <option value="">---<?php echo $this->lang->line("select_menu"); ?>---</option>
                        <?php foreach ($acount as $acounts): ?>
                        <option value="<?php echo $acounts->trans_id; ?>"><?php echo $acounts->account_name; ?></option>
                        <?php endforeach; ?>
                    </select>           
                    </div>
                    <input type="hidden" value="<?php echo $customer->customer_id; ?>" name="customer_id">
                    <input type="hidden" value="<?php echo $customer->comp_id; ?>" name="comp_id">
                    <input type="hidden" value="<?php echo $customer->blanch_id; ?>" name="blanch_id">
                    <input type="hidden" value="<?php echo $customer_loan->loan_id; ?>" name="loan_id">
                     <input type="hidden" value="LOAN RETURN" name="description">
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-12 col-12">
                    <span><?php echo $this->lang->line("deposit_date_menu"); ?></span>
                    <input type="date" class="form-control" value="<?php echo $date; ?>" readonly name="deposit_date" required>       
                    </div>
                   
            </div>
            </div>
            <div class="modal-footer">
                 <?php if (@$today_dep->deposit_day == TRUE) {
                  ?>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you Sure To Deposit Again?')"><?php echo $this->lang->line("deposit_menu"); ?></button>
              <?php }elseif(@$today_dep->deposit_day == FALSE){ ?>
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("deposit_menu"); ?></button>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



 <div class="modal fade" id="addcontact2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $customer->f_name; ?> <?php echo $customer->m_name; ?> <?php echo $customer->l_name; ?></h6>


            </div>
                               <div class="text-center">
                                        <img id="loaderIconwith" style="visibility:hidden; display:none;width: 100px; height: 100px;"
                                    src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif" alt="Please wait" />
                                </div>
            <?php echo form_open("oficer/create_withdrow_balance/{$customer->customer_id}",['id'=>'login_with']); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("total_with_menu"); ?></span>
                    <input type="number" class="form-control" name="withdrow" value="<?php echo $remain_balance->balance; ?>" readonly>     
                    </div>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("Account_menu"); ?>:</span>
                    <select type="number" class="form-control" name="method" required>
                        <option value="">---<?php echo $this->lang->line("select_menu"); ?>---</option>
                        <?php foreach ($acount as $acounts): ?>
                        <option value="<?php echo $acounts->trans_id; ?>"><?php echo $acounts->account_name; ?></option>
                        <?php endforeach; ?>
                    </select>            
                    </div>

                     <input type="hidden" value="CASH WITHDRAWALS" name="description">
                    <input type="hidden" value="withdrawal" name="loan_status">
                    <input type="hidden" value="<?php echo $customer_loan->loan_id; ?>" name="loan_id">

                    <input type="hidden" value="<?php echo $customer->customer_id; ?>" name="customer_id">
                    <input type="hidden" value="<?php echo $customer->comp_id; ?>" name="comp_id">
                    <input type="hidden" value="<?php echo $customer->blanch_id; ?>" name="blanch_id">
                    <!-- <input type="hidden" class="form-control" name="code" value="1" required>      -->
                    
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6 col-6">
                    <span><?php echo $this->lang->line("with_date_menu") ?></span>
                    <input type="date"  class="form-control" value="<?php echo $date; ?>" name="with_date" required>       
                    </div>
                     <div class="col-md-6 col-6">
                    <span>code number</span>
                    <input type="number" autocomplete="off" class="form-control" placeholder="Enter code" name="code" required>       
                    </div>
                   
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("withdrawal_menu"); ?></button>
               <a href="<?php echo base_url("oficer/get_loan_code_resend/{$customer->customer_id}") ?>" class="btn btn-primary">Resend Code</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('#login_form').submit(function() {
            $('#loaderIcon').css('visibility', 'visible');
            $('#loaderIcon').show();
        });
    })
</script>

<script>
    $(document).ready(function(){
        $('#login_data').submit(function() {
            $('#loaderIcons').css('visibility', 'visible');
            $('#loaderIcons').show();
        });
    })
</script>

<script>
    $(document).ready(function(){
        $('#login_with').submit(function() {
            $('#loaderIconswith').css('visibility', 'visible');
            $('#loaderIconswith').show();
        });
    })
</script>



 







