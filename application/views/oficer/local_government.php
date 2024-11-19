<?php include('incs/header.php'); ?>
<?php include('incs/nav.php'); ?>
<?php include('incs/side.php'); ?>


<style type="text/css">
    img{
        display: block;
        max-width: 100%;
    }
    .preview{
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1 px solid red;
    }
</style>

    <div id="main-content" class="profilepage_2 blog-page">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url("oficer/index"); ?>"><i class="icon-home"></i></a></li>
                            
                            <li class="breadcrumb-item active">Local government</li>
                            
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

                   <?php //include('incs/profile_nav.php'); ?>

                    <div class="tab-content padding-0">

                        <div class="tab-pane active" id="Basic">
                            <div class="card">
                               <div class="body">
            <div class="header">
                <h2>Local government information & passport</h2>
                <div class="pull-right">
                    <div class="row profile_state">
                    <?php if ($local_gov->cont_attachment == TRUE) {
                                     ?>
                                <div class="profile-image"> <img src="<?php echo base_url().$local_gov->cont_attachment; ?>" class="rounded-circle" alt="customer image" style="width: 60px;height: 60px;">
                                      </div>
                                 <?php }else{ ?>
                                <div class="profile-image"> <img src="<?php echo base_url().'assets/img/male.jpeg'; ?>" class="rounded-circle" alt="customer image" style="width: 60px;height: 60px;">
                                      </div>
                                    <?php } ?>
                                    </div>
                </div>
            </div>
       
    <?php //echo form_open("admin/create_collateral/{$customer_id}/{$loan_id}"); ?>
    <form  method="POST" enctype="multipart/form-data">
     <div class="row">
       <!--  <div class="col-md-4 col-6">
        <span>Full name</span>
        <input type="text" name="oficer" value="<?php echo $local_gov->oficer; ?>" class="form-control" id="oficer" placeholder="Enter Name" required>
    </div> -->
   <!--  <div class="col-md-4 col-6">
        <span>Phone Number</span>
        <input type="number" name="phone_oficer" value="<?php echo $local_gov->phone_oficer; ?>" id="phone_oficer" class="form-control" placeholder="Enter phone" required>
    </div> -->
      <div class="col-md-4 col-12">
    <span>Upload Passport</span>
    <input type="file" class="image form-control" name="image">
    </div>
    
    <input type="hidden" value="<?php echo $local_gov->loan_id; ?>" name="loan_id" id="id">
      </div>
       <div class="text-center">
           <?php if ($local_gov->cont_attachment == TRUE) {
            ?>
        <a href="<?php echo base_url("oficer/loan_pending"); ?>" class="btn btn-sm btn-primary">Finish</a>
        <?php }else{ ?>
           
           <?php } ?>
       </div>
    </form> 
                                    
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-6 col-6">
                    <img id="image">
                </div>
            
            <div class="col-md-6 col-6">
                <div class="preview"></div>
                </div>
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
        <button type="button" class="btn btn-primary" id="crop">Save</button>
      </div>
    </div>
  </div>
</div>

                                      </div>
                                </div>

                                </div>
                            </div>
                        </div>



 
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('incs/footer.php'); ?>

<script>
    var  bs_modal = $('#modal');
    var  image = document.getElementById('image');
    var id = document.getElementById('id').value;
    //var test = document.getElementById('test01').value;
    var  cropper,reader,file;


    $("body").on("change",".image",function(e){
      var files = e.target.files;
      var done = function (url){
        image.src = url;
        bs_modal.modal('show');
      };

      if (files && files.length > 0) {
         file = files[0];
         if (URL) {
            done(URL.createObjectURL(file));
         }else if(FileReader){
          reader = new FileReader();
          reader.onload = function (e){
            done(reader.result);
          };
          reader.readAsDataURL(file);
         }
      }

    
    });

    bs_modal.on('shown.bs.modal',function(){
        cropper = new Cropper(image,{
            aspectRatio: 1,
            viewMode : 3,
            preview: '.preview'
            });


        }).on('hidden.bs.modal',function(){
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height : 160,

            });
            

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
        reader.onload = function(){

        //var test = document.getElementById('test01').value;
        //var oficer = document.getElementById('oficer').value;
        //var phone_oficer = document.getElementById('phone_oficer').value;
        //var value_col = document.getElementById('value_col').value;
        //var forced_value = document.getElementById('forced_value').value;
            
            var base64data = reader.result;
              //alert(oficer);
            $.ajax({
                type:"POST",
                //dataType:"json",
                url:"<?php echo base_url(); ?>oficer/create_local_govDetails",
                data:{image:base64data,id:id},
                success: function(data){
                    //image.val('')
                 bs_modal.modal('hide');
                 alert(data);
                 location.reload();
                }
            });

            };

        });
    });
        
        
        
    
  </script>





