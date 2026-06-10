<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\KodeBukuFormat;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategori = $this->input('kategori');
        $tahun = (int) $this->input('tahun_terbit');

        return [
            'kode_buku' => ['required', 'string', 'max:20', 'unique:buku,kode_buku', new KodeBukuFormat()],
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', Rule::in(['Programming', 'Web Design', 'Database', 'Networking', 'Data Science'])],
            'pengarang' => ['required', 'string', 'max:100'],
            'penerbit' => ['required', 'string', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'isbn' => ['nullable', 'string', 'max:20'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($tahun) {
                    if ($tahun < 2000 && $value > 5) {
                        $fail('Untuk buku dengan tahun terbit di bawah 2000, stok maksimal 5.');
                    }
                },
            ],
            'deskripsi' => ['nullable', 'string'],
            'bahasa' => [
                'required',
                'string',
                'max:20',
                Rule::in(['Indonesia', 'Inggris']),
                function ($attribute, $value, $fail) use ($kategori) {
                    if ($kategori === 'Programming' && $value !== 'Inggris') {
                        $fail('Untuk kategori Programming, bahasa harus Inggris.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.string' => 'Kode buku harus berupa teks.',
            'kode_buku.max' => 'Kode buku maksimal 20 karakter.',
            'kode_buku.unique' => 'Kode buku sudah digunakan.',

            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.max' => 'Judul buku maksimal 200 karakter.',

            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori tidak valid.',

            'pengarang.required' => 'Pengarang wajib diisi.',
            'pengarang.string' => 'Pengarang harus berupa teks.',
            'pengarang.max' => 'Pengarang maksimal 100 karakter.',

            'penerbit.required' => 'Penerbit wajib diisi.',
            'penerbit.string' => 'Penerbit harus berupa teks.',
            'penerbit.max' => 'Penerbit maksimal 100 karakter.',

            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh lebih dari tahun sekarang.',

            'isbn.string' => 'ISBN harus berupa teks.',
            'isbn.max' => 'ISBN maksimal 20 karakter.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',

            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'bahasa.required' => 'Bahasa wajib dipilih.',
            'bahasa.string' => 'Bahasa harus berupa teks.',
            'bahasa.max' => 'Bahasa maksimal 20 karakter.',
            'bahasa.in' => 'Bahasa hanya boleh Indonesia atau Inggris.',
        ];
    }
}
