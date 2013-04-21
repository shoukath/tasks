<?php
include("../../objects/user.php");
include("../../objects/category.php");
include("../../controller/CategoryCtl.php");

$user = new User();
$categoryCtl = new CategoryCtl();
/*
"category": portlet.find("input[name=categoryId]").val(),
						"positionX": positionX,
						"positionY": positionY,
						"editType": "P"
*/

if($_POST["editType"]=="P"){
	$category = new Category();
	$category->setId($_POST["categoryId"]);
	$category->setPositionX($_POST["positionX"]);
	$category->setPositionY($_POST["positionY"]);
	
	$json = $categoryCtl->setPosition($category);
	echo($json);
}else if($_POST["editType"]=="A"){
	$category = new Category();
	$category->setCategoryname($_POST["categoryName"]);
	
	$json = $categoryCtl->addCategory($category);
	echo($json);
}
?>