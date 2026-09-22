@extends('layouts.app')

@section('judul', 'Portal Aplikasi')

@section('konten')

{{-- Warna slide carousel (flat, tanpa gradient) --}}
<style>
    .slide-panel { height: 300px; }
    .slide-panel-1 { background: #4f46e5; }
    .slide-panel-2 { background: #0e7490; }
    .slide-panel-3 { background: #334155; }
    .carousel-indicators [data-bs-target] {
        width: 22px; height: 4px; border: 0; border-radius: 999px;
        background-color: rgba(255, 255, 255, .5);
    }
    .carousel-indicators .active { background-color: #fff; }
</style>

{{-- Hero --}}
<section class="text-bg-primary rounded-3 p-4 p-md-5 mb-4">
    <span class="badge text-bg-light text-primary mb-3">Semester Genap 2025/2026</span>
    <h1 class="fw-bold mb-3">Portal Praktikum Pemrograman Web II</h1>
    <p class="mb-4 opacity-75" style="max-width: 42rem;">
        Kumpulan modul praktikum: controller dasar, data mata kuliah, dan relasi Eloquent dengan pagination.
    </p>
    <a href="#modul" class="btn btn-light">Lihat Modul</a>
    <a href="{{ route('mahasiswa.data') }}" class="btn btn-outline-light">Mulai Modul 3</a>
</section>

{{-- Carousel --}}
<div id="modulCarousel" class="carousel slide rounded-3 overflow-hidden border mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#modulCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#modulCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#modulCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner text-white text-center">
        <div class="carousel-item active">
            <div class="slide-panel slide-panel-1 d-flex flex-column align-items-center justify-content-center p-4">
                <div class="display-6 mb-2">🧩</div>
                <h3 class="fw-bold mb-2">Controller Dasar</h3>
                <p class="small mb-0 opacity-75" style="max-width: 26rem;">
                    Alur request ke response: dari route, controller, sampai view.
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="slide-panel slide-panel-2 d-flex flex-column align-items-center justify-content-center p-4">
                <div class="display-6 mb-2">🗂️</div>
                <h3 class="fw-bold mb-2">Data Terstruktur</h3>
                <p class="small mb-0 opacity-75" style="max-width: 26rem;">
                    Data mata kuliah disajikan rapi dan mudah ditelusuri.
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="slide-panel slide-panel-3 d-flex flex-column align-items-center justify-content-center p-4">
                <div class="display-6 mb-2">🔗</div>
                <h3 class="fw-bold mb-2">Eloquent &amp; Relasi</h3>
                <p class="small mb-0 opacity-75" style="max-width: 26rem;">
                    Relasi antar tabel dengan pagination otomatis.
                </p>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#modulCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#modulCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Berikutnya</span>
    </button>
</div>

{{-- Daftar Modul --}}
<section id="modul" class="mb-4">
    <h2 class="fw-bold mb-3">Daftar Modul</h2>
    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach ([
            ['📋', 'Data Mahasiswa Lama',      'Menampilkan data mahasiswa via controller dasar.',    'mahasiswa.index'],
            ['📖', 'Data Mata Kuliah',         'Daftar seluruh mata kuliah yang tersedia.',           'matakuliah.index'],
            ['⚡', 'Data Mahasiswa (Eloquent)','Relasi program studi dengan pagination otomatis.',    'mahasiswa.data'],
        ] as [$icon, $title, $desc, $route])
            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="fs-3 mb-2">{{ $icon }}</div>
                        <h5 class="card-title fw-bold">{{ $title }}</h5>
                        <p class="card-text text-body-secondary small">{{ $desc }}</p>
                        <a href="{{ route($route) }}" class="btn btn-sm btn-outline-primary mt-auto align-self-start">
                            Buka Halaman
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Detail Modul --}}
<section class="mb-4">
    <h2 class="fw-bold mb-3">Detail Modul</h2>
    <div class="accordion" id="modulAccordion">
        @foreach ([
            ['Modul 1 — Data Mahasiswa Lama',         'Mengambil dan menampilkan data mahasiswa dengan controller dasar, tanpa Eloquent.'],
            ['Modul 2 — Data Mata Kuliah',            'Menampilkan daftar mata kuliah untuk kebutuhan akademik.'],
            ['Modul 3 — Data Mahasiswa (Eloquent)',   'Eloquent ORM dengan relasi ke program studi dan pagination.'],
        ] as $i => [$title, $body])
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseModul{{ $i + 1 }}"
                            aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                            aria-controls="collapseModul{{ $i + 1 }}">
                        {{ $title }}
                    </button>
                </h2>
                <div id="collapseModul{{ $i + 1 }}"
                     class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                     data-bs-parent="#modulAccordion">
                    <div class="accordion-body text-body-secondary small">{{ $body }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Footer --}}
<footer class="border-top pt-3 mt-4 text-center text-body-secondary small">
    © 2026 <strong class="text-body">Abyan Devadi</strong> — Praktikum Pemrograman Web II
</footer>

@endsection