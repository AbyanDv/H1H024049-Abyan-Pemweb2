<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'sukses' => true,
        'pesan'  => 'API Pemweb II aktif',
        'waktu'  => now()->toIso8601String(),
    ]);
});

Route::apiResource('mahasiswa', MahasiswaController::class);