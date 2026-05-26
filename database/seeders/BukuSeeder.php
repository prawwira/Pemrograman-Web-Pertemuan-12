<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukuList = [
            [
                'kode_buku' => 'BK001',
                'judul' => 'Pemrograman Laravel untuk Pemula',
                'kategori' => 'Programming',
                'pengarang' => 'John Doe',
                'penerbit' => 'Tech Books Publishing',
                'tahun_terbit' => 2020,
                'isbn' => '978-1234567890',
                'harga' => 150000.00,
                'stok' => 10,
                'deskripsi' => 'Buku ini memberikan panduan lengkap tentang pemrograman Laravel untuk pemula.',
                'bahasa' => 'Indonesia',
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Desain UI/UX untuk Aplikasi Mobile',
                'kategori' => 'Design',
                'pengarang' => 'Jane Smith',
                'penerbit' => 'Creative Design Press',
                'tahun_terbit' => 2021,
                'isbn' => '978-0987654321',
                'harga' => 200000.00,
                'stok' => 5,
                'deskripsi' => 'Buku ini membahas prinsip-prinsip desain UI/UX untuk aplikasi mobile.',
                'bahasa' => 'Indonesia',
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'Database MySQL untuk Pemula',
                'kategori' => 'Database',
                'pengarang' => 'Alice Johnson',
                'penerbit' => 'Data Science Books',
                'tahun_terbit' => 2019,
                'isbn' => '978-1122334455',
                'harga' => 120000.00,
                'stok' => 8,
                'deskripsi' => 'Buku ini memberikan pengenalan tentang database MySQL untuk pemula.',
                'bahasa' => 'Indonesia',
            ],
            [
                'kode_buku' => 'BK004',
                'judul' => 'Jaringan Komputer untuk Pemula',
                'kategori' => 'Networking',
                'pengarang' => 'Bob Williams',
                'penerbit' => 'Network Books Publishing',
                'tahun_terbit' => 2018,
                'isbn' => '978-5566778899',
                'harga' => 180000.00,
                'stok' => 12,
                'deskripsi' => 'Buku ini memberikan dasar-dasar jaringan komputer untuk pemula.',
                'bahasa' => 'Indonesia',
            ],
            [
                'kode_buku' => 'BK005',
                'judul' => 'Keamanan Siber untuk Pemula',
                'kategori' => 'Security',
                'pengarang' => 'Charlie Brown',
                'penerbit' => 'Cyber Security Press',
                'tahun_terbit' => 2022,
                'isbn' => '978-6677889900',
                'harga' => 250000.00,
                'stok' => 7,
                'deskripsi' => 'Buku ini membahas konsep dasar keamanan siber untuk pemula.',
                'bahasa' => 'Indonesia',
            ],
        ];

        foreach ($bukuList as $buku) {
            Buku::create($buku);
        }
    }
}
