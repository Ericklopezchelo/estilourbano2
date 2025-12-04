<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\BarberoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServicioController;
use App\Http\Middleware\CspMiddleware;

// ----------------------
// Middleware global CSP
// ----------------------
Route::middleware([CspMiddleware::class])->group(function () {

    // ======================
    // Rutas Públicas
    // ======================
    Route::get('/', [PaginasController::class, 'index'])->name('inicio');
    Route::get('/servicios', [PaginasController::class, 'servicios'])->name('servicios');
    Route::get('/nosotros', [PaginasController::class, 'nosotros'])->name('nosotros');

    // ======================
    // Autenticación Clientes
    // ======================
    Route::get('/login_cliente', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login_cliente', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Login con Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // ======================
    // Recuperar contraseña
    // ======================
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // ======================
    // Usuarios autenticados
    // ======================
    Route::middleware(['auth'])->group(function () {

        Route::get('/perfil', [ReservasController::class, 'perfil'])->name('perfil.editar');
        Route::post('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');

        Route::post('/reservas', [ReservasController::class, 'store'])->name('reservas.store');
        Route::post('/reservas/horas-ocupadas', [ReservasController::class, 'horasOcupadas'])->name('reservas.horas.ocupadas');
        Route::post('/reservas/{id}/cancelar', [ReservasController::class, 'cancelarReserva'])->name('reservas.cancelar');
        Route::post('/reservas/{id}/reprogramar', [ReservasController::class, 'reprogramarReserva'])->name('reservas.reprogramar');

        // Crear contraseña si no tiene
        Route::get('/perfil/crear-contrasena', [PerfilController::class, 'mostrarCrearContrasenaForm'])->name('perfil.crearContrasenaForm');
        Route::post('/perfil/crear-contrasena', [PerfilController::class, 'crearContrasena'])->name('perfil.crearContrasena');
    });

    // ======================
    // Personal - Staff login
    // ======================
    Route::get('/staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login.form');
    Route::post('/staff/login', [StaffAuthController::class, 'login'])->name('staff.login.submit');

    // ======================
    // Barbero Middleware
    // ======================
    Route::middleware(['auth', 'barbero'])->group(function () {
        Route::get('/barbero/dashboard', [BarberoController::class, 'dashboard'])->name('barbero.dashboard');
        Route::post('/barbero/avatar', [BarberoController::class, 'updateAvatar'])->name('barbero.avatar.update');

        Route::get('/barbero/citas', [BarberoController::class, 'verCitas'])->name('barbero.citas');
        Route::post('/barbero/citas/{id}/estado', [BarberoController::class, 'cambiarEstado'])->name('barbero.cambiar.estado');

        Route::post('/barbero/logout', [BarberoController::class, 'logout'])->name('staff.logout');
    });

    // ======================
    // Admin Middleware
    // ======================
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
        Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // CRUD Barberos
        Route::post('/admin/barberos', [AdminController::class, 'store'])->name('barberos.store');
        Route::get('/admin/barberos/{id}/edit', [AdminController::class, 'editBarbero'])->name('admin.barbero.edit');
        Route::put('/admin/barbero/{id}', [AdminController::class, 'updateBarbero'])->name('admin.barbero.update');
        Route::delete('/admin/barberos/{id}', [AdminController::class, 'deleteBarbero'])->name('admin.barbero.delete');

        // CRUD Servicios
        Route::post('/admin/servicios', [AdminController::class, 'storeServicio'])->name('servicios.store');
        Route::put('/admin/servicios/{id}', [AdminController::class, 'updateServicio'])->name('servicios.update');
        Route::delete('/admin/servicios/{id}', [AdminController::class, 'deleteServicio'])->name('servicios.delete');

        // Reportes
        Route::get('/admin/reporte-reservas', [AdminController::class, 'reporteReservas'])->name('admin.reporte.reservas');
        Route::get('/admin/reporte-reservas/pdf', [AdminController::class, 'reporteReservasPDF'])->name('admin.reporte.reservas.pdf');
    });

});
