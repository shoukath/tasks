<?php
class DBConfig
{
    public function connectDB()
    {
		$con = mysql_connect("127.0.0.1:3306","root","admin");
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("test", $con);
		return $con;
		}
}
?>