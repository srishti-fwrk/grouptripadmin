<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Past Booking
      </h1>
  
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('Amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('hname'); ?></th>
                    <th><?php echo $this->Paginator->sort('check_in'); ?></th>
                    <th><?php echo $this->Paginator->sort('check_out'); ?></th>
                    <th><?php echo $this->Paginator->sort('rooms'); ?></th>
                    <th><?php echo $this->Paginator->sort('city'); ?></th>
                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                    <th><?php echo $this->Paginator->sort('booking_id'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $user): ?>
                
	<tr>
		<td><?php echo h($user['Hotel_booking']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['Hotel_booking']['price']); ?>&nbsp;</td>
		<td><?php echo h($user['Hotel_booking']['hname']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['check_in']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['check_out']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['rooms']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['city']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['status']); ?>&nbsp;</td>
                <td><?php echo h($user['Hotel_booking']['booking_id']); ?>&nbsp;</td>
          	<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'hotelview', $user['Hotel_booking']['id']), array('class' => 'fa fa-eye btn btn-info')); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('Amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('hotel name'); ?></th>
                    <th><?php echo $this->Paginator->sort('check_in'); ?></th>
                    <th><?php echo $this->Paginator->sort('check_out'); ?></th>
                  
                    <th><?php echo $this->Paginator->sort('rooms'); ?></th>
                    <th><?php echo $this->Paginator->sort('city'); ?></th>
                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                   <th><?php echo $this->Paginator->sort('booking_id'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </tfoot>
              </table>
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
.actions .btn{
	padding: 3px 4px;
	margin-bottom: 3px;
   }
</style>
