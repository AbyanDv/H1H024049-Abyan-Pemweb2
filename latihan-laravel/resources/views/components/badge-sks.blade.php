@php
    $warna = $sks >= 3 ? 'success' : 'secondary';
@endphp

<span class="badge bg-{{ $warna }}">{{ $sks }} SKS</span>