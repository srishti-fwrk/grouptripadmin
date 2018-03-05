  <?php echo $this->element('admin/header'); ?>
 <?php echo $this->element('admin/sidebar'); ?>
<div class="wrapper">

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo count($user)+count($admin); ?></h3>

              <p>Total Members</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo count($user); ?></h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo count($admin); ?></h3>
              <p>Admin</p>
            </div>
           
          </div>
        </div>
  
      </div>
    
      <!-- Small boxes (Stat box) -->
      <div class="row">
      
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo count($trip); ?></h3>

              <p>Total Trip</p>
            </div>
            <div class="icon">
              <i class="fa fa-car"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo count($trip); ?></h3>
              <p>Upcoming trip</p>
            </div>
           
          </div>
        </div>
        
             <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>0</h3>
              <p>Past trip</p>
            </div>
           
          </div>
        </div>
  
      </div>
    </section>
 
    
    </div>
    <div>
        
           
    </div>
     



      </div>


<!-- ./wrapper -->

 <?php echo $this->element('admin/footer'); ?>