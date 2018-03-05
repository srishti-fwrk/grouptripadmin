<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Customer
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
                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('image'); ?></th>
                    <th><?php echo $this->Paginator->sort('role'); ?></th>
                    <th><?php echo $this->Paginator->sort('created'); ?></th>
<!--                    <th><?php echo $this->Paginator->sort('status'); ?></th>-->
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td>
                    <?php if($user['User']['image']){
                            if (filter_var($user['User']['image'], FILTER_VALIDATE_URL)) { ?>
                    <img src="<?php echo $user['User']['image']; ?>" style="width:50px; height: 50px;" />
                           <?php }else{ ?>
                               <img src="<?php echo $this->webroot.'files/profile_pic/'.$user['User']['image']; ?>" style="width:50px; height: 50px;" />
                           <?php }
                            ?>
                                
                            <?php }else{ ?>
                                <img src="<?php echo $this->webroot.'images/icon-profile.png'; ?>" alt="" style="width:50px; height: 50px;"> 
                    <?php } ?>
                
                </td>
		
		<td><?php echo h($user['User']['role']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
<!--                <td><?php
                if($user['User']['status']==1){
                echo h("Active"); } else{
                    echo h("Inactive");
                }
            ?>        
                 </td>-->
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $user['User']['id']), array('class' => 'fa fa-eye btn btn-info')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $user['User']['id']), array('class' => 'fa fa-edit btn btn-success')); ?>
			<?php echo $this->Form->postLink(__(''), array('action' => 'delete', $user['User']['id']), array('class' => 'fa fa-trash btn btn-danger'), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('image'); ?></th>
                    <th><?php echo $this->Paginator->sort('role'); ?></th>
                    <th><?php echo $this->Paginator->sort('created'); ?></th>
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
