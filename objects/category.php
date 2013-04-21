<?php
class Category
{
    private $id;
    private $categoryname;
    private $createdby;
    private $positionX;
    private $positionY;
    private $color;
    private $sortBy;
    private $status;
    private $createddate;
    private $lastupdateddate;
    private $tasksList;
    
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
	
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;
    }
    
    public function getCategoryname()
    {
        return $this->categoryname;
    }
	
    public function setCreatedBy($createdby)
    {
        $this->createdby = $createdby;
    }
    
    public function getCreatedBy()
    {
        return $this->createdby;
    }
	
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;
    }
    
    public function getPositionX()
    {
        return $this->positionX;
    }
	
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;
    }
    
    public function getPositionY()
    {
        return $this->positionY;
    }
    
    public function setColor($color)
    {
        $this->color = $color;
    }
    
    public function getColor()
    {
        return $this->color;
    }

    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }
    
    public function getSortBy()
    {
        return $this->sortBy;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setCreatedDate($createddate)
    {
        $this->createddate = $createddate;
    }
    
    public function getCreatedDate()
    {
        return $this->createddate;
    }
	
    public function setLastUpdatedDate($lastupdateddate)
    {
        $this->lastupdateddate = $lastupdateddate;
    }
    
    public function getLastUpdatedDate()
    {
        return $this->lastupdateddate;
    }
    
	public function setTasksList($tasksList)
    {
    	$array = $tasksList;
    	$json = "[";
		foreach ($array as $i => $value) {
		    $json = $json."".(json_encode($array[$i]->getJSONEncode()));
		    if (($i+1)!=count($array)){
		    	$json = $json.",";
		    }
		}
		$json = $json."]";
		$json = str_replace("\"", "", $json);
		$json = str_replace("\\", "\"", $json);
        $this->tasksList = $json;
    }
    
    public function getTasksList()
    {
        return $this->tasksList;
    }
	
}
?>