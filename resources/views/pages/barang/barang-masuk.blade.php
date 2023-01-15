@extends('App')

@section('content')

<div class="row justify-content-start px-4 py-5">
    <div class="col-md-8">
        <livewire:barang-masuk.barang-masuk-list>
    </div>
</div>

<div class="row justify-content-center px-4 py-5">
    <div class="col-md-10">
        <livewire:barang-masuk.barang-masuk-index >
    </div>
</div>

<div class="modal fade" id="ModalDataBarang">
    <div class="modal-dialog">
        @php
            Request::is('barang/masuk') ? $where = 'm' : $where = 'k';
        @endphp
        <div class="modal-content rounded-1" style="width: 544px; padding:20px;">
            <livewire:barang-keluar.barang-list :where='$where'>
        </div>
    </div>
</div>
@endsection