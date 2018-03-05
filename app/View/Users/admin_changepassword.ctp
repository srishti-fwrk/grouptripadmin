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
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <?php echo $this->Form->create('User',array('role'=>'form','type'=>'file'));?>
            <?php echo $this->Session->flash('success') ?>
              <br />
              <div class="box-body">
                  <div class="form-group">
            
               <?php echo $this->Form->input('old_password', array('type'=>'password','class' => 'form-control', 'required'=>'required')); ?>
                </div>
                <div class="form-group">

                 <?php echo $this->Form->input('new_password', array('type'=>'password','class' => 'form-control','required')); ?>
                </div>
                <div class="form-group">
               
                 <?php echo $this->Form->input('cpassword', array('type'=>'password','class' => 'form-control','required','label'=>'Confirm password')); ?>
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