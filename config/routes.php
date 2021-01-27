<?php
return [
    '/' => '/main/site/index',
    'about' => '/main/site/about',
    'contact' => '/main/contact/index',

    'login' => '/user/authorization/login',
    'signup' => '/user/authorization/signup',
    'logout' => '/user/authorization/logout',

    'profile/view/<name:\w+>' => '/user/profile/view',
    'user/<id:\d+>/subscribe' => '/user/profile/subscribe',
    'user/<id:\d+>/unsubscribe' => '/user/profile/un-subscribe',
];