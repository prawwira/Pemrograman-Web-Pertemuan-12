<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;
 
// Route default
Route::get('/', function () {
    return view('welcome');
});
 
// Route baru - return text
Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});
 
// Route dengan HTML
Route::get('/info', function () {
    return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
});
 
// Route dengan JSON
Route::get('/buku', function () {
    return [
        'judul' => 'Laravel Programming',
        'pengarang' => 'John Doe',
        'harga' => 150000
    ];
});

// Route dengan parameter required
Route::get('/buku/{id}', function ($id) {
    return "Detail buku dengan ID : " . $id;
});

// Route dengan parameter optional
Route::get('/kategori/{nama?}', function ($nama = 'Semua Kategori') {
    return "Menampilkan kategori : " . $nama;
});

// Route dengan multiple parameter
Route::get('/search/{kategori}/{keyword}', function ($kategori, $keyword) {
    return "Cari buku kategori : $kategori dengan keyword : $keyword";
});

//  Named Route
Route::get('/perpustakaan', function () {
    return 'Halaman Perpustakaan';
})->name('perpus.home');

// Gunakan Named Route
Route::get('/test-route', function () {
    $url = route('perpus.home');
    return "URL untuk halaman perpustakaan adalah : " . $url;
});

// PRAKTIKUM 7

Route::get('/perpustakaan', function () {
    // Data untuk dikirim ke view
    $nama_sistem = "Sistem Perpustakaan Laravel";
    $versi = "12.x";
    $total_buku = 5;
    
    $buku_list = [
        [
            'judul' => 'Pemrograman PHP',
            'pengarang' => 'Budi Raharjo',
            'harga' => 75000,
            'stok' => 10
        ],
        [
            'judul' => 'Laravel Framework',
            'pengarang' => 'Andi Nugroho',
            'harga' => 125000,
            'stok' => 5
        ],
        [
            'judul' => 'MySQL Database',
            'pengarang' => 'Siti Aminah',
            'harga' => 95000,
            'stok' => 0
        ],
        [
            'judul' => 'Web Design',
            'pengarang' => 'Dedi Santoso',
            'harga' => 85000,
            'stok' => 8
        ],
        [
            'judul' => 'JavaScript Modern',
            'pengarang' => 'Rina Wijaya',
            'harga' => 80000,
            'stok' => 12
        ]
    ];
    
    // Return view dengan data
    return view('perpustakaan.index', [
        'nama_sistem' => $nama_sistem,
        'versi' => $versi,
        'total_buku' => $total_buku,
        'buku_list' => $buku_list
    ]);
});

// PRAKTIKUM 8 - Menggunakan Controller

// Route menggunakan Controller
Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);
Route::get('/buku/{id}', [PerpustakaanController::class, 'show']);
Route::get('/about', [PerpustakaanController::class, 'about']);