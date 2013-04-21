<?php
include("../../config/DBConfig.php");
include("../../config/Constants.php");

class CategoryBiz
{
    
    public function setPosition($category)
    {
		$dbConfig = new DBConfig();
		$con = $dbConfig->connectDB();
		echo($category->getId()."      ");
		//echo($category->getPositionX());
		$query = ("update categorys set positiony=positiony+1 where positionx=".$category->getPositionX()." and positiony>=".$category->getPositionY());
		mysql_query($query, $con);
		echo($query."      ");
		
		$query = ("update categorys set positionx=".$category->getPositionX().",positiony=".$category->getPositionY()." where id=".$category->getId());
		mysql_query($query, $con);
		
		echo($query."      ");
		
		mysql_close($con);
		if(true){
			return true;
		}else{
			return null;
		}
    }
    
	public function addCategory($category)
    {
		$dbConfig = new DBConfig();
		$con = $dbConfig->connectDB();
		
		session_start();
		$userId = $_SESSION['userId'];
		
		$query = ("insert into categorys(name, createdby, positionX, positionY, status,createddate) values ('".$category->getCategoryname()."',".$userId.",1,1,1001,CURRENT_TIMESTAMP)");
		mysql_query($query, $con);
		
		$result = mysql_query("select last_insert_id() ID", $con);
		
		$row = mysql_fetch_row($result);
		
		mysql_close($con);

		return $row[0];
    }
    
}
?>