<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Event
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
                    <th><?php echo $this->Paginator->sort('start_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('last_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('flight'); ?></th>
                    <th><?php echo $this->Paginator->sort('children'); ?></th>
                    <th><?php echo $this->Paginator->sort('adult'); ?></th>
                    <th><?php echo $this->Paginator->sort('hotel'); ?></th>
                    <th><?php echo $this->Paginator->sort('start_location'); ?></th>
                    <th><?php echo $this->Paginator->sort('end_location'); ?></th>
                    
<!--                    <th><?php echo $this->Paginator->sort('status'); ?></th>-->
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $user): ?>
                <?php print_r($bookings); ?> die;
                
	<tr>
		<td><?php echo h($user['Booking']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['Booking']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($user['Booking']['last_date']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['flight']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['children']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['adult']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['hotel']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['start_location']); ?>&nbsp;</td>
                <td><?php echo h($user['Booking']['end_location']); ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $user['Booking']['id']), array('class' => 'fa fa-eye btn btn-info')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $user['Booking']['id']), array('class' => 'fa fa-trash btn btn-danger'), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('start_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('last_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('flight'); ?></th>
                    <th><?php echo $this->Paginator->sort('children'); ?></th>
                    <th><?php echo $this->Paginator->sort('adult'); ?></th>
                    <th><?php echo $this->Paginator->sort('hotel'); ?></th>
                    <th><?php echo $this->Paginator->sort('start_location'); ?></th>
                    <th><?php echo $this->Paginator->sort('end_location'); ?></th>
<!--                    <th><?php echo $this->Paginator->sort('status'); ?></th>-->
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
