<?phpinclude("../../business/TaskBiz.php");class TaskCtl{	public function listTasks()    {		$task = new TaskBiz();		$arrayCategories = $task->listTasks();				$json = "[";		//$json = $json."".json_encode($arrayCategories->getJSONEncode());		foreach ($arrayCategories as $i => $value) {		    $json = $json."".(json_encode($arrayCategories[$i]->getJSONEncode()));		    if (($i+1)!=count($arrayCategories)){		    	$json = $json.",";		    }		}		$json = $json."]";				return $json;    }    public function addTask($taskObj)    {		$taskBiz = new TaskBiz();		$task = $taskBiz->addTask($taskObj);		$json = $task->getJSONEncode();		return $json;    }    	public function updateTask($taskObj, $property)    {		$taskBiz = new TaskBiz();		if($taskBiz->updateTask($taskObj, $property)){			return true;		}else{			return null;		}    }    }?>