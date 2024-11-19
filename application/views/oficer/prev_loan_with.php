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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan_with_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("loan_with_menu"); ?> <?php echo $this->lang->line("from_menu"); ?>:<?php echo $from; ?> <?php echo $this->lang->line("to_menu"); ?>:<?php echo $to; ?></h2>
                            <div class="pull-right">
                                <a href="" data-toggle="modal" data-target="#addcontact2" class="btn btn-primary"><i class="icon-calendar"><?php echo $this->lang->line("search_menu"); ?></i></a>
                            </div>    
                         </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                        <th>S/no.</th>
                                        <th><?php echo $this->lang->line("customer_name_menu"); ?></th>
                                      <!--   <th>Branch Name</th> -->
                                        <th><?php echo $this->lang->line("loanID_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_category_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_interest_menu"); ?></th>
                                        <th><?php echo $this->lang->line("loan_with_menu"); ?></th>
                                        <th><?php echo $this->lang->line("principal_interest_menu"); ?></th>
                                        <th><?php echo $this->lang->line("account_name"); ?></th>
                                        <th><?php echo $this->lang->line("loan_duration_menu"); ?></th>
                                        <th><?php echo $this->lang->line("number_repayment_menu"); ?></th>
                                        <th><?php echo $this->lang->line("restoration_menu"); ?></th>
                                        <th><?php echo $this->lang->line("with_date_menu"); ?></th>
                                        <th><?php echo $this->lang->line("end_date_menu"); ?></th>
                                       <!--  <th>Action</th> -->
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                       <?php $no = 1 ?>        
                                <?php foreach($blanch_previous as $loan_aproveds): ?>
                                        <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $loan_aproveds->f_name; ?> <?php echo substr($loan_aproveds->m_name, 0,1); ?> <?php echo $loan_aproveds->l_name; ?></td>
                                   <!--  <td><?php //echo $loan_aproveds->blanch_name; ?></td> -->
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
                                <td><?php echo number_format($loan_aproveds->restration); ?> </td> 
                                <td><?php echo $loan_aproveds->loan_stat_date; ?> </td> 
                                <td><?php echo substr($loan_aproveds->loan_end_date, 0,10); ?> </td> 

                           
                                 </tr>

                            <?php endforeach; ?>
                                
                                    </tbody>
                                    <tr>
                                    <td><b>TOTAL:</b></td>
                                    <td></td>
                                   <!--  <td></td> -->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b><?php echo number_format($total_loan_with->total_loan); ?></b></td>
                                    <td><b><?php echo number_format($total_loan_with->total_interest); ?></b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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


<div class="modal fade" id="addcontact2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("search_menu"); ?></h6>
            </div>
            <?php echo form_open("oficer/filter_loan_with"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-6 col-6">
                        <?php $date = date("Y-m-d"); ?>
                        <span><?php echo $this->lang->line("from_menu"); ?>:</span>
                       <input type="date" name="from" value="<?php echo $date; ?>" class="form-control">
                    </div>
                      <div class="col-md-6 col-6">
                        <span><?php echo $this->lang->line("to"); ?>:</span>
                       <input type="date" name="to" value="<?php echo $date; ?>" class="form-control">
                    </div>

                    <input type="hidden" name="loan_status" value="withdrawal">
                    <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">
                   
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



