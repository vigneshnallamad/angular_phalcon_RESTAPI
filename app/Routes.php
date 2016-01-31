<?php

$router = new \Phalcon\Mvc\Router();

// list users
$router->addGet("/api/user", "Api::listUser");
// create user
$router->addPost("/api/user", "Api::createUser");
// get user by id
$router->addGet("/api/user/{id}", "Api::getUser");
// edit user by id
$router->add("/api/user/{id}", "Api::editUser")->via(array("POST", "PUT"));
// delete user by id
$router->addDelete("/api/user/{id}", "Api::deleteUser");

return $router;
