<?php

use App\Middleware\CsrfMiddelware;

// $app->group('' , function(){
//     $this->post('/user/auth/api','AuthApiController:index');

// })->add( new CsrfMiddelware($container));
$app->post('/user/auth/api','AuthApiController:index');
