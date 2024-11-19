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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("received_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("received_loan_menu"); ?></h2>
                            <div class="pull-right">
                             <!--    <a href="" data-toggle="modal" data-target="#addcontact2" class="btn btn-primary"><i class="icon-calendar">Today Receivable</i></a> -->
                             <a href="" class="btn btn-primary btn-sm"><i class="icon-printer"><?php echo $this->lang->line("print_menu"); ?></i></a>
                            </div>    
                         </div>
                          <div class="body">

                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                        <th>S/no.</th>
                                        <th><?php echo $this->lang->line("customer_name_menu"); ?></th>
                                        <th><?php echo $this->lang->line("phone_number_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_amount_appy_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_duration_menu"); ?></th>
                                        <th><?php echo $this->lang->line("received_loan_menu"); ?></th>
                                        <th><?php echo $this->lang->line("Account_menu"); ?></th>
                                        <th><?php echo $this->lang->line("employee_menu"); ?></th>
                                        <th><?php echo $this->lang->line("deposit_day_menu"); ?></th>
                                        <th><?php echo $this->lang->line("date_menu"); ?> & <?php echo $this->lang->line("time_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php $no = 1 ?>        
                                <?php foreach($received as $loan_pending_new): ?>
                                        <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $loan_pending_new->f_name; ?> <?php echo $loan_pending_new->m_name; ?> <?php echo $loan_pending_new->l_name; ?></td>
                                   <!--  <td><?php //echo $loan_aproveds->blanch_name; ?></td> -->
                                    <td><?php echo $loan_pending_new->phone_no; ?></td>
                                    <td><?php echo number_format($loan_pending_new->loan_int) ?></td>
                                    <td>
                                        <?php if ($loan_pending_new->day == 1) {
                                                 echo "Daily";
                                             ?>
                                            <?php }elseif($loan_pending_new->day == 7){
                                                  echo "Weekly";
                                             ?>
                                            
                                        <?php }elseif($loan_pending_new->day == 30 || $loan_pending_new->day == 31 || $loan_pending_new->day == 29 || $loan_pending_new->day == 28){
                                                echo "Monthly"; 
                                            ?>
                                            <?php } ?>
                                    </td>
                                    <td><?php echo number_format($loan_pending_new->depost); ?></td>
                                   
                                  
                                    <td>
                                 <?php echo $loan_pending_new->account_name; ?>
                                    </td>
                                       <td>
                                 <?php echo $loan_pending_new->empl_name; ?>
                                    </td>
                                    <td><?php echo $loan_pending_new->depost_day; ?></td>
                                    <td><?php echo $loan_pending_new->deposit_day; ?></td>
                    
                                 </tr>

                            <?php endforeach; ?>
                                <tr>
                                    <td><b>TOTAL:</b></td>
                                    <td></td>
                                   <!--  <td></td> -->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b><?php echo number_format($total_receved->total_depost); ?></b></td>
                                    <td><b><?php //echo number_format($total_loanwith->total_loan_int); ?></b></td>
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




