<?php
//esta apartado de bootstrap es para registrarar los middlewares para que se puedan usar en las rutas web.php o api.php si no se hace esto no se podran usar los middlewares personalizados que creemos en la carpeta app/Http/Middleware

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\BarberoMiddleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void { //esta parte es para registrar los middlewares.
        //
        $middleware->alias([
            'barbero'=> BarberoMiddleware::class, // esta parte es para registrar el middleware barbero que se encuentra en app/Http/Middleware/BarberoMiddleware.php.
            'admin'=> AdminMiddleware::class
        ]); 
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
