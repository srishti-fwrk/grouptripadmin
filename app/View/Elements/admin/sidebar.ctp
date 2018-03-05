<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php echo $this->Html->image('../files/profile_pic/'.$authUser['image'], array('class'=>"img-circle"));?>

            </div>
            <div class="pull-left info">
                <p><?php echo $authUser['name'];?></p>

            </div>
        </div>
        <!--       search form 
              <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                      </span>
                </div>
              </form>
               /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!--        <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                        <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                      </ul>
                    </li>-->

            <li >
                <a href="<?php echo $this->webroot ?>admin/dashboards/index">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li> 

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><?php echo $this->Html->link('Users Listing', array('controller' => 'users', 'action' => 'index', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>  
                    <li class="active"><?php echo $this->Html->link('Add User', array('controller' => 'users', 'action' => 'add', 'admin' => true), array('class' => '')); ?></li> 
                </ul>
            </li>  


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Trips</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><?php echo $this->Html->link('Upcoming Trips', array('controller' => 'trips', 'action' => 'trip', 'admin' => true), array('class' => '')); ?></li>
                    <li class="active"><?php echo $this->Html->link('Past Trips', array('controller' => 'trips', 'action' => 'trip', 'admin' => true), array('class' => '')); ?></li> 
                </ul>
            </li> 
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-ticket"></i> <span>Booking</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><?php echo $this->Html->link('Upcoming Booking', array('controller' => 'bookings', 'action' => 'booking', 'admin' => true), array('class' => '')); ?></li>
                    <li class="active"><?php echo $this->Html->link('Past Booking', array('controller' => 'bookings', 'action' => 'booking', 'admin' => true), array('class' => '')); ?></li>
                </ul>
            </li> 
                <li class="treeview">
                <a href="#">
                    <i class="fa fa-address-book-o"></i> <span>Event</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><?php echo $this->Html->link('Upcoming Event', array('controller' => 'bookings', 'action' => 'event', 'admin' => true), array('class' => '')); ?></li>
                   
                </ul>
            </li> 

  <li class="treeview">
                <a href="#">
                    <i class="fa fa-address-book-o"></i> <span>Static Pages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><?php echo $this->Html->link('Manage Pages', array('controller' => 'staticpages', 'action' => 'index', 'admin' => true), array('class' => '')); ?></li>
                    <li class="active"><?php echo $this->Html->link('Add', array('controller' => 'staticpages', 'action' => 'add', 'add' => true), array('class' => '')); ?></li>
                   
                </ul>
            </li> 



    </section>

</aside>