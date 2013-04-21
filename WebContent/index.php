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
		<style type="text/css">
			#signInContainer{
				position: absolute;
				top: 15%;
				left: 50%;
				width: 400px;
				margin-left: -200px;
				text-align: left;
			}
			#signInContainer input{
				border: 1px solid #BFBFBF;
				border-radius: 3px;
				height: 22px;
				margin-bottom: 10px;
				width: 327px;
				padding: 5px;
			}
			
			#signInContainer label{
				position: absolute;
				padding: 9px;
				left: 26px;
				pointer-events: none;
				color: #ebebeb;
			}
		</style>
		<script type="text/javascript">
		$(function() {
			$( "#tabs" ).tabs(
					{
					   	select: function(event, ui) {
							if(ui.panel.id=="tabs-1"){
								$(ui.panel).find("input[name=username]").val("").focus();
							}else{
							}
						}
					}
			);
			$("#loginBtn").button().click(function(){
				$(this).closest("form").submit();
			});
			$("#registerBtn").button().click(function(){
				//$(this).closest("form").submit();
			});
			$("input[name=username]").val("").focus();
			$("#signInContainer input").keypress(function(){
				var input = $(this);
				//if(input.val()==""){
					//input.parent().find("label").text("Email");
				//}else{
					input.parent().find("label").text("");
				//}
			});
			$("#signInContainer input").keyup(function(){
				var input = $(this);
				if(input.val()==""){
					input.parent().find("label").text("Email");
				}else{
					input.parent().find("label").text("");
				}
			});
		});
		</script>
	</head>
	<body>
		<div id="signInContainer">
			<img src="./images/Logo.png" style="margin-bottom: 70px;margin-left: 47px;"/>
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Login</a></li>
					<li><a href="#tabs-2">Register</a></li>
				</ul>
				<div id="tabs-1">
					<form action="main.php" method="post">
						<div><input type="text" name="username" autocomplete="off"/><label class="Email">Email</label></div>
						<div><input type="password" name="password" /><label class="Password">Password</label></div>
						<!-- div style="float: left; font-size: 16px; font-weight: bold;"><input type="checkbox"><span>Remember me</span></div-->
						<div style="text-align: right;"><button id="loginBtn">Login</button></div>
					</form>
				</div>
				<div id="tabs-2">
					<form action="register.php" method="post">
						<div><input type="text" name="firstname" id="firstnameReg" autocomplete="off"/><label for="firstnameReg">First Name</label></div>
						<div><input type="text" name="lastname" autocomplete="off"/><label>Last Name</label></div>
						<br>
						<div><input type="text" name="username" autocomplete="off"/><label class="Email">Email</label></div>
						<div><input type="password" name="password" /><label class="Password">Password</label></div>
						<div><input type="password" name="passwordConfirm" /><label class="Password">Confirm Password</label></div>
						<div style="text-align: right;"><button id="registerBtn">Register</button></div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>