<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return response()->json([
        'sukses' => true,
        'pesan'  => 'API Pemweb II aktif',
        'waktu'  => now()->toIso8601String(),
    ]);
});

Route::apiResource('mahasiswa', MahasiswaController::class);
Route::apiResource('matakuliah', MatakuliahController::class);

Route::get('/program-studi/{programStudi}/mahasiswa', function (ProgramStudi $programStudi, Request $request) {
    $perHalaman = min($request->integer('per_halaman', 10), 100);
    $mahasiswa = $programStudi->mahasiswa()->paginate($perHalaman);

    return response()->json([
        'sukses' => true,
        'data' => \App\Http\Resources\MahasiswaResource::collection($mahasiswa),
        'pagination' => [
            'total' => $mahasiswa->total(),
            'halaman_sekarang' => $mahasiswa->currentPage(),
            'per_halaman' => $mahasiswa->perPage(),
            'total_halaman' => $mahasiswa->lastPage(),
        ],
    ]);
});