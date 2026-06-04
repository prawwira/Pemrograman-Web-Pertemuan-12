@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="container">
    <h1>Tambah Buku</h1>

    <form>
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input type="text" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>
    </form>
</div>
@endsection