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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("loan"); ?></li>
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("collateral_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("collateral_form_menu"); ?></h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("oficer/create_colateral/{$loan_attach->loan_id}") ?>
                            <div class="row">
                                <div class="col-lg-6">
                            <div class="form-group">
                              <span><?php echo $this->lang->line("name_collateral_menu"); ?>:</span>
                                <input type="text" class="form-control" id="description" placeholder="<?php echo $this->lang->line("name_collateral_menu"); ?>" name="description" autocomplete="off">
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="form-group">
                              <span><?php echo $this->lang->line("Condition_menu"); ?>:</span>
                                <input type="text" class="form-control" id="" placeholder="<?php echo $this->lang->line("Condition_menu"); ?>" name="co_condition" autocomplete="off">
                            </div>
                            </div>

                            <div class="col-lg-6">
                            <div class="form-group">
                              <span><?php echo $this->lang->line("value_collateral_menu") ?>:</span>
                                <input type="number" class="form-control" id="" placeholder="<?php echo $this->lang->line("value_collateral_menu") ?>" name="value" autocomplete="off">
                            </div>
                            </div>

                            <div class="col-lg-6">
                            <div class="form-group">
                              <span><?php echo $this->lang->line("picture_menu"); ?>:</span>
                                <input type="file" class="form-control" id="attach" placeholder="Enter Middle name" name="file_name" autocomplete="off">
                            </div>
                            </div>

                            <input type="hidden" name="loan_id"  id="loan_id" value="<?php echo $loan_attach->loan_id; ?>">
                               
                                </div>
                                 <br>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="icon-drawer"><?php echo $this->lang->line("save_menu") ?></i></button>
                                <a href="<?php echo base_url("oficer/local_government/{$loan_attach->loan_id}"); ?>" class="btn btn-primary"><?php echo $this->lang->line("next_menu") ?></a>
                                </div>
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                         <div class="header">
                            <h2><?php echo $this->lang->line("collateral_list_menu"); ?></h2>    
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <tr>
                                          <th>S/No.</th>
                                            <th><?php echo $this->lang->line("name_collateral_menu"); ?></th>
                                            <th><?php echo $this->lang->line("Condition_menu"); ?></th>
                                            <th><?php echo $this->lang->line("value_collateral_menu"); ?></th>
                                            <th><?php echo $this->lang->line("picture_menu"); ?></th>
                                            <th><?php echo $this->lang->line("action_menu"); ?></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                              <?php $no = 1; ?>
                                  <?php foreach ($collateral as $collaterals): ?>
                                              <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $collaterals->description; ?></td>
                                    <td><?php echo $collaterals->co_condition; ?></td>
                                    <td><?php echo number_format($collaterals->value); ?></td>
                                    <td>
                                        <div class="profile-image"><a href="" data-toggle="modal" data-target="#addcontact2<?php echo $collaterals->col_id; ?>"> <img src="<?php echo base_url().'assets/img/'.$collaterals->file_name; ?>" class="img-thumbnail" alt="Collateral image" style="width: 80px;height: 80px;"></a>
                                      </div>
                                       
                                    </td>
                                <td>
                                      <a href="" class="btn btn-sm btn-icon btn-pure btn-primary on-default m-r-5 button-edit"
                                            data-toggle="modal" data-target="#addcontact1<?php echo $collaterals->col_id; ?>" data-original-title="Edit"><i class="icon-pencil"></i>
                                        </a>
                                       
                                            <a href="<?php echo base_url("oficer/delete_colateral/{$collaterals->loan_id}/{$collaterals->col_id}") ?>" class="btn btn-sm btn-icon btn-pure btn-danger on-default m-r-5 button-edit" data-original-title="Delete" onclick="return confirm('Are You Sure?')"><i class="icon-trash"></i>
                                        </a>
                                </td>                                                                                   
</tr>
    <div class="modal fade" id="addcontact1<?php echo $collaterals->col_id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("update_menu") ?></h6>
            </div>
            <?php echo form_open("oficer/modify_colateral/{$collaterals->loan_id}/{$collaterals->col_id}"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                              <div class="col-md-6">
                                    <label for="recipient-name" class="form-control-label">*<?php echo $this->lang->line("name_collateral_menu") ?>:</label>
                             <input type="text" class="form-control" autocomplete="off" name="description" value="<?php echo $collaterals->description; ?>">
                                </div>
                                <div class="col-md-6">
                            <label for="recipient-name" class="form-control-label">*<?php echo $this->lang->line("Condition_menu") ?>:</label>
                         <input type="text" class="form-control" autocomplete="off" name="co_condition" value="<?php echo $collaterals->co_condition; ?>">
                                </div>
                                <div class="col-md-12">
                                   <label for="recipient-name" class="form-control-label">*<?php echo $this->lang->line("value_collateral_menu") ?>:</label>
                              <input type="text" class="form-control" autocomplete="off" name="value" value="<?php echo $collaterals->value; ?>">
                                </div>
                               
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("update_menu") ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu") ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="addcontact2<?php echo $collaterals->col_id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("update_menu") ?></h6>
            </div>
            <?php echo form_open_multipart("oficer/modify_colateral_picture/{$collaterals->loan_id}/{$collaterals->col_id}"); ?>
            <div class="modal-body">
                <div class="row clearfix">
                              <div class="col-md-6">
                                    <label for="recipient-name" class="form-control-label">*<?php echo $this->lang->line("picture_menu") ?>:</label>
                             <input type="file" class="form-control" autocomplete="off" name="file_name">
                                </div>
                                <div class="col-md-6">
                                 <img src="<?php echo base_url().'assets/img/'.$collaterals->file_name; ?>" class="img-thumbnail" alt="Collateral image" style="width: 120px;height: 120px;">
                                </div>
                               
                               
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("update_menu") ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu") ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
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


