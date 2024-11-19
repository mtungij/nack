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
                            <li class="breadcrumb-item active"><?php echo $this->lang->line("transaction_menu"); ?></li>
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
                            <h2><?php echo $this->lang->line("today_cashtransaction_menu"); ?> </h2> 
                            <div class="pull-right">
                               <a href="" data-toggle="modal" data-target="#addcontact2" class="btn btn-primary"><i class="icon-calendar"><?php echo $this->lang->line("search_menu"); ?></i></a>  
                            </div>   
                             </div>
                          <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                         <th>S/No.</th>
                                        <th>Afisa</th>
                                        <th>Jina la Mteja</th>
                                        <th>Nambari Ya Simu</th>
                                        <th>Lipisha</th>
                                        <th>Akaunti Iliyo Lipisha</th>
                                        <th>Gawa</th>
                                        <th>Akaunti Iliyo Gawa</th>
                                        <!-- <th>Fomu</th>
                                        <th>Faini</th> -->
                                        <th>Tarehe</th>
                                        <th>Tarehe & Muda</th>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1; ?>
                                <?php foreach ($cash_transaction as $cashs): ?>
                                              <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $cashs->empl_name; ?></td>
                                    <td><?php echo $cashs->f_name; ?> <?php echo $cashs->m_name; ?> <?php echo $cashs->l_name; ?></td>
                                    <td><?php echo $cashs->phone_no; ?></td>
                                    <td>    <?php if ($cashs->depost == TRUE) {
                                         ?>
                                        <?php echo number_format($cashs->depost); ?>
                                    <?php }elseif ($cashs->depost == FALSE) {
                                     ?>
                                     -
                                     <?php } ?></td>
                                     <td>
                                        <?php if ($cashs->deposit_account == TRUE) {
                                         ?>
                                        <?php echo $cashs->deposit_account; ?>
                                    <?php }else{ ?>
                                        -
                                        <?php } ?>
                                            
                                        </td>
                                    <td>
                                        <?php if ($cashs->withdraw == TRUE) {
                                         ?>
                                        <?php echo number_format($cashs->loan_aprov); ?>
                                    <?php }elseif ($cashs->withdraw == FALSE) {
                                     ?>
                                     -
                                     <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($cashs->withdrawal_account == TRUE) {
                                         ?>
                                        <?php echo $cashs->withdrawal_account; ?>
                                    <?php }else{ ?>
                                        -
                                        <?php } ?>
                                            
                                        </td>
                                    <td><?php echo $cashs->lecod_day; ?></td>
                                    <td><?php echo $cashs->time_rec; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                   
                                    </tbody>
                                     <tr>
                                        <td><b><?php echo $this->lang->line("total_menu"); ?>:</b></td>
                                        <!-- <td></td> -->
                                        <td></td>
                                        <td></td>
                                        <td><b></b></td>
                                        <td><b><?php echo number_format($sum_cashTransaction->total_deposit); ?></b></b></td>
                                        <td><b></td>
                                        <td><?php echo number_format($sum_cashTransaction->total_aprove); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <!--  <td></td> -->
                                    </tr>

                                    <tr>
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td>MUHTASALI WA KULIPISHA</td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td>  
                                    </tr>
                                    <?php foreach ($account_deposit as $account_deposits): ?>
                                    <tr>
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td><b><?php echo $account_deposits->account_name; ?></b></td> 
                                       <td></td> 
                                       <td><b><?php echo number_format($account_deposits->total_deposit_acc); ?></td> 
                                       <td></td> 
                                       <td></td> 
                                       <td></td>  
                                    </tr>
                                     <?php endforeach; ?>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>MADENI SUGU</b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>

                                          <?php $no = 1; ?>
                                     <?php foreach ($default_list as $default_lists): ?>
                                       <tr>
                                         <td></td>
                                         <td> </td>
                                         <td></td>
                                         <td></td>
                                         <td><?php echo $default_lists->f_name; ?> <?php echo $default_lists->m_name; ?> <?php echo $default_lists->l_name; ?></td>
                                          
                                         <td><?php echo number_format($default_lists->depost); ?></td>
                                         <td><?php echo $default_lists->account_name; ?></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                      <?php endforeach ?>
                                      <tr>
                                         <td></td>
                                         <td> </td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA MADENI SUGU</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($toyal_default->total_default); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                        <tr>
                                         <td></td>
                                         <td> </td>
                                         <td></td>
                                         <td></td>
                                         <td><b>MIAMALA HEWA</b></td>
                                         <td></td>
                                         <td><b><?php //echo number_format($toyal_default->total_default); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>

                                     <?php foreach ($miamala as $miamalas): ?>
                                         <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><?php echo $miamalas->agent; ?></td>
                                         <td><?php echo $miamalas->account_name; ?></td>
                                         <td><?php echo number_format($miamalas->amount); ?></td>
                                         <td><?php echo $miamalas->blanch_name; ?></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <?php endforeach; ?>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA MIAMALA HEWA</b><?php //echo $miamalas->agent; ?></td>
                                         <td><?php //echo $miamalas->account_name; ?></td>
                                         <td><b><?php echo number_format($total_miamala->total_miamala); ?></b></td>
                                         <td><?php //echo $miamalas->blanch_name; ?></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>MUHTASALI WA GAWA</td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <?php foreach ($withdrawal_account as $withdrawal_accounts): ?>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b><?php echo $withdrawal_accounts->account_name; ?></b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($withdrawal_accounts->total_with_acc); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <?php endforeach; ?>
                                      <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA CODE NO</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($total_code_no->total_interest); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA FOMU</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($deducted_fee->total_deducted); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA FAINI</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($penart_paid->total_penart); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                           <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA WATEJA WALIO LIPA HAI</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($hai_wateja->total_hai); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>
                                      <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA WATEJA WALIO LIPA SUGU</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($sugu_wateja->total_sugu); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                     </tr>


                                      <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td><b>JUMLA YA MAUZO</b></td>
                                         <td></td>
                                         <td><b><?php echo number_format($sum_cashTransaction->total_deposit + $total_miamala->total_miamala); ?></b></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
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


 <div class="modal fade" id="addcontact2<?php //echo $employees->empl_id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel"><?php echo $this->lang->line("search_menu") ?> <?php echo $this->lang->line("today_cashtransaction_menu") ?></h6>
            </div>
            <?php echo form_open("oficer/filter_cashTransaction"); ?>
            <div class="modal-body">
                <div class="row clearfix">

                                <div class="col-md-6 col-6 ">
                                    <?php $date = date("Y-m-d"); ?>
                                    <span>*<?php echo $this->lang->line("from_menu") ?>:</span>
                                    <input type="date" name="from" autocomplete="off" value="<?php echo $date; ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 col-6 ">
                                    <span>*<?php echo $this->lang->line("to_menu") ?>:</span>
                                    <input type="date" name="to" autocomplete="off" value="<?php echo $date; ?>" class="form-control" required>
                                </div>
                                <input type="hidden" name="blanch_id" value="<?php echo $empl_data->blanch_id; ?>">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line("search_menu") ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line("close_menu") ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


