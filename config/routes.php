<?php
return [
    '/' => '/main/site/index',
    'about' => '/main/site/about',
    'contact' => '/main/contact/index',

    'login' => '/user/authorization/login',
    'signup' => '/user/authorization/signup',
    'logout' => '/user/authorization/logout',

    'profile/view/<id:\d+>' => '/main/profile/view'
];