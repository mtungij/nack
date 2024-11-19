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
                            
                            <li class="breadcrumb-item active">Teller</li>
                            <li class="breadcrumb-item active">Customer Loan Information</li>
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
                                    <!-- <i class="fa fa-thumbs-up"></i> -->
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
                                   <!--  <i class="fa fa-star"></i> -->
                                   <div class="profile-image"> <img src="<?php echo base_url().'assets/img/sig.jpg'; ?>" class="rounded-circle" alt="Gualantors image" style="width: 130px;height: 135px;">
                                      </div>
                                    <small>Gualantors Picture</small>
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
                                        <th>Phone Number</th>
                                        <th>Customer ID</th>
                                        <th>Withdrawal Date</th>
                                        <th>End Date</th>
                                        <th>Loan Amount</th>
                                        <th>Restoration</th>
                                        <th>Amount Paid</th>
                                        <th>Remaining debt</th>
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
                                                <?php if ($customer_loan->loan_status == 'withdrawal' || $customer_loan->loan_status == 'done' || $customer_loan->loan_status == 'out') {
                                                 ?>
                                        <?php echo @$customer->customer_code; ?>
                                             <?php }else{ ?>
                                                  C-(XXXXXX)
                                                <?php } ?>
                                                    
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
                                       <th>Opening</th>
                                        <th>Deposit</th>
                                        <th>Withdrawal</th>
                                        <th>Closing</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                
                                      
                                        <tr>
                                            <td><?php echo number_format($yesterday_balance->total_yesterday_Balance); ?></td>
                                            <td><?php echo number_format($today_deposit->total_deposit); ?></td>
                                            <td><?php echo number_format($loanwith->total_loan_with); ?></td>
                                            <td><?php echo number_format($balance_blanch->today_cash); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>



                  <div class="col-lg-12">
                    <div class="card">
                        <?php echo form_open("admin/search_customerData"); ?>
                            <div class="sam">
                                
                                <select type="number" class="form-control select2" name="customer_id" required>
                                    <option>Search Customer</option>
                                    <?php foreach ($customery as $customer_datas): ?>
                                    <option value="<?php echo $customer_datas->customer_id; ?>"><?php echo $customer_datas->f_name; ?> <?php echo $customer_datas->m_name; ?> <?php echo $customer_datas->l_name; ?> / <?php echo $customer_datas->customer_code; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="icon-magnifier-add">Search</i></button>
                                
                            </div>
                            <?php echo form_close(); ?>
                          <div class="body">
                             <div class="pull-right">
                                <?php if (@$customer_loan->loan_status == 'withdrawal' || @$customer_loan->loan_status == 'out') {
                                 ?>
                             <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addcontact1"><i class="icon-pencil">Deposit</i></a>
                         <?php }elseif (@$customer_loan->loan_status == 'disbarsed') {
                          ?>
                             <a href="" class="btn btn-success" data-toggle="modal" data-target="#addcontact2"><i class="icon-pencil">Withdrawal</i></a> 
                             <?php }elseif(@$customer_loan->loan_status == 'done'){ ?>
                                <a href="" class="btn btn-info" data-toggle="modal" data-target="#addcontact3"><i class="icon-pencil">Faini</i></a> 
                             <?php } ?>   
                                
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
                                
                                      <?php @$loan_desc = $this->queries->get_total_pay_description($customer_loan->loan_id);
                                      @$remain_balance = $this->queries->get_total_remain_with($customer_loan->loan_id);
                                      @$total_recovery = $this->queries->get_total_loan_pend($customer_loan->loan_id);
                                      @$total_penart =   $this->queries->get_total_penart_loan($customer_loan->loan_id);
                                      @$total_deposit_penart =  $this->queries->get_total_paypenart($customer_loan->loan_id);
                                      @$end_deposit = $this->queries->get_end_deposit_time($customer_loan->loan_id);
                                       ?>

                                    <?php //print_r($end_deposit); ?>

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
                <h7 class="title" id="defaultModalLabel"><?php echo $customer->f_name; ?> <?php echo $customer->m_name; ?> <?php echo $customer->l_name; ?><br>With Date:<?php if (@$customer_loan->loan_stat_date == TRUE) {
                                                 ?>
                                                <?php echo @$customer_loan->loan_stat_date; ?>
                                            <?php }elseif (@$customer_loan->loan_stat_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?> - End Date:  <?php if (@$customer_loan->loan_end_date == TRUE) {
                                                 ?>
                                                 <?php echo substr(@$customer_loan->loan_end_date, 0,10); ?>
                                            <?php }elseif (@$customer_loan->loan_end_date == FALSE) {
                                             ?>
                                             YY-MM-DD
                                             <?php } ?> <br> End Deposit Amount : <?php echo number_format(@$end_deposit->depost); ?> <br>Deposit Time : <?php echo @$end_deposit->deposit_day; ?></h7>
            </div>
            <?php echo form_open("admin/deposit_loan/{$customer->customer_id}"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-4 col-6">
                    <span>Total Loan</span>
                    <input type="text" class="form-control" value="<?php echo number_format(@$customer_loan->loan_int); ?>" readonly>     
                    </div>
                     <div class="col-md-4 col-6">
                    <span>Amount Paid</span>
                    <input type="text" class="form-control" value="<?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                        <?php echo number_format(@$customer_loan->loan_int); ?>
                                         (<?php echo number_format(@$total_deposit->total_Deposit - @$customer_loan->loan_int); ?>)
                                             <?php }else{ ?><?php echo number_format(@$total_deposit->total_Deposit); ?>
                                                 <?php } ?>" readonly>     
                    </div>
                     <div class="col-md-4 col-12">
                    <span>Remain Debit</span>
                    <input type="text" class="form-control" value="<?php if (@$total_deposit->total_Deposit > @$customer_loan->loan_int) {
                                                 ?>
                                                 0.00
                                                 <?php }else{ ?><?php echo number_format(@$customer_loan->loan_int - @$total_deposit->total_Deposit ); ?>
                                                <?php } ?>" readonly>     
                    </div>
                     <div class="col-md-6 col-6">
                   
                     <?php if ($customer_loan->loan_status == 'withdrawal') {
                      ?>
                <span>Recovery Amount</span>
                    <input type="text" class="form-control" value="<?php echo number_format($total_recovery->total_pending); ?>.00" readonly style="color:red"> 
                <?php }elseif ($customer_loan->loan_status == 'out') {
                 ?>
                  <span style="color:red;">Default Amount</span>
                <input type="text" class="form-control" value="<?php echo number_format($out_stand->total_out); ?>.00" readonly style="color:red"> 
                 <?php }else{ ?>
                    <span>Recovery Amount</span>
                    <input type="text" class="form-control" value="0.00" readonly style="color:red"> 
                    <?php } ?>

                    </div>

                    <div class="col-md-6 col-6">
                    <span>Penart</span>
                    <input type="text" class="form-control" value="<?php echo number_format($total_penart->total_penart - $total_deposit_penart->total_penart_paid); ?>.00" readonly style="color:red">     
                    </div>
                    <div class="col-md-6 col-6">
                    <span>Deposit </span>
                    <!-- <input type="number" class="form-control" name="depost" placeholder="Enter Deposit Amount" required>      -->
                    <input x-mask:dynamic="$money($input)" name="depost" class="form-control">  
                    </div>
                    <div class="col-md-6 col-6">
                    <span>Select Account:</span>
                    <select type="number" class="form-control" name="p_method" required>
                        <option value="">---Select Account---</option>
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
                    <span>Deposit Date</span>
                    <input type="date"  class="form-control" value="<?php echo $date; ?>" name="deposit_date" required>       
                    </div>
                   
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Deposit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
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
            <?php echo form_open("admin/create_withdrow_balance/{$customer->customer_id}"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-6 col-6">
                    <span>Total Withdrawal</span>
                    <input type="number" class="form-control" name="withdrow" value="<?php echo $remain_balance->balance; ?>" readonly>     
                    </div>
                    <div class="col-md-6 col-6">
                    <span>Select Account:</span>
                    <select type="number" class="form-control" name="method" required>
                        <option value="">---Select Account---</option>
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
                     <!-- <div class="col-md-4 col-6"> -->
                    <!-- <span>Code</span> -->
                    <!-- <input type="hidden" class="form-control" name="code" value="1" placeholder="Enter Code" required>      -->
                   <!--  </div> -->
                    <?php $date = date("Y-m-d"); ?>
                    <div class="col-md-6 col-6">
                    <span>withdrawal Date</span>
                    <input type="date" readonly class="form-control" value="<?php echo $date; ?>" name="with_date" required>       
                    </div>
                     <div class="col-md-6 col-6">
                    <span>code</span>
                    <input type="number" autocomplete="off" class="form-control" placeholder="Enter code" name="code" required>       
                    </div>
                   
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Withdrawal</button>
               <a href="<?php echo base_url("admin/get_loan_code_resend/{$customer->customer_id}") ?>" class="btn btn-primary">Resend Code</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>



 <div class="modal fade" id="addcontact3" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Taarifa Ya Faini</h6>
            </div>
            <?php echo form_open("admin/samehe_faini/{$customer->customer_id}"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-6 col-6">
                    <span>Jumla ya Faini </span>
                    <input type="text" style="color: red" readonly class="form-control" value="<?php echo number_format($total_penart->total_penart); ?>.00" required>     
                    </div>
                     <div class="col-md-6 col-6">
                    <span>Faini Aliyo lipa </span>
                    <input type="text" style="color: red" readonly class="form-control" value="<?php echo number_format($total_deposit_penart->total_penart_paid); ?>.00" required>     
                    </div>
                    <div class="col-md-12 col-12">
                    <span>Faini Iliyo Baki Kulipwa </span>
                    <input type="text" style="color: red" readonly class="form-control" value="<?php echo number_format($total_penart->total_penart - $total_deposit_penart->total_penart_paid); ?>.00" required>     
                    </div>
                    
                    <input type="hidden" value="<?php echo $customer_loan->loan_id; ?>" name="loan_id">
                    <input type="hidden" value="<?php echo $customer->customer_id; ?>" name="customer_id">
                    <input type="hidden" value="<?php echo $customer->comp_id; ?>" name="comp_id">
                    <input type="hidden" value="<?php echo $customer->blanch_id; ?>" name="blanch_id">
                    
                   
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Samehe</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Funga</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>







