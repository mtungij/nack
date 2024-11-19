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
                            <li class="breadcrumb-item active">Report</li>
                            <li class="breadcrumb-item active">Mauzo</li>
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
                            <h2>Mauzo / <?php if ($blanch_data == FALSE) {
                             ?> MATAWI YOTE<?php }else{ ?><?php echo @$blanch_data->blanch_name; ?> <?php } ?>/ From:<?php echo $from; ?> To:<?php echo $to; ?>  </h2> 
                            <div class="pull-right">
                               <a href="" data-toggle="modal" data-target="#addcontact2" class="btn btn-primary"><i class="icon-calendar">Filter</i></a>
                               <?php if (count($cash) > 0) {
                                ?> 
                                <a href="<?php echo base_url("admin/print_cashBlanch/{$from}/{$to}/{$blanch_id}"); ?>" class="btn btn-primary" target="_blank"><i class="icon-printer">Print</i></a> 
                                <?php }else{ ?> 
                                    <?php } ?>
                            </div>   
                             </div>
                          <div class="body">
                            <div class="table-responsive">

                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead class="thead-primary">
                                        <th>S/No.</th>
                                        <th>Tawi</th>
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
                                        <th>Maamuzi</th>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1; ?>
                                <?php foreach ($cash as $cashs): ?>
                                              <tr>
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $cashs->blanch_name; ?></td>
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
                                    <td>
                                        <?php if ($cashs->depost == TRUE) {
                                         ?>
                                        <a href="<?php echo base_url("admin/delete_depost_data/{$cashs->pay_id}"); ?>" class="btn btn-primary btn-sm"  onclick="return confirm('Are you sure?')" title="Adjust"><i class="icon-pencil"></i></a>
                                    <?php }else{ ?>
                                        <?php } ?>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>

                                
                                    </tbody>
                                     <tr>
                                       <td><b>TOTAL:</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo number_format($total_comp_data->total_depost_com); ?></b></</td>
                                        <td></td>
                                        <td><b><?php echo number_format($total_comp_data->total_comp_aprov); ?></b></td>
                                        <td></td>
                                        <td><b><?php //echo number_format($sum_deducted->total_deducted); ?></b></td>
                                        <td><b><?php //echo number_format($sum_paid_penart->total_penart); ?></td>
                                        <td></td>
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
                                         <td><?php echo $default_lists->f_name; ?> <?php echo $default_lists->m_name; ?> <?php  $default_lists->l_name; ?></td>
                                         <td><?php echo $default_lists->blanch_name; ?></td>
                                         <td><?php echo number_format($default_lists->depost); ?></td>
                                         <td><?php echo $default_lists->account_name; ?></td>
                                         <td></td>
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
                                         <td><b><?php echo number_format($total_comp_data->total_depost_com + $total_miamala->total_miamala); ?></b></td>
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
                <h6 class="title" id="defaultModalLabel">Filter Cash Transaction</h6>
            </div>
            <?php echo form_open("admin/cash_transaction_blanch"); ?>
            <div class="modal-body">
                <div class="row clearfix">

                                <div class="col-md-12 col-12">
                                    <span>*Select Branch:</span>
                                     <select type="number" class="form-control" name="blanch_id" required>
                                         <option value="">Select Branch</option>
                                         <?php foreach ($blanch as $blanchs): ?>
                                         <option value="<?php echo $blanchs->blanch_id; ?>"><?php echo $blanchs->blanch_name; ?></option>
                                         <?php endforeach; ?>
                                         <option value="all">All</option>
                                     </select>
                                </div>
                                <div class="col-md-6 col-6 ">
                                    <?php $date = date("Y-m-d"); ?>
                                    <span>*From:</span>
                                    <input type="date" name="from" autocomplete="off" value="<?php echo $date; ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 col-6 ">
                                    <span>*To:</span>
                                    <input type="date" name="to" autocomplete="off" value="<?php echo $date; ?>" class="form-control" required>
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


