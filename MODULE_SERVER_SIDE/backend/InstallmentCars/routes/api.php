<?php

use App\Http\Controllers\Api\ApplyingForInstallment;
use App\Http\Controllers\Api\Authentication;
use App\Http\Controllers\Api\Installment;
use App\Http\Controllers\Api\Validation;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/v1/auth/login', [Authentication::class, 'login']);
Route::post('/v1/auth/logout', [Authentication::class, 'logout'])->middleware('auth:sanctum');

Route::post('/v1/validation',[Validation::class,'createValidation'])->middleware('auth:sanctum');
Route::get('/v1/validations',[Validation::class,'getSocietyDataValidation'])->middleware('auth:sanctum');

Route::get('/v1/instalment_cars',[Installment::class,'getAllInstallmentCars'])->middleware('auth:sanctum');
Route::get('/v1/instalment_cars/{id}',[Installment::class,'gettDetailInstallmentCars'])->middleware('auth:sanctum');

Route::post('/v1/applications',[ApplyingForInstallment::class,'createInstallment'])->middleware('auth:sanctum');
Route::get('/v1/applications',[ApplyingForInstallment::class,'getApplications'])->middleware('auth:sanctum');