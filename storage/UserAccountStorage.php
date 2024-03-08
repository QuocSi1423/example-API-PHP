<?php
require_once "IUserAccountStorage.php";

class UserAccountStorage implements IUserAccountStorage
{

  private DatabaseManager $db;

  function __construct(DatabaseManager $db)
  {
    $this->db = $db;
  }

  public function insertUserAccount(UserAccount $data)
  {
    $query = "insert into user_accounts values(:userID, :email, :password)";
    try {
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->bindParam(':userID', $data->getUserID());
      $stmt->bindParam(':email', $data->getEmail());
      $stmt->bindParam(':password', $data->getPassword());
      $stmt->execute();
    } catch (PDOException $e) {
      if ($e->getCode() == '23000') { // Mã lỗi 23000 thường liên quan đến integrity constraint violation
        throw new Exception("Conflict", 409);
      } else {
        throw new Exception("Server Error", 500);
      }
    }
  }
  public function updateUserAccount(UserAccount $data)
  {
    $query = "update user_accounts set password = :password where user_id = :userID";
    try {
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->bindParam(':password', $data->getPassword());
      $stmt->bindParam(':userID', $data->getUserID());
      $stmt->execute();
      if($stmt->rowCount() == 0){
        throw new Exception("No User Found",404);
      }
    } catch (PDOException $e) {
        throw new Exception($e->getMessage(), 500);
    }
  }
  public function getAllUserAccount(): array
  {
    return [];
  }
  public function getAnUserAccount(int $id): UserAccount
  {
    return new UserAccount();
  }
  public function deleteUserAccount(int $id)
  {
    return new UserAccount();
  }
}
