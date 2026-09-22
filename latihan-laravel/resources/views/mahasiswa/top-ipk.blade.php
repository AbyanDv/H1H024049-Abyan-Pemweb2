@extends('layouts.app')

@section('judul', 'IPK Tertinggi Teknik Komputer')

@section('konten')
<h1 class="h3 mb-4">10 Mahasiswa IPK Tertinggi — Teknik Komputer</h1>

<table class="table table-striped bg-white">
    <thead>
        <tr>
            <th>#</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Angkatan</th>
            <th>IPK</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daftarMahasiswa as $index => $mahasiswa)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><a href="{{ route('mahasiswa.detail', $mahasiswa) }}">{{ $mahasiswa->nim }}</a></td>
            <td>{{ $mahasiswa->nama }}</td>
            <td>{{ $mahasiswa->programStudi->nama ?? '-' }}</td>
            <td>{{ $mahasiswa->angkatan }}</td>
            <td>{{ $mahasiswa->ipk }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data mahasiswa Teknik Komputer.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<a href="{{ route('mahasiswa.data') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
