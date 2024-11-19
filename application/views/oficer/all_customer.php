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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("customer_menu"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("all_customer_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("all_customer_menu"); ?></h2>    
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                           <th>S/No.</th>
                                            <!-- <th><?php //echo $this->lang->line("customerId_menu"); ?></th> -->
                                            <th><?php echo $this->lang->line("customername_menu"); ?></th>
                                            <th><?php echo $this->lang->line("date_birth_menu"); ?></th>
                                            <th><?php echo $this->lang->line("year_customer_menu"); ?></th>
                                            <th><?php echo $this->lang->line("gender_menu"); ?></th>
                                            <th><?php echo $this->lang->line("phone_number_menu"); ?></th>
                                            <!-- <th>Branch</th> -->
                                            <th><?php echo $this->lang->line("district_menu"); ?></th>
                                            <th><?php echo $this->lang->line("ward_menu"); ?></th>
                                            <th><?php echo $this->lang->line("street_menu"); ?></th>
                                            <th><?php echo $this->lang->line("status_menu"); ?></th>
                                            <th><?php echo $this->lang->line("action_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach($customer  as $customers): ?>
                                        <tr>
                                            <td><?php echo $no++; ?>.</td>
                                            <!-- <td><?php //echo $customers->customer_code; ?></td> -->
                                            <td><?php echo $customers->f_name; ?> <?php echo $customers->m_name; ?> <?php echo $customers->l_name; ?></td>
                                            <td><?php echo $customers->date_birth; ?></td>
                                            <td><?php if ($customers->age == TRUE) {
                                             ?>
                                             <?php echo $customers->age; ?>
                                            <?php }else{ ?>
                                                -
                                              <?php } ?>
                                            </td>
                                            <td><?php echo $customers->gender; ?></td>
                                            <td><?php echo $customers->phone_no; ?></td>
                                            <!-- <td><?php //echo $customers->blanch_name; ?></td> -->
                                            <td><?php echo $customers->district; ?></td>
                                            <td><?php echo $customers->ward; ?></td>
                                            <td><?php echo $customers->street; ?></td>
                                            <td>
                                                <?php if ($customers->customer_status == 'open') {
                                             ?>
                                             <a href="#" class="badge badge-success">Active</a>
                                            <?php }elseif ($customers->customer_status == 'close') {
                                             ?>
                                             <a href="#" class="badge badge-primary">Closed</a>
                                             <?php }elseif($customers->customer_status == 'pending'){
                                              ?>
                                              <a href="#" class="badge badge-warning">Pending</a>
                                              <?php }elseif ($customers->customer_status == 'out') {
                                              ?>
                                              <a href="#" class="badge badge-danger">Default</a>
                                              <?php  } ?>
                                            </td>
                                            <td>
                                            <a href="<?php echo base_url("oficer/customer_profile/{$customers->customer_id}"); ?>" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"data-original-title="Edit"><i class="icon-eye"></i></a>
                                          <!--   <a href="<?php //echo base_url("oficer/delete_customerData/{$customers->customer_id}") ?>" class="btn btn-sm btn-icon btn-pure btn-danger on-default button-remove"
                                            data-toggle="tooltip" data-original-title="Remove" onclick="return confirm('Are You Sure?')"><i class="icon-trash" aria-hidden="true"></i></a> -->
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
</div>

<?php include('incs/footer.php'); ?>


