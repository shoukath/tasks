<?php
class User
{
    private $id;
    private $userId;
    private $password;
    private $firstname;
    private $lastname;
    
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
	
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    public function getUserId()
    {
        return $this->userId;
    }
	
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
	
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    
    public function getFirstname()
    {
        return $this->firstname;
    }
    
	public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    
    public function getLastname()
    {
        return $this->lastname;
    }
}
?>