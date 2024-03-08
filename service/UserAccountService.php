<?php
require_once "../storage/IUserAccountStorage.php";
require_once "../entity/UserAccount.php";

  class UserAccountService{
    private IUserAccountStorage $store;
    public function __construct(IUserAccountStorage $store){
      $this->store = $store;
    }
    
    public function AddUserAccount(UserAccount $data){
      if(!$data->emailIsValid()){
        throw new Exception("Email is not valid", 400);
      }
      $this->store->insertUserAccount($data);
    }

    public function UpdateUserAccount(UserAccount $data){
      if(!$data->passwordIsValid()){
        throw new Exception("Password is not valid", 400);
      }
      $this->store->updateUserAccount($data);
    }
  }
?>