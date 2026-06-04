<div class="card h-100 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px;">
                <i class="bi bi-book-fill fs-2"></i>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div>
                        <h5 class="card-title mb-1">{{ $buku->judul }}</h5>
                        <p class="text-muted mb-2">{{ $buku->pengarang }}</p>
                    </div>

                    @if(!empty($buku->kategori))
                    <span class="badge bg-info text-dark">{{ $buku->kategori }}</span>
                    @endif
                </div>

                <div class="mb-2">
                    <strong>Harga:</strong>
                    Rp {{ number_format($buku->harga ?? 0, 0, ',', '.') }}
                </div>

                <div class="mb-2">
                    <strong>Stok:</strong> {{ $buku->stok ?? 0 }}
                </div>

                <div class="mb-3">
                    @if(($buku->stok ?? 0) > 0)
                    <span class="badge bg-success">Tersedia</span>
                    @else
                    <span class="badge bg-danger">Habis</span>
                    @endif
                </div>

                @if($showActions)
                <div class="d-flex gap-2">
                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary">
                        Detail
                    </a>
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>