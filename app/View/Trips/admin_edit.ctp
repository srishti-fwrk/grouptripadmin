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
                        <h3 class="box-title">Edit Trip</h3>
                    </div><?php //echo "<pre>";print_r($this->request->data);die;?>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo $this->Form->create('Trip', array('role' => 'form', 'type' => 'file')); ?>

                    <br />
                    <div class="box-body">
                        <div class="form-group">

                            <?php echo $this->Form->input('user_id', array('class' => 'form-control','options'=>$username)); ?>
                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->input('trip_startdate', array('class' => 'form-control', 'placeholder' => 'Start date')); ?>
                        </div>
                           <div class="form-group">

                            <?php echo $this->Form->input('trip_enddate', array('class' => 'form-control', 'placeholder' => 'End date')); ?>
                        </div>
                         <div class="form-group">

                            <?php echo $this->Form->input('start_location', array('class' => 'form-control', 'placeholder' => 'Enter your start location')); ?>
                        </div>
                           <div class="form-group">

                            <?php echo $this->Form->input('end_location', array('class' => 'form-control', 'placeholder' => 'Enter your end location')); ?>
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