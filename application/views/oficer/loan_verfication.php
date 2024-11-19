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
                            <li class="breadcrumb-item active">Msimbo wa Usajiri</li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2></h2>
                        </div>
                        <div class="body">
                            <?php echo form_open("oficer/verfy_otp_data/{$customer_id}") ?>
                            <div class="row">
                               <div class="col-md-2 col-2">
                                                                </div>
                                <div class="col-md-8 col-8">
                                <div class="form-group">
                                    <label>Hakiki Msimbo wa Usajiri</label>
                                    <input type="text" name="otp" autocomplete="off" class="form-control" placeholder="N-1234" required>
                                </div>
                                </div>
                                <div class="col-md-2 col-2">
                                
                                </div>
                                <br>
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="icon-pencil">Hakiki Namba</i></button>
                                 <a href="">Tuma Upya</a>
                                </div>
                            
                            <?php echo form_close();  ?>
                        </div>
                    </div>
                </div> 
             
            </div>
        </div>
    </div>
</div>

<?php include('incs/footer.php'); ?>


