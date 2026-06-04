<?php

use Illuminate\Support\Facades\Route;
use App\Models\Buku;
use App\Models\Anggota;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;

Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::resource('buku', BukuController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('buku', BukuController::class);

Route::get(
    'buku/kategori/{kategori}',
    [BukuController::class, 'filterKategori']
)->name('buku.kategori');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('anggota', function () {
    return view('anggota.index');
})->name('anggota.index');

Route::get('/test-accessor-scope', function () {

    $html = '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">
        <h1>Testing Accessor & Scope</h1>
    ';

    // =========================
    // ACCESSOR BUKU
    // =========================
    $html .= '<h3 class="mt-4">Status Stok Buku</h3>';

    $bukus = Buku::all();

    foreach ($bukus as $buku) {

        $html .= '
        <div class="mb-3">
            <strong>' . $buku->judul . '</strong><br>
            Status: ' . $buku->status_stok_badge . '<br>
            Tahun: ' . $buku->tahun_label . '
        </div>
        ';
    }

    // =========================
    // BUKU TERBARU
    // =========================
    $html .= '<h3 class="mt-4">Buku Terbaru</h3>';

    $terbaru = Buku::terbaru()->get();

    foreach ($terbaru as $buku) {

        $html .= '
        <p>' . $buku->judul . ' (' . $buku->tahun_terbit . ')</p>
        ';
    }

    // =========================
    // STOK MENIPIS
    // =========================
    $html .= '<h3 class="mt-4">Buku Stok Menipis</h3>';

    $menipis = Buku::stokMenipis()->get();

    foreach ($menipis as $buku) {

        $html .= '
        <p>' . $buku->judul . ' - Stok: ' . $buku->stok . '</p>
        ';
    }

    // =========================
    // ACCESSOR ANGGOTA
    // =========================
    $html .= '<h3 class="mt-4">Status Anggota</h3>';

    $anggota = Anggota::all();

    foreach ($anggota as $a) {

        $html .= '
        <div class="mb-3">
            <strong>' . $a->nama . '</strong><br>
            Status: ' . $a->status_badge . '<br>
            Kategori Usia: ' . $a->kategori_usia . '
        </div>
        ';
    }

    // =========================
    // BULAN INI
    // =========================
    $html .= '<h3 class="mt-4">Anggota Terdaftar Bulan Ini</h3>';

    $bulanIni = Anggota::terdaftarBulanIni()->get();

    foreach ($bulanIni as $a) {

        $html .= '
        <p>' . $a->nama . '</p>
        ';
    }

    $html .= '</div>';

    return $html;
});
