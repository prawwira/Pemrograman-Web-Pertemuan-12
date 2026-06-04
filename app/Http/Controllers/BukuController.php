<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::latest()->get();

        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Data dropdown filter
        $kategoriList = Buku::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $tahunList = Buku::select('tahun_terbit')
            ->whereNotNull('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit');

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoriList',
            'tahunList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Akan diimplementasi di pertemuan 12
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Akan diimplementasi di pertemuan 12
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Akan diimplementasi di pertemuan 12
    }

    /**
     * Filter buku berdasarkan kategori.
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $kategoriList = Buku::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $tahunList = Buku::select('tahun_terbit')
            ->whereNotNull('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit');

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori',
            'kategoriList',
            'tahunList'
        ));
    }

    /**
     * Search dan filter advanced buku.
     */
    public function search(Request $request)
    {
        $query = Buku::query();

        $keyword = $request->input('keyword');
        $kategori = $request->input('kategori');
        $tahun = $request->input('tahun');
        $ketersediaan = $request->input('ketersediaan', 'semua');

        // Search keyword di judul, pengarang, penerbit
        $query->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        });

        // Filter kategori
        $query->when($kategori, function ($q) use ($kategori) {
            $q->where('kategori', $kategori);
        });

        // Filter tahun
        $query->when($tahun, function ($q) use ($tahun) {
            $q->where('tahun_terbit', $tahun);
        });

        // Filter ketersediaan
        $query->when($ketersediaan !== 'semua', function ($q) use ($ketersediaan) {
            if ($ketersediaan === 'tersedia') {
                $q->where('stok', '>', 0);
            } elseif ($ketersediaan === 'habis') {
                $q->where('stok', 0);
            }
        });

        $bukus = $query->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $kategoriList = Buku::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $tahunList = Buku::select('tahun_terbit')
            ->whereNotNull('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit');

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoriList',
            'tahunList',
            'keyword',
            'kategori',
            'tahun',
            'ketersediaan'
        ));
    }
}
