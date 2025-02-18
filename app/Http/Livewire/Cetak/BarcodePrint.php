<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\BarcodeKeranjang;

class BarcodePrint extends Component
{
    public $jumlah = 1;

    protected $listeners = [
        'fresh' => 'render',
    ];

    public function render()
    {
        return view('livewire.cetak.barcode-print', [
            'barcodes' => BarcodeKeranjang::all()
        ]);
    }
}