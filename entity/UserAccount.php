<?php

class UserAccount implements JsonSerializable{
  private String $userID;
  private String $email;
  private String $password;

  function __construct($userID = '', $email = '', $password = '')
  {
    $this->userID = $userID;
    $this->email = $email;
    $this->password = $password;
  }

  public function setUserID(String $id){
    $this->userID = $id;
  }

  public function getUserID(){
    return $this->userID;
  }

  public function setEmail(String $email){
    $this->email = $email;
  }

  public function setPassword(String $password){
    $this->password = $password;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getPassword(){
    return $this->password;
  }

  public function jsonSerialize(): mixed
  {
    return array(
      'user_id' => $this->userID,
      'email' => $this->email,
      'password' => $this->password
    );
  }

  public function emailIsValid():bool{
    $regStr = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    return preg_match($regStr, $this->email);
  }

  public function passwordIsValid():bool{
    return $this->password != "";
  }
  
}
?>