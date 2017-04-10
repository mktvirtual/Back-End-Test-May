<?php

$routes = [
    // 'URL' => 'controllerName/actionName'
    '/' => 'index/index',
    '/login' => 'index/login',
    '/logout' => 'index/logout',
    '/upload/avatar' => 'index/uploadAvatar',
    '/remove/avatar' => 'index/removeAvatar',
    '/upload/post' => 'index/uploadPost',
    '/remove/post' => 'index/removePost',
    '/like' => 'index/like',
    '/user' => 'error/404',
    '/user/profile' => 'error/404'
];