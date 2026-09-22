<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Praktikum Pemweb II')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Navbar: selalu memakai tema berlawanan dengan halaman --}}
    <nav class="navbar navbar-expand-lg border-bottom" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="/">Pemweb II</a>
            <button class="btn btn-sm btn-outline-secondary ms-auto" type="button"
                    id="themeToggle" aria-label="Ganti tema">🌙</button>
        </div>
    </nav>

    <main class="container py-4">
        @yield('konten')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tema halaman disimpan di localStorage.
        // Navbar menerapkan tema kebalikannya agar selalu kontras.
        (function () {
            const root = document.documentElement;
            const nav  = document.getElementById('mainNav');
            const btn  = document.getElementById('themeToggle');
            const saved   = localStorage.getItem('theme');
            const initial = saved || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            apply(initial);

            btn.addEventListener('click', () => {
                const next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', next);
                apply(next);
            });

            function apply(theme) {
                const opposite = theme === 'dark' ? 'light' : 'dark';

                root.setAttribute('data-bs-theme', theme);

                nav.setAttribute('data-bs-theme', opposite);
                nav.classList.remove('bg-dark', 'bg-light');
                nav.classList.add(opposite === 'dark' ? 'bg-dark' : 'bg-light');

                btn.textContent = theme === 'dark' ? '☀️' : '🌙';
            }
        })();
    </script>
    @yield('scripts')
</body>
</html>