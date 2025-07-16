@extends('layouts.app-admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4" style="font-weight: 600;"> Dashboard</h2>

    <!-- Kartu Fitur Horizontal -->
    <div class="fitur-grid mb-5">
        <div class="fitur-box">
            <div class="fitur-nama">Master Barang</div>
            <div class="fitur-jumlah">25</div>
        </div>
        <div class="fitur-box">
            <div class="fitur-nama">Barang Masuk</div>
            <div class="fitur-jumlah">130</div>
        </div>
        <div class="fitur-box">
            <div class="fitur-nama">Barang Keluar</div>
            <div class="fitur-jumlah">96</div>
        </div>
        <div class="fitur-box">
            <div class="fitur-nama">Data Barang</div>
            <div class="fitur-jumlah">350</div>
        </div>
        <div class="fitur-box">
            <div class="fitur-nama">Pengajuan</div>
            <div class="fitur-jumlah">5</div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fitur-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .fitur-box {
        background: linear-gradient(to right, #43A047, #66BB6A);
        color: white;
        padding: 20px;
        border-radius: 20px;
        flex: 1 1 200px;
        max-width: 230px;
        min-height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .fitur-box:hover {
        transform: translateY(-5px);
    }

    .fitur-nama {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .fitur-jumlah {
        font-size: 24px;
        font-weight: 700;
    }
</style>
@endpush
