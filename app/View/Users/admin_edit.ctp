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
                        <h3 class="box-title">Edit User</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo $this->Form->create('User', array('role' => 'form', 'type' => 'file')); ?>

                    <br />
                    <div class="box-body">
                        <div class="form-group">

                            <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>

                            <input id="exampleInputFile" name="data[User][image]" class="" type="file">
                            <input type="hidden" name="data[User][pic]" value="<?php echo $editusr['User']['image']; ?>" />
                            <img src="<?php echo $this->webroot . 'files/profile_pic/' . $editusr['User']['image']; ?>" style="width:50px; height: 50px;" />


                        </div>
<!--                        <div class="form-group">
                            <?php echo $this->Form->input('status', array('class' => 'form-control', 'required' => 'required', 'options' => array(array('active' => 'Active', 'in_active' => 'Inactive')))); ?>
                        </div>-->

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">

                        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>

                    </div>
                    </form>
<!--                    <div class="box-footer">
                        <?php
                        if ($authUser['id'] == $this->request->data['User']['id']) {
                            echo $this->Html->link(
                                    'Change Password', array(
                                'controller' => 'users',
                                'action' => 'admin_changepassword'
                                    ), array(
                                'class' => 'btn btn-default'
                                    )
                            );
                        }
                        ?>

                    </div>-->
                </div>
            </div>
        </div>
    </section>
</div>
 <?php echo $this->element('admin/footer'); ?>
 
 <style>
  .box-body .form-group input[type=file] {
    margin-bottom: 10px;
}
 </style>