<?php
//Protected page for the ACM mailList
//Written by Conrad Weiser - 11/10/2016
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('ulogin/config/all.inc.php');
require_once('ulogin/main.inc.php');
require_once('assets/mysqlclass.php');


//Start a secure connection if one is not already running
if (!sses_running()){
  sses_start();
}

function isAppLoggedIn(){
	return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}

function loginFailed($uid,$pwd,$ulogin) {
	echo 'You should not be here right now. Try logging in first.';
}

$ul = new uLogin('loginSuccessful', 'loginFailed');

//Only run the registration if the form has been submitted. CHeck this variable to verify that.
$action = @$_POST['submit'];

//Instance the SQL class
$mysql = new ProcessMySQL;

//Display protected content
if(isAppLoggedIn()){
	?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../favicon.ico">
      <title>Mail </title>

      <link href="css/bootstrap.min.css" rel="stylesheet">

      <!--Custom styles for this sheet!-->
      <link href="css/protected.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">
				ACM Mail System
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			
			<form class="navbar-form navbar-left" method="GET" role="search">
				<div class="form-group">
					<input type="text" name="q" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="http://psb.acm.org" target="_blank">Visit Site</a></li>

				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div class="container-fluid main-container">
		<div class="col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#">Create Email</a></li>
				<li><a href="#">View Sent Emails</a></li>
				<li><a href="#">Manage Members</a></li>
				<li><a href="http://psb.acm.org/maillist/settings.php">Settings</a></li>
			</ul>
		</div>
		<div class="col-md-10 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                </div>
                <div class="panel-body">
                    <p>Computer Engineers Enrolled: <?php echo $mysql->countUsersByMajor('Computer Engineering'); ?> </p>
                    <p>Software Engineers Enrolled: <?php echo $mysql->countUsersByMajor('Software Engineering'); ?> </p>
                    <p>Compuer Scientists Enrolled: <?php echo $mysql->countUsersByMajor('Computer Science'); ?> </p>
                </div>
            </div>
		</div>
		<footer class="pull-left footer">
			<p class="col-md-12">
				<hr class="divider">
				Bootsnip Copyright &COPY; 2015 Gravitano | Designed for Behrend ACM by Conrad Weiser</a>
			</p>
		</footer>
	</div>
	</body>
</html>


<?php
}
else {
?>

<img src="http://memecrunch.com/meme/11CRJ/you-better-get-outta-here-cowboy/image.png">

<?php
}
?>