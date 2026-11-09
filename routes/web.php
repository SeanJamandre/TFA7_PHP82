<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::redirect('/', '/customers');
Route::resource('customers', CustomerController::class)->except(['show', 'destroy']);
Route::resource('users', UserController::class)->except(['show', 'destroy']);
