<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
<section class="content">
<h3>Event</h3>
      <div class="row">
        <div class="col-md-6">
<div class="box box-primary">
            <div class="box-body box-profile">
               <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Id</b> <a class="pull-right"><?php echo h($user['Event']['id']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Event type</b> <a class="pull-right"><?php echo ($user['Event']['event_type']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Arrival address</b> <a class="pull-right"><?php echo ($user['Event']['a_dd']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Departure address</b> <a class="pull-right"><?php echo ($user['Event']['d_add']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Arrival time</b> <a class="pull-right"><?php echo ($user['Event']['a_time']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Departure time</b> <a class="pull-right"><?php echo ($user['Event']['d_time']); ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Note</b> <a class="pull-right"><?php echo ($user['Event']['note']); ?></a>
                </li>
            
              </ul>

               <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['Event']['id']), array('class' => 'btn btn-primary')); ?>
         
            </div>
            <!-- /.box-body -->
          </div>
</div>
</div>
</section>
</div>
 <?php echo $this->element('admin/footer'); ?>


<script type="text/javascript">
    $(document).ready(function(){
        $(".slide-toggle").click(function(e){
            e.preventDefault();
            //console.log($(this).text());
            if($(this).text()=='Show'){
                $(this).text('Hide');
            }
            else{
                $(this).text('Show');
            }
            $(".passwordshow").animate({
                width: "toggle"
            });
        });
    });
</script>

<style type="text/css">
    .box-body .avatar{
        width: 100px;
        height: 100px;
        display: block;
        border-radius: 50%;
        overflow: hidden;
        margin: auto;
        margin-bottom: 25px;
    }
    .box-body .avatar img{
        height: 100%;
        width:auto;
    }
</style>