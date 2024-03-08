<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// require __DIR__ . '/../vendor/autoload.php';
require "../storage/Database.php";
require "../storage/UserAccountStorage.php";
require "../service/UserAccountService.php";
require "../controller/UserAccountController.php";
// Instantiate app
$app = AppFactory::create();

$store = new UserAccountStorage(new DatabaseManager(null));
$service = new UserAccountService($store);
$controller = new UserAccountController($service);

// Add route callbacks
$app->get('/v1/{id}', function (Request $request, Response $response, array $args) {
  $id = $request->getAttribute('id');
  $q = $request->getQueryParams('q');
  $body = $request->getParsedBody();
  $a = $body['a'];
  $b = $body['b'];

  $response->getBody()->write("param: ".$id." query: ".$q. " a+b= ".($a + $b));
  return $response;
});

$app->post('/v1', function (Request $request, Response $response, array $args) use ($controller) {
  return $controller->CreateUserAccount($request, $response);
});

$app->put('/v1/users/{id}',function (Request $request, Response $response, array $args) use ($controller) {
  return $controller->UpdateUserAccount($request, $response);
});
// Run application
$app->run();
