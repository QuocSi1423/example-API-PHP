<?php

  interface IUserAccountStorage{
    public function insertUserAccount(UserAccount $data);
    public function updateUserAccount(UserAccount $data);
    public function getAllUserAccount():array;
    public function getAnUserAccount(int $id):UserAccount;
    public function deleteUserAccount(int $id);
  }

// ?>