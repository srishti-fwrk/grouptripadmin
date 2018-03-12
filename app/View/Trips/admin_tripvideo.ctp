
<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

  </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
             
          <div class="box-header with-border">
              <h3 class="box-title"> Trip Gallery</h3>
           </div><!-- /.box-header -->
            <div class="box-body gallery_pics">

           <?php foreach ($gallery as $pics): ?> 
                <div class="col-sm-4">

<video width="320" height="240" controls>
  <source src="<?php echo $this->webroot.'files/uservideo/'.$pics['Video']['video']; ?>" type="video/mp4">
  <source src="<?php echo $this->webroot.'files/uservideo/'.$pics['Video']['video']; ?>" type="video/ogg">
</video>         
          <?php //echo $pics['Gallery']['image']; ?>

                </div>
     <?php endforeach;?>
                         </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<?php echo $this->element('admin/footer'); ?>
 <?php
   echo $this->Html->script(array('jquery.dataTables.min','dataTables.bootstrap.min'));
  ?>
<!-- jQuery 3 -->
<!--<script src="../../bower_components/jquery/dist/jquery.min.js"></script>-->
<!-- Bootstrap 3.3.7 -->
<!--<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<!-- DataTables -->
<!--<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>-->
<!--<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->
<!-- SlimScroll -->
<!--<script src="../../bower_components/jquery-slimsc   roll/jquery.slimscroll.min.js"></script>-->
<!-- FastClick -->
<!--<script src="../../bower_components/fastclick/lib/fastclick.js"></script>-->
<!-- AdminLTE App -->
<!--<script src="../../dist/js/adminlte.min.js"></script>-->
<!-- AdminLTE for demo purposes -->
<!--<script src="../../dist/js/demo.js"></script>-->
<!-- page script -->

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<style>

.gallery_inner {
    height: 200px;
    overflow: hidden;
	position:relative;
        padding: 15px 0px;
}

.gallery_inner .btn.btn-danger{
	position: absolute;
    top: 0px;
    right: 0;
    border-radius: 0px;
	display:none;
}


.gallery_inner:hover .btn.btn-danger{
	display:block;
	}
	

.gallery_pics img{
	    max-width: 100%;
    width: 100%;
    height: 100%;
	}
	

</style>









