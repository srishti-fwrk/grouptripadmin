<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                <div class="box-header with-border">
                        <h3 class="box-title">Trip Detail</h3>
                    </div>
                    <div class="box-body box-profile">


                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Id</b> <a class="pull-right"><?php echo h($trip['User']['name']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Start location</b> <a class="pull-right"><?php echo ($trip['Trip']['start_location']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>End location</b> <a class="pull-right"><?php echo ($trip['Trip']['end_location']); ?></a>
                            </li>

                            <li class="list-group-item">
                                <b>Start date</b> <a class="pull-right"><?php echo ($trip['Trip']['trip_startdate']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>End date</b> <a class="pull-right"><?php echo ($trip['Trip']['trip_enddate']); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Gallery</b>
                                <?php foreach ($trip['User']['Gallery'] as $pics): ?>
                              <?php //print_r($pics);?>
                                    <div class="col-sm-3">
                                        <img src="<?php echo $this->webroot . 'files/usergallery/' . $pics['image']; ?>" />
                                      
                                    </div>
                                <?php endforeach; ?>
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
    $(document).ready(function () {
        $(".slide-toggle").click(function (e) {
            e.preventDefault();
            //console.log($(this).text());
            if ($(this).text() == 'Show') {
                $(this).text('Hide');
            } else {
                $(this).text('Show');
            }
            $(".passwordshow").animate({
                width: "toggle"
            });
        });
    });
</script>