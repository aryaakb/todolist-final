@extends('layouts.app')

@section('header', 'Pengumpulan Tugas')
@section('title', 'Pengumpulan Tugas')

@section('content')

{{-- Bagian untuk menampilkan pesan sukses atau error --}}
@if (session('success'))
    <div class="success-alert" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="error-alert" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="content-section">
    <div class="section-header">
        <h2>Daftar Pengumpulan Tugas</h2>
        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}" class="add-task-btn">
                <i class="fas fa-plus mr-2"></i> Buat Tugas Baru
            </a>
        @endcan
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>{{ Auth::user()->isAdmin() ? 'Tugas & Mata Kuliah' : 'Tugas & Mata Kuliah' }}</th>
                    <th>{{ Auth::user()->isAdmin() ? 'Mahasiswa' : 'Dosen Pemberi' }}</th>
                    <th>Status Pengumpulan</th>
                    <th class="text-center">File Tugas</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td data-label="Tugas & Mata Kuliah">
                            <div class="font-semibold task-title">{{ $task->title }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-800">
                                    <i class="fas fa-book-open mr-1"></i>
                                    {{ $task->course ?? 'Mata Kuliah Umum' }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                </span>
                            </div>
                        </td>
                        <td data-label="{{ Auth::user()->isAdmin() ? 'Ditugaskan Kepada' : 'Dosen Pemberi' }}">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignedTo->name ?? 'N') }}&background=E0F2FE&color=0891B2&size=32&font-size=0.4&bold=true" alt="{{ $task->assignedTo->name ?? 'N/A' }}" class="rounded-full">
                                <div>
                                    <div class="font-medium user-name-text">{{ $task->assignedTo->name ?? 'Belum Ditugaskan' }}</div>
                                    <div class="text-xs user-role-text">{{ Auth::user()->isAdmin() ? 'Mahasiswa' : 'Dosen' }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Status">
                            @php
                                $statusMap = [
                                    'pending' => ['Belum Dikumpulkan', 'bg-red-100 text-red-800 border-red-200', 'fas fa-clock'],
                                    'in_progress' => ['Sedang Dikerjakan', 'bg-yellow-100 text-yellow-800 border-yellow-200', 'fas fa-spinner'],
                                    'completed' => ['Sudah Dikumpulkan', 'bg-green-100 text-green-800 border-green-200', 'fas fa-check-circle'],
                                    'submitted' => ['Telah Dikirim', 'bg-blue-100 text-blue-800 border-blue-200', 'fas fa-paper-plane'],
                                ];
                                $status = $statusMap[$task->status] ?? ['Status Unknown', 'bg-gray-100 text-gray-800 border-gray-200', 'fas fa-question'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $status[1] }}">
                                <i class="{{ $status[2] }} mr-1"></i>
                                {{ $status[0] }}
                            </span>
                        </td>
                        <td data-label="File Bukti" class="text-center">
                            @if($task->submission_file_path)
                                <div class="flex flex-col items-center gap-1">
                                    <a href="{{ route('tasks.download', $task) }}" title="Download File Tugas" class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-file-download text-xl"></i>
                                    </a>
                                    <span class="text-xs text-green-600 font-medium">Tersedia</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-1">
                                    <i class="fas fa-file-upload text-xl text-gray-300" title="Belum Ada File"></i>
                                    <span class="text-xs text-gray-400">Belum Upload</span>
                                </div>
                            @endif
                        </td>
                        <td data-label="Aksi" class="text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('tasks.show', $task->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 border border-blue-200 rounded-md hover:bg-blue-200 transition-colors" title="{{ Auth::user()->isAdmin() ? 'Lihat Detail & Submission' : 'Lihat Soal Tugas' }}">
                                    <i class="fas fa-eye mr-1"></i>
                                    Detail
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 border border-green-200 rounded-md hover:bg-green-200 transition-colors" title="Edit Tugas">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    @can('delete', $task)
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus tugas ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 border border-red-200 rounded-md hover:bg-red-200 transition-colors" title="Hapus Tugas">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                    @endcan
                                @else
                                    @if($task->status !== 'completed')
                                        <a href="{{ route('tasks.submit', $task->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-orange-700 bg-orange-100 border border-orange-200 rounded-md hover:bg-orange-200 transition-colors" title="Kumpulkan Tugas">
                                            <i class="fas fa-upload mr-1"></i>
                                            Kumpulkan
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                     <tr>
                        <td colspan="5" class="text-center py-8">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-clipboard-list text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 font-medium">{{ Auth::user()->isAdmin() ? 'Belum ada tugas yang dibuat' : 'Tidak ada tugas yang diterima' }}</p>
                                <p class="text-gray-400 text-sm mt-1">{{ Auth::user()->isAdmin() ? 'Buat tugas baru untuk mahasiswa Anda' : 'Tugas dari dosen akan muncul di sini' }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $tasks->links() }}
    </div>
</div>

<style>
    .content-section {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 0.5rem;
    }
    
    @media (min-width: 640px) {
        .content-section {
            margin: 1rem;
        }
    }
    
    @media (min-width: 1024px) {
        .content-section {
            margin: 1.5rem 2rem;
        }
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: linear-gradient(135deg, #0ea5e9 0%, #0891b2 100%);
        color: white;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    @media (min-width: 640px) {
        .section-header {
            padding: 20px 30px;
            flex-wrap: nowrap;
        }
    }
    .section-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    @media (min-width: 640px) {
        .section-header h2 {
            font-size: 1.5rem;
        }
    }
    .add-task-btn {
        background: rgba(255, 255, 255, 0.2);
        padding: 10px 18px;
        border-radius: 8px;
        color: white !important;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .add-task-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    .table-container {
        overflow-x: auto;
    }
    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }
    .table-container th,
    .table-container td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    .table-container th {
        background: #f8f9fa;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .table-container tbody tr:hover {
        background: #f8f9fa;
    }
    .success-alert {
        background: #d1fae5;
        color: #065f46;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #a7f3d0;
    }
    .error-alert {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #fca5a5;
    }

    /* Dark Mode Optimizations */
    body.dark-mode .task-title {
        color: #f1f5f9 !important;
    }

    body.dark-mode .user-name-text {
        color: #e2e8f0 !important;
    }

    body.dark-mode .user-role-text {
        color: #94a3b8 !important;
    }

    body.dark-mode .bg-sky-100 {
        background: rgba(14, 165, 233, 0.2) !important;
    }

    body.dark-mode .text-sky-800 {
        color: #38bdf8 !important;
    }

    body.dark-mode .bg-red-100 {
        background: rgba(239, 68, 68, 0.2) !important;
    }

    body.dark-mode .text-red-700 {
        color: #f87171 !important;
    }

    body.dark-mode .border-red-200 {
        border-color: rgba(239, 68, 68, 0.3) !important;
    }

    body.dark-mode .bg-green-100 {
        background: rgba(34, 197, 94, 0.2) !important;
    }

    body.dark-mode .text-green-700 {
        color: #4ade80 !important;
    }

    body.dark-mode .border-green-200 {
        border-color: rgba(34, 197, 94, 0.3) !important;
    }

    body.dark-mode .bg-blue-100 {
        background: rgba(59, 130, 246, 0.2) !important;
    }

    body.dark-mode .text-blue-700 {
        color: #60a5fa !important;
    }

    body.dark-mode .border-blue-200 {
        border-color: rgba(59, 130, 246, 0.3) !important;
    }

    body.dark-mode .bg-orange-100 {
        background: rgba(251, 146, 60, 0.2) !important;
    }

    body.dark-mode .text-orange-700 {
        color: #fb923c !important;
    }

    body.dark-mode .border-orange-200 {
        border-color: rgba(251, 146, 60, 0.3) !important;
    }

    body.dark-mode .bg-yellow-100 {
        background: rgba(251, 191, 36, 0.2) !important;
    }

    body.dark-mode .text-yellow-800 {
        color: #fbbf24 !important;
    }

    body.dark-mode .border-yellow-200 {
        border-color: rgba(251, 191, 36, 0.3) !important;
    }

    body.dark-mode .text-green-600 {
        color: #4ade80 !important;
    }

    body.dark-mode .text-gray-400 {
        color: #9ca3af !important;
    }

    body.dark-mode .text-gray-600 {
        color: #94a3b8 !important;
    }

    /* Ensure light mode text remains readable */
    body:not(.dark-mode) .task-title {
        color: #1f2937 !important;
    }

    body:not(.dark-mode) .user-name-text {
        color: #1f2937 !important;
    }

    body:not(.dark-mode) .user-role-text {
        color: #6b7280 !important;
    }

    body:not(.dark-mode) .text-gray-400 {
        color: #9ca3af !important;
    }

    body:not(.dark-mode) .text-gray-600 {
        color: #4b5563 !important;
    }
</style>
@endsection