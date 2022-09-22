<?php
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Http\Request;

define('RUN_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

/*
|--------------------------------------------------------------------------
| Create Http Kernel
|--------------------------------------------------------------------------
*/

$kernel = $app->make(Kernel::class);

/*
|--------------------------------------------------------------------------
| Handel the Request Then Send the Response
|--------------------------------------------------------------------------
*/

$request = Request::capture();

$response = $kernel->handle($request);

$response->send();

/*
|--------------------------------------------------------------------------
| Shutdown the Http Kernel
|--------------------------------------------------------------------------
*/

$kernel->terminate($request, $response);
