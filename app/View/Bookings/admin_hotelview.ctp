<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
<section class="content">
<h3>Hotel detail</h3>
      <div class="row">
        <div class="col-md-6">
<div class="box box-primary">
            <div class="box-body box-profile">
               <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Id</b> <a class="pull-right"><?php echo h($user['Hotel_booking']['id']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Amount</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['price']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Hotel name</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['hname']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Check out</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['check_in']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Check out</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['check_out']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Rooms</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['rooms']); ?></a>
                </li>
                  <li class="list-group-item">
                  <b>City</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['city']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Status</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['status']); ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Booking Id</b> <a class="pull-right"><?php echo ($user['Hotel_booking']['booking_id']); ?></a>
                </li>
               
                
                
                
              </ul>

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
