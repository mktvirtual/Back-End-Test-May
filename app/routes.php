<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('index', new Route('/', ['_controller' => 'UserController::registerAction']));
$collection->add('follow', new Route('/seguir/{username}', ['_controller' => 'UserController::followAction']));
$collection->add('like', new Route('/curtir/{id}', ['_controller' => 'PhotoController::likeAction']));

$collection->add('logout', new Route('/sair', ['_controller' => 'UserController::logoutAction']));
$collection->add('posts', new Route('/fotos/{username}', ['_controller' => 'PhotoController::listAction']));
$collection->add('send-register', new Route('/enviar-cadastro', ['_controller' => 'UserController::sendRegisterAction', '_method' => 'POST']));
$collection->add('login', new Route('/logar', ['_controller' => 'UserController::sendLoginAction', '_method' => 'POST']));

$collection->add('add-photo', new Route('/adicionar-foto', ['_controller' => 'PhotoController::addAction']));
$collection->add('send-photo', new Route('/enviar-foto', ['_controller' => 'PhotoController::sendPhotoAction']));

$collection->add('perfil', new Route('/{username}', ['_controller' => 'UserController::perfilAction']));

return $collection;