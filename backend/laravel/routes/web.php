<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CityWebController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cities', [CityWebController::class, 'index'])->name('cities.index');
Route::get('/cities/filter', [CityWebController::class, 'filter'])->name('cities.filter');
Route::get('/cities/export/csv', [CityWebController::class, 'exportCsv'])->name('cities.export.csv');
Route::get('/cities/export/pdf', [CityWebController::class, 'exportPdf'])->name('cities.export.pdf');
