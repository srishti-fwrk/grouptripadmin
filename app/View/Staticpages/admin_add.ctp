
<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <?php echo $this->Form->create('Staticpage',array('role'=>'form','type'=>'file'));?>
        
              <br />
              <div class="box-body">
                  <div class="form-group">
            
               <?php echo $this->Form->input('title', array('class' => 'form-control', 'required'=>'required')); ?>
                </div>
                <div class="form-group">

                 <?php echo $this->Form->input('detail', array('id' => 'summernote','type' => 'textarea')); ?>
                </div>
              
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
              
                  <input id="exampleInputFile" name="data[Staticpage][image]" class="" type="file" required="required">

               
                </div>
                  
           
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                
              </div>
            </form>
          </div>
        </div>
      </div>
          </section>
</div>
 <?php echo $this->element('admin/footer'); ?>

 <script>
     $(document).ready(function() {
  $('#summernote').summernote();
});
 </script>