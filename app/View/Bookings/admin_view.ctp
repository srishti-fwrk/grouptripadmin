<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
<section class="content">
<h3>Flight detail</h3>
      <div class="row">
        <div class="col-md-6">
<div class="box box-primary">
            <div class="box-body box-profile">
               <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Id</b> <a class="pull-right"><?php echo h($user['Booking']['id']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Start date</b> <a class="pull-right"><?php echo ($user['Booking']['start_date']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>End date</b> <a class="pull-right"><?php echo ($user['Booking']['last_date']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Flight no</b> <a class="pull-right"><?php echo ($user['Booking']['flight']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Amount</b> <a class="pull-right"><?php echo ($user['Booking']['amount']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Airline</b> <a class="pull-right"><?php echo ($user['Booking']['airline']); ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Arrival time</b> <a class="pull-right"><?php echo ($user['Booking']['arrival_time']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Departure time</b> <a class="pull-right"><?php echo ($user['Booking']['departure_time']); ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Start Location</b> <a class="pull-right"><?php echo ($user['Booking']['start_location']); ?></a>
                </li>
                 <li class="list-group-item">
                  <b>End Location</b> <a class="pull-right"><?php echo ($user['Booking']['end_location']); ?></a>
                </li>
                   <li class="list-group-item">
                  <b>Booking Id</b> <a class="pull-right"><?php echo ($user['Booking']['booking_id']); ?></a>
                </li>
                   <li class="list-group-item">
                  <b>Status</b> <a class="pull-right"><?php echo ($user['Booking']['status']); ?></a>
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