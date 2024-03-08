<?php
use Ramsey\Uuid\Uuid;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserAccountController{
  public UserAccountService $service;

  function __construct(UserAccountService $service)
  {
    $this->service = $service;
  }
  public function CreateUserAccount(Request $req, Response $res){
    $body = $req->getBody()->getContents();
    $data = json_decode($body);
    $user_id = '';
    if(isset($data->user_id)){
      $user_id = $data->user_id;
    }else{
      $user_id = Uuid::uuid4();
    }
    $user_account = new UserAccount($user_id, $data->email, $data->password);
    try{
      $this->service->AddUserAccount($user_account);
      $res = $res->withStatus(200);
      $data = json_encode($user_account);
      $res->getBody()->write($data);
      return $res;
    }catch(Exception $e){
      if($e->getCode() == 409){
        $res = $res->withStatus(409);
        $res->getBody()->write("Duplicate userID");
      }elseif($e->getCode() == 400){
        $res = $res->withStatus(400);
        $res->getBody()->write("Email is invalid");
      }else{
        $res = $res->withStatus(500);
        $res->getBody()->write("Errors from server, pls go back later");
      }
      return $res;
    }
  }

  public function UpdateUserAccount(Request $req, Response $res){
    $body = $req->getBody()->getContents();
    $data = json_decode($body);
    if(!isset($data->password)){
      $res = $res->withStatus(400);
      $res->getBody()->write("Password is required");
      return $res;
    }
    $user_account = new UserAccount(userID: $req->getAttribute('id'),password: $data->password);
    try{
      $this->service->UpdateUserAccount($user_account);
      $res = $res->withStatus(200);
      $data = array(
        "message"=> "update successfully",
        "user_acccount"=> $user_account
      );
      $res->getBody()->write(json_encode($data));
      return $res;
    }catch(Exception $e){
      if($e->getCode() == 404){
        $res = $res->withStatus(404);
      $res->getBody()->write($e->getMessage());
      }else{
        $res = $res->withStatus(500);
        $res->getBody()->write("Errors from server, pls go back later");
      }
      return $res;
    }
  }
}
?>