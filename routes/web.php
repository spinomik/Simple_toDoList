<?php

use App\Enums\PrivilegeEnum;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPrivilege;

Route::get('/',  [HomeController::class, 'index'])->name('home');
Route::get('/public/tasks/{token}', [TaskController::class, 'showPublic'])
    ->name('tasks.showPublic');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_READ->value)
        ->get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_CREATE->value)
        ->get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_CREATE->value)
        ->post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_READ->value)
        ->get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_EDIT->value)
        ->get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_EDIT->value)
        ->put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::TASK_DELETE->value)
        ->delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');


    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_READ->value)
        ->get('/users', [UserController::class, 'index'])->name('users.index');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_EDIT->value)
        ->patch('/users/{user}/blockUser', [UserController::class, 'blockUser'])->name('users.block_user');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_EDIT->value)
        ->post('/users/{user}/privileges', [UserController::class, 'togglePrivilege'])->name('users.toggle_privilege');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_DELETE->value)
        ->delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_DELETE->value)
        ->get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::USER_DELETE->value)
        ->patch('/users/{user}', [UserController::class, 'update'])->name('users.update');


    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::PUBLIC_TOKEN_GENERATE->value)
        ->post('/public-tokens/{task}/generate', [TaskController::class, 'generateToken'])
        ->name('publicTokens.generate');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::PUBLIC_TOKEN_GENERATE->value)
        ->patch('/public-tokens/{token}/deactivate', [TaskController::class, 'deactivateToken'])
        ->name('publicTokens.deactivate');
    Route::middleware(CheckPrivilege::class . ':' . PrivilegeEnum::PUBLIC_TOKEN_DELETE->value)
        ->delete('/public-tokens/{token}/delete', [TaskController::class, 'deleteToken'])
        ->name('publicTokens.delete');
});

// Import pliku routingu auth.php
require __DIR__ . '/auth.php';
