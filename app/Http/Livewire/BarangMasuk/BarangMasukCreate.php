<?php

namespace App\Http\Livewire\BarangMasuk;

use Livewire\Component;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangMasukCreate extends Component
{
    public $namaBarang;
    public $serialNumber;
    public $merek;
    public $warna;
    public $kategori;
    public $satuan;
    public $qty = 1;
    public $namaSupplier;
    public $alamatSupplier;
    public $noTlp;
    public $namaPeruhasaan;

    protected $rules = [
        'kategori' => 'required|numeric',
        'serialNumber' => 'required|numeric|min:3',
        'namaSupplier' => 'required|min:5'
    ];

    protected $messages = [
        'kategori.required' => 'Kategori Wajib Di Isi',
        'serialNumber.required' => 'Serial Number Wajib Diisi',
        'serialNumber.numeric' => 'Serial Number Hanya Berisi Angka'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $listeners = [
        'setKategori',
        'setSatuan',
    ];

    public function setKategori($params)
    {
        $this->kategori = $params[0];
    }

    public function setSatuan($params)
    {
        $this->satuan = $params[0];
    }

    public function clear()
    {
        $this->namaBarang = null;
        $this->serialNumber = null;
        $this->merek = null;
        $this->warna = null;
        // $this->kategori = null;
        // $this->satuan = null;
        $this->qty = 1;
        $this->namaSupplier = null;
        $this->alamatSupplier = null;
        $this->noTlp = null;
        $this->namaPeruhasaan = null;
        $this->render();
    }

    public function submit()
    {
        $barcode = Str::limit($this->namaBarang, 1, '') . date('Y') . Str::limit($this->merek, 1, '') . date('m') . date('d');
        $barang = Barang::create([
            'serial_number' => $this->serialNumber,
            'barcode' => $barcode,
            'nama_barang' => $this->namaBarang,
            'merek' => $this->merek,
            'warna' => $this->warna,
            'satuan' => $this->satuan,
            'stok' => $this->qty,
            'kategori_id' => $this->kategori
        ]);

        if ($barang) {
            $supplier = Supplier::create([
                'nama_supplier' => $this->namaSupplier,
                'nama_perusahaan' => $this->namaPeruhasaan,
                'no_tlp' => $this->noTlp,
                'alamat' => $this->alamatSupplier
            ]);
        }

        if ($barang && $supplier) {
            $barangMasuk = BarangMasuk::create([
                'serial_number' => $this->serialNumber,
                'barcode' => $barcode,
                'nama_barang' => $this->namaBarang,
                'merek' => $this->merek,
                'warna' => $this->warna,
                'satuan' => $this->satuan,
                'qty' => $this->qty,
                'kategori_id' => $this->kategori,
                'tanggal_masuk' => date('Y-m-d'),
                'supplier_id' => $supplier->id
            ]);
            $message = 'Berhasil Menambah Data';
            // session()->flash('successAdd', 'Berhasil Menambah Data');
            // $this->dispatchBrowserEvent('swal:modal', [
            //     'type' => 'success',
            //     'title' => 'success Add Data',
            //     'button' => false,
            //     'timer' => 4000,
            // ]);
        } else {
            session()->flash('error', 'Terjadi Kesalahan');
            $message = "Terjadi Kesalahan";
        }
        $this->emit('barangMasukAdded', $message);
        $this->clear();
    }

    public function showAlert()
    {
        dd('good');
        $this->emit('barangMasukAdded');
    }

    public function render()
    {
        return view('livewire.barang-masuk.barang-masuk-create', [
            'kategoris' => Kategori::orderByDesc('nama_kategori')->get(),
        ]);
    }
}