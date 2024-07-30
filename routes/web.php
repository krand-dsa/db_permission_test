<?php

use Filament\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Neutral routes, neither landlord nor tenant
 */
Route::get('/welcome', function (Request $request) {
    return view('welcome');
});

/**
 * Landlord routes
 * the middleware is defined in bootstrap/app
 */
Route::middleware('landlord')->group(function() {
    // routes
    Route::get('/welcome-landlord', function (Request $request) {
        return view('welcome');
    });
});

/**
 * Tenant routes
 * the middleware is defined in bootstrap/app
 */
Route::middleware('tenant')->group(function() {
    // routes
    Route::get('/welcome-tenant', function (Request $request) {
        return view('welcome');
    });
    Route::get('/db-permission-test', function (Request $request) {
        return view('db-permission-test', ['request' => $request,]);
    });
});
