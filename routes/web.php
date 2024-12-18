<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueTableController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/league-tables', [LeagueTableController::class, 'index']);

