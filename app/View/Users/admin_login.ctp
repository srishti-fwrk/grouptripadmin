<style>

body{
	height: 100%;
    position: relative;
    overflow-x: hidden;
    background: #d2d6de;
}

.login_frm {
  width: 100%;
  padding: 15px;
  background: #fff;
  border-radius: 7px;
  box-shadow: 0 0 5px #ccc;
  margin-top: 20vh;
}
.login_frm h3 {
  margin: 0;
  width: 100%;
  text-transform: uppercase;
  text-align: center;
  font-size: 19px;
  font-weight: 800;
  border-bottom: 1px solid #ddd;
  padding-bottom: 10px;
  margin-bottom: 10px;
}

.footer{
	width:100%;
	position:absolute;
	bottom:0;
	}
.content{
	margin-top:0;
	padding:0 !important;
	}
	
</style>
	<div class="login_outer">
		<div class="container">
			<div class="row">
    			<div class="col-sm-4 col-sm-offset-4">
    				<div class="login_frm">
                        <h3>Login</h3>
                        <?php echo $this->Form->create('User', array('url' => 'login')); ?>
                        <?php echo $this->Form->input('email', array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
                        <br />
                        <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
                        <br />
                        <?php echo $this->Form->button('Login', array('class' => 'btn btn-primary')); ?>
                        <?php echo $this->Form->end(); ?>
                	</div>
            	<div>
     		</div>
    	</div>
  </div>  
    
</div>
</div>
<script>
    $("#formoid").submit(function(event) {
      /* stop form from submitting normally */
      event.preventDefault();
      var myvar='';
      var $form = $( this ),
          url = $form.attr( 'action' );
$.ajax({
            dataType: "json",
            type: "POST",
            cache:false,
            url: url,
            data: ({server: $('#server').val(), username: $('#email').val()}),
            success: function (data){
                var myvar = '<div id="flashMessage" class="message">'+data+'</div>';
                    $('#msgflash').html(myvar);
                    $('#myModalsf').modal('toggle');
                    $('#flashMessage').delay(5000).fadeOut('slow'); 
            }
        });
    });
</script>


<!--   /.login-logo 
  
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
   Tell the browser to be responsive to screen width 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   Bootstrap 3.3.7 
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
   Font Awesome 
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
   Ionicons 
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
   Theme style 
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   iCheck 
  <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

   HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries 
   WARNING: Respond.js doesn't work if you view the page via file:// 
  [if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]

   Google Font 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
   /.login-logo 
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php echo $this->Form->create('User', array('url' => 'login')); ?>
      <div class="form-group has-feedback">
        
        <?php echo $this->Form->input('email', array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
         /.col 
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            <?php echo $this->Form->button('Login', array('class' => 'btn btn-primary btn-block btn-flat')); ?>
        </div>
         /.col 
      </div>
      <?php echo $this->Form->end(); ?>

  

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
   /.login-box-body 
</div>
 /.login-box 

 jQuery 3 
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
 Bootstrap 3.3.7 
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 iCheck 
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>-->
