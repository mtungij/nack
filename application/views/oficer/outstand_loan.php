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
    <li class="breadcrumb-item active"><?php echo $this->lang->line("report_menu"); ?></li>
    <li class="breadcrumb-item active"><?php echo $this->lang->line("outstand_menu"); ?></li>
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
    <h2><?php echo $this->lang->line("outstand_menu"); ?></h2>
    <div class="pull-right">
        <a href="<?php echo base_url("oficer/default_balance"); ?>" class="btn btn-primary"><i class="icon-pencil"><?php echo $this->lang->line("default_balance_menu") ?> </i></a>
         <a href="<?php echo base_url("oficer/out_ofsyastem"); ?>" class="btn btn-primary"><i class="icon-pencil"><?php echo $this->lang->line("default_outsystem_menu"); ?></i></a>

         <!-- <a href="<?php //echo base_url("oficer/print_default_loan/{$blanch_id}"); ?>" target="_blank" class="btn btn-primary"><i class="icon-printer"></i></a> -->
         <a href="" data-toggle="modal" data-target="#addcontact1" class="btn btn-primary"><i class="icon-calendar"><?php echo $this->lang->line("search_menu"); ?></i></a>
    </div>    
 </div>
  <div class="body">
    <div class="table-responsive">
        <table class="table table-hover js-basic-example dataTable table-custom">
            <thead class="thead-primary">
                <tr>
                <th>S/no.</th>
                <th><?php echo $this->lang->line("customer_name_menu"); ?></th>
                <th><?php echo $this->lang->line("employee_menu"); ?></th>
                <th><?php echo $this->lang->line("loanID_menu"); ?></th>
                <th><?php echo $this->lang->line("loan_category_menu"); ?></th>
                <th><?php echo $this->lang->line("loan_interest_menu"); ?></th>
                <th><?php echo $this->lang->line("loan_with_menu"); ?></th>
                <th><?php echo $this->lang->line("principal_interest_menu"); ?></th>
                <th><?php echo $this->lang->line("account_name"); ?></th>
                <th><?php echo $this->lang->line("loan_duration_menu"); ?></th>
                <th><?php echo $this->lang->line("number_repayment_menu"); ?></th>
                <th><?php echo $this->lang->line("remain_debit_menu"); ?></th>
                <th><?php echo $this->lang->line("with_date_menu"); ?></th>
                <th><?php echo $this->lang->line("end_date_menu"); ?></th>
               <!--  <th>Action</th> -->
                </tr>
            </thead>
           
            <tbody>
               <?php $no = 1 ?>        
        <?php foreach($default_loan as $loan_aproveds): ?>
                <tr>
            <td><?php echo $no++; ?>.</td>
            <td><?php echo $loan_aproveds->f_name; ?> <?php echo substr($loan_aproveds->m_name, 0,1); ?> <?php echo $loan_aproveds->l_name; ?></td>
           <td><?php echo $loan_aproveds->empl_name; ?></td> 
            <td><?php echo $loan_aproveds->loan_code; ?></td>
            <td><?php echo $loan_aproveds->loan_name ?></td>
            <td><?php echo $loan_aproveds->interest_formular; ?>%</td>
            <td><?php echo number_format($loan_aproveds->loan_aprove); ?></td>
            <td><?php echo number_format($loan_aproveds->loan_int); ?></td>
            <td><?php echo $loan_aproveds->account_name; ?></td>
            <td>
       <?php if ($loan_aproveds->day == 1) {
                         echo $this->lang->line("daily_menu");
                     ?>
                    <?php }elseif($loan_aproveds->day == 7){
                          echo $this->lang->line("weekly_menu");
                     ?>
                    
                <?php }elseif($loan_aproveds->day == 30 || $loan_aproveds->day == 31 || $loan_aproveds->day == 29 || $loan_aproveds->day == 28){
                        echo $this->lang->line("monthly_menu"); 
                    ?>
                    <?php } ?>
            </td>

                
        <td><?php echo $loan_aproveds->session; ?> </td> 
        <td><?php echo number_format($loan_aproveds->remain_amount); ?> </td> 
        <td><?php echo $loan_aproveds->loan_stat_date; ?> </td> 
        <td><?php echo substr($loan_aproveds->loan_end_date, 0,10); ?> </td> 

   
         </tr>

    <?php endforeach; ?>
            </tbody>
              <tr>
            <td><b><?php echo $this->lang->line("total_menu"); ?>:</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b><?php //echo number_format($total_loanwith->total_loan_with); ?></b></td>
            <td><b><?php //echo number_format($total_loanwith->total_loan_int); ?></b></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b><?php echo number_format($total_default->total_remain); ?></b></td>
            <td></td>
            <td></td>
         <!--    <td></td> -->
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

<div class="modal fade" id="addcontact1" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="title" id="defaultModalLabel">Filter Default Loan</h6>
</div>
<?php echo form_open("oficer/filter_default_loan"); ?>
<div class="modal-body">
<div class="row clearfix">
<input type="hidden" name="blanch_id" value="<?php echo $_SESSION['blanch_id']; ?>">
<?php $date = date("Y-m-d"); ?>
<div class="col-lg-6 col-6">
<span>From:</span>
<input type="date" name="from" value="<?php echo $date; ?>" class="form-control" requirede>
</div>
<div class="col-lg-6 col-6">
<span>To:</span>
<input type="date" name="to" value="<?php echo $date; ?>" class="form-control" requirede>
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


<div class="modal fade" id="addcontact2" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="title" id="defaultModalLabel">Transfor Amount From Default Account To Branch Account</h6>
</div>
<?php echo form_open("oficer/filter_loan_with"); ?>
<div class="modal-body">
<div class="row clearfix">
<div class="col-lg-4 col-12">
<span>*Default Type:</span>
<select class="form-control" name="deduct_type"  required>
<option value="">Select Loan Type </option>
<option value="outsystem">Default Laon Out of System</option>
<option value="insystem">Default Loan In System</option>
</select>
</div>

<div class="col-lg-4 col-12">
<span>*From Default account:</span>
<select class="form-control " name="to_blanch_account_id" required data-live-search="true">
<option value="">Select Branch Account</option>
<?php foreach ($acount as $acounts): ?>
<option value="<?php echo $acounts->receive_trans_id; ?>"><?php echo $acounts->account_name; ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="col-lg-4 col-12">
<span>*To Branch account:</span>
<select class="form-control " name="to_blanch_account_id" required data-live-search="true">
<option value="">Select Branch Account</option>
<?php foreach ($acount as $acounts): ?>
<option value="<?php echo $acounts->receive_trans_id; ?>"><?php echo $acounts->account_name; ?></option>
<?php endforeach; ?>
</select>
</div>


<div class="col-lg-6 col-6">
<span>*Amount</span>
<input type="number" name="from_mount" autocomplete="off" class="form-control" placeholder="Enter Amount" required>
</div>
<div class="col-lg-6 col-6">
<span>*With/Chargers</span>
<input type="number" name="trans_fee" autocomplete="off" placeholder="Enter Chargers" class="form-control" required>
</div>
<input type="hidden" name="comp_id" value="<?php echo $empl_data->comp_id; ?>">
<input type="hidden" name="user_trans" value="<?php echo $empl_data->empl_id; ?>">
<input type="hidden" name="from_blanch_id" value="<?php echo $empl_data->blanch_id; ?>">
<!-- <input type="hidden" name="empl" value=""> -->
<?php $day = date("Y-m-d"); ?>
<input type="hidden" name=" date_transfor" value="<?php echo $day;?>">

</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary">Save</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>





