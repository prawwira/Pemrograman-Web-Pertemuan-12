<?php

namespace App\View\Components;

use App\Models\Buku;
use Illuminate\View\Component;
use Illuminate\View\View;

class BukuCard extends Component
{
    public Buku $buku;
    public bool $showActions;

    public function __construct(Buku $buku, bool $showActions = true)
    {
        $this->buku = $buku;
        $this->showActions = $showActions;
    }

    public function render(): View
    {
        return view('components.buku-card');
    }
}
