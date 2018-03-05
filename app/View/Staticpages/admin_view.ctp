<?php echo $this->element('admin/header'); ?>
<?php echo $this->element('admin/sidebar'); ?>
<div class="content-wrapper" style="padding:0;">
<section class="content">
<h3>User</h3>
      <div class="row">
        <div class="col-md-6">
<div class="box box-primary">
            <div class="box-body box-profile">
                <div class="avatar">
                    <?php echo $this->Html->image('../files/profile_pic/'.$user['User']['image']);?>
                </div>
              <h3 class="profile-username text-center"><?php echo ($user['User']['name']); ?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Id</b> <a class="pull-right"><?php echo h($user['User']['id']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Name</b> <a class="pull-right"><?php echo ($user['User']['name']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Role</b> <a class="pull-right"><?php echo ($user['User']['role']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo ($user['User']['email']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Created</b> <a class="pull-right"><?php echo ($user['User']['created']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Modified</b> <a class="pull-right"><?php echo ($user['User']['modified']); ?></a>
                </li>
                
                
              </ul>

               <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-primary')); ?>
                <?php
                //echo '<pre>'; print_r($authUser);
                        if ($authUser['id'] == $user['User']['id']) {
                            echo $this->Html->link(
                                    'Change Password', array(
                                'controller' => 'users',
                                'action' => 'admin_changepassword'
                                    ), array(
                                'class' => 'btn btn-default'
                                    )
                            );
                        }
                        ?>
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