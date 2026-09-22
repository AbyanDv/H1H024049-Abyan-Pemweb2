<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftar = [
            ['kode' => 'MK001', 'nama' => 'Pemrograman Web II', 'sks' => 3, 'semester' => 5],
            ['kode' => 'MK003', 'nama' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 5],
            ['kode' => 'MK005', 'nama' => 'Internet of Things', 'sks' => 3, 'semester' => 5],
            ['kode' => 'MK006', 'nama' => 'Kecerdasan Buatan', 'sks' => 2, 'semester' => 5],
            ['kode' => 'MK008', 'nama' => 'Sistem Kendali', 'sks' => 3, 'semester' => 5],
        ];

        foreach ($daftar as $item) {
            Matakuliah::updateOrCreate(['kode' => $item['kode']], $item);
        }

        $matakuliahIds = Matakuliah::pluck('id')->all();
        $daftarNilai = ['A', 'AB', 'B', 'BC', 'C', 'D', 'E'];

        Mahasiswa::all()->each(function (Mahasiswa $mahasiswa) use ($matakuliahIds, $daftarNilai) {
            $ambil = collect($matakuliahIds)->shuffle()->take(fake()->numberBetween(3, 5));

            foreach ($ambil as $matakuliahId) {
                $mahasiswa->matakuliahs()->syncWithoutDetaching([
                    $matakuliahId => ['nilai' => fake()->randomElement($daftarNilai)],
                ]);
            }
        });
    }
}
