<?php
include("../../config/DBConfig.php");
include("../../config/Constants.php");

class TaskBiz
{
    public function listTasks()
    {
		$dbConfig = new DBConfig();
		$constants = new Constants();
		$con = $dbConfig->connectDB();
		$array = array(); 
		$arrayCategories = array(); 
		$lastCategory = -1;
		$category = null;
		
		session_start();
		$userId = $_SESSION['userId'];
		
		$query = ("");
		mysql_query($query, $con);
		$result = mysql_query("SELECT C.id CAT_ID, C.name CAT_NAME, C.POSITIONX POSITIONX, C.POSITIONY POSITIONY, T.Id TASK_ID, T.taskname TASK_NAME, T.taskdescription TASK_DESCRIPTION, T.createddate TASK_CREATEDATE, T.last_updated TASK_UPDATED_DATE, T.SCHEDULEDDATE TASK_SCHEDULED_DATE, T.taskorder TASK_ORDER, T.priority TASK_PRIORITY, T.status TASK_STATUS FROM CATEGORYS C LEFT JOIN tasks T ON ( C.ID = T.CATEGORYID ) WHERE C.createdby = ".$userId." ORDER BY C.POSITIONX, C.POSITIONY, C.id, T.status, T.Id");

		while($row = mysql_fetch_array($result))
		{
			$task = new Task();
			
			if($row['CAT_ID']==null){
				if($lastCategory==-1){
					$this->helperlistTasks($row, 0, $arrayCategories, $category, $array, $task, true);
				}else{
					$this->helperlistTasks($row, 0, $arrayCategories, $category, $array, $task, false);
				}
				$lastCategory = 0;
				
			}else{
				if($lastCategory!=$row['CAT_ID']){
					$catergoryId = $row['CAT_ID'];
					$this->helperlistTasks($row, $catergoryId, $arrayCategories, $category, $array, $task, true);
				}else{
					$this->helperlistTasks($row, $catergoryId, $arrayCategories, $category, $array, $task, false);
				}
				$lastCategory = $row['CAT_ID'];
			}
		}
    
		if($category!=null){
			array_push($arrayCategories, $category);
		}
		
		mysql_close($con);
		if(true){
			return $arrayCategories;
		}else{
			return null;
		}
    }
    
    private function helperlistTasks($row, $catergoryId, &$arrayCategories, &$category, &$array, &$task, $boolCreateCategoryObj){
    	if($boolCreateCategoryObj){
	    	if($category!=null){
				array_push($arrayCategories, $category);
			}
			$category = new Category();
			$array = array(); 
			
			$category->setId($catergoryId);
			$category->setCategoryname($row['CAT_NAME']);
			$category->setPositionX($row['POSITIONX']);
			$category->setPositionY($row['POSITIONY']);
    	}
		if($row['TASK_NAME']!=null){
			$task->setId($row['TASK_ID']);
			$task->setTaskname($row['TASK_NAME']);
			$task->setTaskDescription($row['TASK_DESCRIPTION']);
			$task->setScheduledDate($row['TASK_SCHEDULED_DATE']);
			$task->setTaskOrder($row['TASK_ORDER']);
			$task->setPriority($row['TASK_PRIORITY']);
			$task->setStatus($row['TASK_STATUS']);
			
			array_push($array, $task);
		}
		
		$category->setTasksList($array);
    }
    
    public function addTask($taskObj)
    {
		$task = new Task();
		$dbConfig = new DBConfig();
		$constants = new Constants();
		$con = $dbConfig->connectDB();
		
		session_start();
		$userId = $_SESSION['userId'];
		
		$query = ("insert into tasks(taskname, createdby,CATEGORYID, CREATEDDATE,status) values('".$taskObj->getTaskname()."', ".$userId.",".$taskObj->getCategoryId().", CURRENT_TIMESTAMP, ".$constants->active.")");
		mysql_query($query, $con);
		
		$result = mysql_query("select Id TASK_ID, taskname TASK_NAME from tasks where id=last_insert_id()", $con);
		while($row = mysql_fetch_array($result)){
			$task->setId($row['TASK_ID']);
			$task->setTaskname($row['TASK_NAME']);
		}
		
		mysql_close($con);
		
		return $task;
    }
    
	public function updateTask($taskObj, $property)
    {
		$dbConfig = new DBConfig();
		$constants = new Constants();
		$con = $dbConfig->connectDB();
		
		$query = "update tasks set ".$property."='".$taskObj->getTaskname()."' where id=".$taskObj->getId(); 
		mysql_query($query, $con);
		//echo($query);
		
		mysql_close($con);
		if(true){
			return true;
		}else{
			return null;
		}
    }
}
?>