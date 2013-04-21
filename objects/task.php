<?php
class Task
{
    private $id;
    private $taskname;
    private $taskdescription;
    private $createdby;
    private $categoryid;
    private $createddate;
    private $scheduleddate;
    private $taskOrder;
    private $priority;
    private $status;
    private $locationid;
    
	public function getJSONEncode() {
	    return json_encode(get_object_vars($this));
	}
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
	
    public function setTaskname($taskname)
    {
        $this->taskname = $taskname;
    }
    
    public function getTaskname()
    {
        return $this->taskname;
    }
	
    public function setTaskDescription($taskdescription)
    {
        $this->taskdescription = $taskdescription;
    }
    
    public function getTaskDescription()
    {
        return $this->taskdescription;
    }
	
    public function setCreatedBy($createdby)
    {
        $this->createdby = $createdby;
    }
    
    public function getCreatedBy()
    {
        return $this->createdby;
    }
	
    public function setCategoryId($categoryid)
    {
        $this->categoryid = $categoryid;
    }
    
    public function getCategoryId()
    {
        return $this->categoryid;
    }
	
    public function setCreatedDate($createddate)
    {
        $this->createddate = $createddate;
    }
    
    public function getCreatedDate()
    {
        return $this->createddate;
    }
	
    public function setScheduledDate($scheduleddate)
    {
        $this->scheduleddate = $scheduleddate;
    }
    
    public function getScheduledDate()
    {
        return $this->scheduleddate;
    }
    
	public function setTaskOrder($taskOrder)
    {
        $this->taskOrder = $taskOrder;
    }
    
    public function getTaskOrder()
    {
        return $this->taskOrder;
    }
	
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
    
    public function getPriority()
    {
        return $this->priority;
    }
	
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
	
    public function setLocationId($locationid)
    {
        $this->locationid = $locationid;
    }
    
    public function getLocationId()
    {
        return $this->locationid;
    }
	
}
?>