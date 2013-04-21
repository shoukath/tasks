<?php
include("../config/DBConfig.php");
if (!class_exists('User')) {
    include("../objects/user.php");
}
class MemberBiz
{
    public function loginUser($id, $password)
    {
		$user = new User();
		$dbConfig = new DBConfig();
		$count = 0;
		
		$con = $dbConfig->connectDB();
		$query = ("select * from users where userid='".$id."' and passwords='".$password."'");
		$result = mysql_query($query, $con);
		while($row = mysql_fetch_array($result)){
			$user->setId($row['id']);
			$user->setUserId($row['userid']);
			$user->setPassword($row['passwords']);
			$user->setFirstname($row['firstname']);
			$count++;
		}
		
		mysql_close($con);
		if($count==1){
			return $user;
		}else{
			return null;
		}
    }
    
	public function registerUser($user)
    {
		$dbConfig = new DBConfig();
		$count = 0;
		
		$con = $dbConfig->connectDB();
		
    	$query = ("insert into users(userid, passwords, firstname, lastname) values('".$user->getUserId()."','".$user->getPassword()."','".$user->getFirstname()."','".$user->getLastname()."')");
		mysql_query($query, $con);
		
		//$result = mysql_query("select userid, passwords from users where id=last_insert_id()", $con);
    	$query = ("select * from users where id=last_insert_id()");
		$result = mysql_query($query, $con);
		while($row = mysql_fetch_array($result)){
			$user->setId($row['id']);
			$user->setUserId($row['userid']);
			$user->setPassword($row['passwords']);
			$user->setFirstname($row['firstname']);
			$count++;
		}
		
		mysql_close($con);
		
		return $user;
    }
}
?>