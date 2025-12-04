<?php
//esta apartado de bootstrap es para registrarar los middlewares para que se puedan usar en las rutas web.php o api.php si no se hace esto no se podran usar los middlewares personalizados que creemos en la carpeta app/Http/Middleware
use Illuminate\Foundation\Application;
use App\Http\Middleware\BarberoMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CspMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware): void {
        // Alias para rutas específicas
        $middleware->alias([
            'barbero'=> BarberoMiddleware::class,
            'admin'=> AdminMiddleware::class
        ]);

        // Middleware global
        $middleware->global([
            CspMiddleware::class,
        ]);
    })
    ->withExceptions(function ($exceptions): void {
        //
    })
    ->create();
