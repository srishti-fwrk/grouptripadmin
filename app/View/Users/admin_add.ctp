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
              <h3 class="box-title">Add User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <?php echo $this->Form->create('User',array('role'=>'form','type'=>'file'));?>
        
              <br />
              <div class="box-body">
                  <div class="form-group">
            
               <?php echo $this->Form->input('name', array('class' => 'form-control', 'required'=>'required')); ?>
                </div>
                <div class="form-group">

                 <?php echo $this->Form->input('email', array('class' => 'form-control','placeholder'=>'Email','required')); ?>
                </div>
                <div class="form-group">
               
                 <?php echo $this->Form->input('password', array('class' => 'form-control','required')); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
              
                  <input id="exampleInputFile" name="data[User][image]" class="" type="file" required="required">

               
                </div>
                  <div class="form-group">
                    <?php echo $this->Form->input('status', array('class' => 'form-control', 'required'=>'required', 'options' => array( array('active' => 'Active','in_active' => 'Inactive')))); ?>
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