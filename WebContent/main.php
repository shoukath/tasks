<?php
include("../objects/user.php");
include("../controller/loginUserctl.php");

$user = new User();
$member = new LoginUserCtl();

$user->setUserId($_POST["username"]);
$user->setPassword($_POST["password"]);
$user = $member->loginUser($user->getUserId(), $user->getPassword());
if($user==null){
	header( 'Location: index.php' ) ;
}
session_start();
$_SESSION['userId']=$user->getId();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Tasks</title>
	<link rel="stylesheet" type="text/css" href="./css/reset.css" media="all" />
	<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.19.custom.css" media="all" />
	<link rel="stylesheet" type="text/css" href="./css/task.css" media="all" />
	<script type="text/javascript" src="./scripts/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery-ui-1.8.19.custom.min.js"></script>
	<script type="text/javascript" src="./scripts/date.js"></script>
</head>
<body style="font-size: 11px;">
	<div id="wrapper">
	<div id="header">
		<div id="logo1"></div>
		<div id="headerRight"><?php echo("Hi ".$user->getFirstname()); ?> | <a href="logout.php">Logout</a></div>
	</div>
	<div id="menubar">
		<button class="menuButton" id="btnAddCategory">Add New Category</button>
	</div>

	<div id="container">
		<div class="columnCalender"><div id="datepicker"></div></div>
		
		<div class="column" id="column_1"></div>
		<div class="column" id="column_2"></div>
		<div class="column" id="column_3"></div>
	</div><!-- End container -->
	</div>
	<script type="text/javascript" src="./scripts/tasks/tasks.js"></script>
</body>
</html>

