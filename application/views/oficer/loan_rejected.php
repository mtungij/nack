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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan") ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan_rejected_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("loan_rejected_menu"); ?> </h2>    
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                    <th>S/No.</th>
                                    <th><?php echo $this->lang->line("loanID_menu"); ?></th>
                                    <th><?php echo $this->lang->line("customer_name_menu"); ?></th>
                                    <th><?php echo $this->lang->line("phone_number_menu"); ?></th>
                                    <!-- <th>Busines/Job Name</th> -->
                                    <th><?php echo $this->lang->line("branch_menu"); ?></th>
                                    <th><?php echo $this->lang->line("loan_amount_appy_menu"); ?></th>
                                    <th><?php echo $this->lang->line("loan_duration_menu"); ?></th>
                                    <th><?php echo $this->lang->line("number_repayment_menu"); ?></th>
                                    <th><?php echo $this->lang->line("status_loan_menu"); ?></th>
                                    <th><?php echo $this->lang->line("status_customer_menu"); ?></th>
                                   <!--  <th>Action</th> -->
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1; ?>
                                               <?php $no = 1; ?>
                                    <?php foreach($loan_reject as $loan_pendings): ?>
                                   <?php
                                   @$customer_condition = $this->queries->get_borrowe_alert($loan_pendings->customer_id);
                                              // echo "<pre>";
                      //                 print_r($customer_condition);
                      //                     exit();
                                    ?>
                                              <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $loan_pendings->loan_code; ?></td>
                                    <td><?php echo $loan_pendings->f_name; ?> <?php echo substr($loan_pendings->m_name, 0,1); ?> <?php echo $loan_pendings->l_name; ?></td>
                                    <td><?php echo $loan_pendings->phone_no; ?></td>
                                    <!-- <td><?php //echo $loan_pendings->bussiness_type; ?></td> -->
                                    <td><?php echo $loan_pendings->blanch_name; ?></td>
                                        <td><?php echo number_format($loan_pendings->how_loan); ?></td>
                                        <td>
                                            <?php if ($loan_pendings->day == 1) {
                                                 echo $this->lang->line("daily_menu");
                                             ?>
                                            <?php }elseif($loan_pendings->day == 7){
                                                  echo $this->lang->line("weekly_menu");
                                             ?>
                                            
                                        <?php }elseif($loan_pendings->day == 30 || $loan_pendings->day == 31 || $loan_pendings->day == 29 || $loan_pendings->day == 28){
                                                echo $this->lang->line("monthly_menu"); 
                                            ?>
                                            <?php } ?>
                                                
                                            </td>
                                        <td><?php echo $loan_pendings->session; ?></td>
                                        <td>
                                       
                                         <a href="#" class="badge badge-danger"><?php echo $this->lang->line("rejected_menu"); ?></a>
                                        
                                         
                                        </td>
                                        <td>
                                            <?php if (@$customer_condition->total_loan == 1) {
                                             ?>
                                            <span class="badge badge-success"><?php echo $this->lang->line("new_customer_menu"); ?></span>
                                            <?php }else{ ?>
                                            <?php //echo $customer_condition->total_loan; ?>
                                            <span class="badge badge-warning"><?php echo $this->lang->line("old_customer_menu"); ?></span>
                                            <?php } ?>
                                                
                                            </td>   
                  <!--                           <td>
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="<?php //echo base_url("oficer/view_Dataloan/{$loan_pendings->customer_id}/{$loan_pendings->comp_id}") ?>"><i class="icon-eye">view</i></a>
                    
                  <a class="dropdown-item" href="<?php //echo base_url("oficer/reject_loan/{$loan_pendings->loan_id}") ?>" onclick="return confirm('Are You Sure?')"><i class="icon-trash">Reject</i></a>

                     <a class="dropdown-item" href="<?php //echo base_url("oficer/delete_loan/{$loan_pendings->loan_id}") ?>" onclick="return confirm('Are you sure?')"><i class="icon-trash">Delete</i></a>
                    </div>
                </div>
                </div>
                                            </td> -->
                                            
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
</div>

<?php include('incs/footer.php'); ?>


