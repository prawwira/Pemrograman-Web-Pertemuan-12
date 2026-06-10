<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;

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

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'buku_ids' => 'required|array',
            'buku_ids.*' => 'exists:buku,id'
        ], [
            'buku_ids.required' => 'Pilih minimal satu buku untuk dihapus.'
        ]);

        $ids = $request->buku_ids;

        Buku::whereIn('id', $ids)->delete();

        return redirect()->route('buku.index')
            ->with('success', count($ids) . ' buku berhasil dihapus!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            Buku::create($request->validated());

            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    // Export buku ke CSV
    public function export()
    {
        $bukus = Buku::all();

        $filename = 'buku_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($bukus) {

            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Kode Buku',
                'Judul',
                'Kategori',
                'Pengarang',
                'Penerbit',
                'Tahun Terbit',
                'ISBN',
                'Harga',
                'Stok',
                'Bahasa'
            ]);

            // Data Buku
            foreach ($bukus as $buku) {
                fputcsv($file, [
                    $buku->kode_buku,
                    $buku->judul,
                    $buku->kategori,
                    $buku->pengarang,
                    $buku->penerbit,
                    $buku->tahun_terbit,
                    $buku->isbn,
                    $buku->harga,
                    $buku->stok,
                    $buku->bahasa,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $buku->update($request->validated());

            return redirect()->route('buku.show', $buku->id)
                ->with('success', 'Buku berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $judulBuku = $buku->judul;

            // Delete buku
            $buku->delete();

            // Redirect dengan success message
            return redirect()->route('buku.index')
                ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
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
