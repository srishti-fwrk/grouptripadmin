<style>
    .navbar-inverse {
     background-color:  rgba(255,255,255,0.5)!important; 
     border-color: #fff!important; 
}
</style>
<?php print_r($savedata); ?>

      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
             
          <?php echo $this->Form->button('Accept', array('action' => 'accpect',$user_id,'class' => 'btn btn-primary')); ?>
                 
                 
                 <?php echo $this->Form->button('Reject', array('class' => 'btn btn-primary')); ?>
                  </div>
           
         
        </div>
      </div>
