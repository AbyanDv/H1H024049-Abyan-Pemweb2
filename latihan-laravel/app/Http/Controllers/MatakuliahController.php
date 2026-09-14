<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $daftarMatakuliah = [
            ['kode' => 'MK001', 'nama' => 'Pemrograman Web II', 'sks' => 2],
            ['kode' => 'MK002', 'nama' => 'Etika Profesi', 'sks' => 2],
            ['kode' => 'MK003', 'nama' => 'Keamanan Jaringan Komputer', 'sks' => 2],
            ['kode' => 'MK004', 'nama' => 'Internet of Things', 'sks' => 3],
            ['kode' => 'MK005', 'nama' => 'Metode Numerik', 'sks' => 2],
            ['kode' => 'MK006', 'nama' => 'Manajemen Proyek', 'sks' => 2],
            ['kode' => 'MK007', 'nama' => 'Sistem Kendali', 'sks' => 3],
        ];

        return view('matakuliah.index', ['daftarMatakuliah' => $daftarMatakuliah]);
    }

    public function show(string $kode)
    {
        $daftarMatakuliah = [
            ['kode' => 'MK001', 'nama' => 'Pemrograman Web II', 'sks' => 2],
            ['kode' => 'MK002', 'nama' => 'Etika Profesi', 'sks' => 2],
            ['kode' => 'MK003', 'nama' => 'Keamanan Jaringan Komputer', 'sks' => 2],
            ['kode' => 'MK004', 'nama' => 'Internet of Things', 'sks' => 3],
            ['kode' => 'MK005', 'nama' => 'Metode Numerik', 'sks' => 2],
            ['kode' => 'MK006', 'nama' => 'Manajemen Proyek', 'sks' => 2],
            ['kode' => 'MK007', 'nama' => 'Sistem Kendali', 'sks' => 3],
        ];

        $matakuliah = null;

        foreach ($daftarMatakuliah as $mk) {
            if ($mk['kode'] === $kode) {
                $matakuliah = $mk;
                break;
            }
        }

        return view('matakuliah.show', ['matakuliah' => $matakuliah, 'kode' => $kode]);
    }

    public function cari(Request $request)
    {
        $kataKunci = $request->query('q', '');

        return response()->json([
            'kata_kunci' => $kataKunci,
            'metode' => $request->method(),
            'path' => $request->path(),
        ]);
    }
}
