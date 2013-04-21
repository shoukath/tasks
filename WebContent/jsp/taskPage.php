<?php
include("../../objects/user.php");
include("../../objects/Task.php");
include("../../objects/category.php");
include("../../controller/TaskCtl.php");

$user = new User();
$taskObj = new Task();
$taskCtl = new TaskCtl();

if($_POST["editType"]=="A"){
	$taskObj->setTaskname($_POST["taskname"]);
	$taskObj->setCategoryId($_POST["categoryId"]);
	echo($taskCtl->addTask($taskObj));
	
}else if($_POST["editType"]=="U"){
	$taskObj->setId($_POST["taskid"]);
	$taskObj->setTaskname($_POST["updateFieldValue"]);
	$property = $_POST["property"];
	$taskCtl->updateTask($taskObj, $property);
	echo("{");
	echo("\"resp\": \"updated\"");
	echo("}");
}else if($_POST["editType"]=="L"){
	$json = $taskCtl->listTasks();
	echo($json);
}
?>