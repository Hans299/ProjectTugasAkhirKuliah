@extends('layouts.admin')

@section('title', 'Dashboard Laboran')

@push('styles')
{{-- CSS khusus untuk kartu statistik --}}
<style>
    .stat-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .stat-card .card-body {
        display: flex;
        align-items: center;
    }
    .stat-card .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1.5rem;
    }
    .text-primary { color: #3B82F6 !important; }
    .bg-primary-light { background-color: #DBEAFE; }
    .text-success { color: #10B981 !important; }
    .bg-success-light { background-color: #D1FAE5; }
    .text-warning { color: #F59E0B !important; }
    .bg-warning-light { background-color: #FEF3C7; }
    .text-danger { color: #EF4444 !important; }
    .bg-danger-light { background-color: #FEE2E2; }

    .stat-card h5 {
        font-size: 1rem;
        font-weight: 500;
        color: #6B7280;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
    }
</style>
@endpush

@section('content')
    {{-- Judul Halaman --}}
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    {{-- Baris Kartu Statistik (Sesuai Desain) --}}
    <div class="row">

        {{-- Kartu 1: Jumlah Alat --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="icon-circle bg-primary-light text-primary">
                        <i class="fa fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h5>Jumlah Alat</h5>
                        {{-- Ganti $jumlahAlat dengan variabel dari Controller --}}
                        <span class="stat-number">{{ $jumlahAlat ?? 100 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Alat Tersedia --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="icon-circle bg-success-light text-success">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div>
                        <h5>Alat Tersedia</h5>
                        <span class="stat-number">{{ $alatTersedia ?? 80 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Alat Dipinjam --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="icon-circle bg-warning-light text-warning">
                        <i class="fa fa-hand-holding"></i>
                    </div>
                    <div>
                        <h5>Alat Dipinjam</h5>
                        <span class="stat-number">{{ $alatDipinjam ?? 15 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu 4: Alat Rusak --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="icon-circle bg-danger-light text-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5>Alat Rusak</h5>
                        <span class="stat-number">{{ $alatRusak ?? 5 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris Grafik --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 10px;">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="card-title fw-bold text-dark">Grafik Peminjaman Alat (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="peminjamanChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script untuk menginisialisasi Grafik --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('peminjamanChart').getContext('2d');
        
        // Data ini idealnya Anda kirim dari Controller
        const dataPeminjaman = [12, 19, 3, 5, 2, 3, 9];
        const labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        const myChart = new Chart(ctx, {
            type: 'line', // Tipe grafik
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: dataPeminjaman,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush