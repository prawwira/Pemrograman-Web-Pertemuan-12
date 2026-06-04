@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1">
            <i class="bi bi-speedometer2"></i> Dashboard
        </h1>
        <p class="text-muted mb-0">Ringkasan statistik perpustakaan</p>
    </div>
</div>

{{-- Statistik Buku --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h6 class="text-muted">Total Buku</h6>
                <h2 class="mb-0">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body">
                <h6 class="text-muted">Buku Tersedia</h6>
                <h2 class="mb-0">{{ $bukuTersedia }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger h-100">
            <div class="card-body">
                <h6 class="text-muted">Buku Habis</h6>
                <h2 class="mb-0">{{ $bukuHabis }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Statistik Anggota --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h6 class="text-muted">Total Anggota</h6>
                <h2 class="mb-0">{{ $totalAnggota }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body">
                <h6 class="text-muted">Anggota Aktif</h6>
                <h2 class="mb-0">{{ $anggotaAktif }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger h-100">
            <div class="card-body">
                <h6 class="text-muted">Anggota Nonaktif</h6>
                <h2 class="mb-0">{{ $anggotaNonaktif }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Buku Terbaru --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <strong>5 Buku Terbaru</strong>
            </div>
            <div class="card-body">
                @forelse ($bukuTerbaru as $buku)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <strong>{{ $buku->judul }}</strong><br>
                        <small class="text-muted">{{ $buku->kategori ?? '-' }}</small>
                    </div>
                    <div class="text-muted">
                        {{ $buku->created_at?->format('d M Y') }}
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">Belum ada data buku.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Anggota Terbaru --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <strong>5 Anggota Terbaru</strong>
            </div>
            <div class="card-body">
                @forelse ($anggotaTerbaru as $anggota)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <strong>{{ $anggota->nama }}</strong><br>
                        <small class="text-muted">{{ $anggota->status ?? '-' }}</small>
                    </div>
                    <div class="text-muted">
                        {{ $anggota->created_at?->format('d M Y') }}
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">Belum ada data anggota.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="card mt-4">
    <div class="card-header bg-white">
        <strong>Quick Links</strong>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('buku.index') }}" class="btn btn-primary">
                <i class="bi bi-book"></i> Menu Buku
            </a>
            <a href="{{ route('anggota.index') }}" class="btn btn-success">
                <i class="bi bi-people"></i> Menu Anggota
            </a>
            <a href="{{ route('buku.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Tambah Buku
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-speedometer2"></i> Refresh Dashboard
            </a>
        </div>
    </div>
</div>
@endsection