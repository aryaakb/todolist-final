@extends('layouts.app')

@section('title', 'Laporan Akademik')
@section('header', 'Laporan & Analytics')

@push('styles')
{{-- Style kustom untuk tema gelap di halaman ini --}}
<style>
    :root {
        /* Variabel warna tema UNIMUS */
        --unimus-blue: #0ea5e9;
        --unimus-blue-dark: #0891b2;
        --unimus-gold: #fbbf24;
        --unimus-green: #22c55e;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --border-color: rgba(14, 165, 233, 0.2);
    }

    .chart-card {
        background-color: var(--card-bg);
        backdrop-filter: blur(5px);
        border-radius: 1.25rem;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.1);
    }

    .chart-card h3 {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
{{-- Memuat library Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Grafik: Tugas Selesai per Hari -->
    <div class="chart-card">
        <h3>Tugas Selesai (7 Hari Terakhir)</h3>
        <canvas id="tasksCompletedChart"></canvas>
    </div>

    <!-- Grafik: Distribusi Status Tugas -->
    <div class="chart-card">
        <h3>Distribusi Status Tugas</h3>
        <div class="max-w-xs mx-auto">
            <canvas id="taskStatusChart"></canvas>
        </div>
    </div>

    <!-- Grafik: Kinerja Pengguna -->
    <div class="lg:col-span-2 chart-card">
        <h3>Top 5 Pengguna (Berdasarkan Tugas Selesai)</h3>
        <canvas id="userPerformanceChart"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mengambil data dari controller
        const completionLabels = {!! json_encode($completionLabels) !!};
        const completionData = {!! json_encode($completionData) !!};
        const statusLabels = {!! json_encode($statusLabels) !!};
        const statusData = {!! json_encode($statusData) !!};
        const userLabels = {!! json_encode($userLabels) !!};
        const userData = {!! json_encode($userData) !!};

        // Warna teks grafik dengan tema UNIMUS
        Chart.defaults.color = '#1f2937';
        Chart.defaults.borderColor = 'rgba(14, 165, 233, 0.2)';

        // Grafik 1: Tugas Selesai per Hari (Line Chart)
        const ctx1 = document.getElementById('tasksCompletedChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: completionLabels,
                datasets: [{
                    label: 'Tugas Selesai',
                    data: completionData,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            color: '#374151'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#374151'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#1f2937'
                        }
                    }
                }
            }
        });

        // Grafik 2: Distribusi Status Tugas (Doughnut Chart)
        const ctx2 = document.getElementById('taskStatusChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)', // Pending (UNIMUS Gold)
                        'rgba(14, 165, 233, 0.8)',  // In Progress (UNIMUS Blue)
                        'rgba(34, 197, 94, 0.8)'   // Completed (UNIMUS Green)
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 3
                }]
            },
            options: { 
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#1f2937'
                        }
                    }
                }
            }
        });

        // Grafik 3: Kinerja Pengguna (Bar Chart)
        const ctx3 = document.getElementById('userPerformanceChart').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'Jumlah Tugas Selesai',
                    data: userData,
                    backgroundColor: 'rgba(14, 165, 233, 0.6)',
                    borderColor: 'rgba(14, 165, 233, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            color: '#374151'
                        }
                    },
                     x: {
                        ticks: {
                            color: '#374151'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#1f2937'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
