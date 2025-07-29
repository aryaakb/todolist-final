@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa')
@section('header', 'Manajemen Mahasiswa')

@section('content')

{{-- Menampilkan pesan sukses atau error --}}
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
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Daftar Mahasiswa Terdaftar</h2>
            <x-button 
                variant="secondary" 
                size="md" 
                icon="fas fa-wand-magic-sparkles"
                data-loading="Membuat ringkasan..."
                class="w-full sm:w-auto"
            >
                Buat Ringkasan AI
            </x-button>
        </div>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email Akademik</th>
                    <th>Status Pengguna</th>
                    <th style="width: 250px;">Ubah Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td><span class="user-name-display font-medium">{{ $user->name }}</span></td>
                        <td><span class="user-email-display">{{ $user->email }}</span></td>
                        <td>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-green-100 text-green-800 border border-green-200' }}">
                                <i class="fas {{ $user->isAdmin() ? 'fa-user-tie' : 'fa-user-graduate' }} mr-1"></i>
                                {{ $user->isAdmin() ? 'Dosen/Admin' : 'Mahasiswa' }}
                            </span>
                        </td>
                        <td>
                            @if (auth()->user()->id !== $user->id)
                                <form action="{{ route('team.updateRole', $user->id) }}" method="POST" class="role-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role_id" class="form-select">
                                        <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Dosen/Admin</option>
                                        <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Mahasiswa</option>
                                    </select>
                                    <x-button 
                                        type="submit" 
                                        variant="success" 
                                        size="sm"
                                        data-loading="Menyimpan..."
                                    >
                                        Simpan
                                    </x-button>
                                </form>
                            @else
                                <span class="self-note">Anda tidak bisa mengubah status sendiri.</span>
                            @endif
                        </td>
                        <td>
                            @if (auth()->user()->id !== $user->id)
                                <form action="{{ route('team.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $user->isAdmin() ? 'dosen/admin' : 'mahasiswa' }} ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button 
                                        type="submit" 
                                        variant="danger" 
                                        size="sm"
                                        icon="fas fa-user-minus"
                                        data-loading="Menghapus..."
                                        class="table-action-btn"
                                    >
                                        Hapus {{ $user->isAdmin() ? 'Dosen' : 'Mahasiswa' }}
                                    </x-button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            <div class="flex flex-col items-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 font-medium">Belum ada pengguna terdaftar</p>
                                <p class="text-gray-400 text-sm mt-1">Daftar mahasiswa dan dosen akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 20px;">
        {{ $users->links() }}
    </div>
</div>

<style>
    /* FIXED: Gaya untuk efek kaca dengan readability yang lebih baik */
    .content-section {
        background: rgba(255, 255, 255, 0.95); /* Background lebih solid untuk readability */
        backdrop-filter: blur(10px); /* Efek blur sedikit dikurangi */
        -webkit-backdrop-filter: blur(10px); /* Dukungan untuk Safari */
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3); /* Border lebih terlihat */
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1); /* Bayangan lebih soft */
        overflow: hidden;
    }

    .section-header {
        padding: 20px 30px;
        background: linear-gradient(135deg, #0ea5e9 0%, #0891b2 100%);
        color: white;
        /* Header dengan tema UNIMUS */
    }
    .section-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .table-container {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        padding: 15px 20px;
        text-align: left;
        /* FIXED: Border yang lebih terlihat */
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        vertical-align: middle;
        color: #1f2937; /* Warna teks gelap untuk kontras yang baik */
    }
    table th {
        /* FIXED: Background header yang lebih solid */
        background: rgba(14, 165, 233, 0.1);
        font-weight: 600;
        font-size: 14px;
        color: #0369a1; /* Warna header sesuai tema UNIMUS */
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    table tr:hover td {
        background: rgba(14, 165, 233, 0.05); /* Efek hover dengan warna UNIMUS */
    }
    table tr:last-child td {
        border-bottom: none;
    }

    /* Gaya lain tetap sama untuk fungsionalitas */
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-badge.admin {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    .status-badge.mahasiswa {
        background: #cce5ff;
        color: #004085;
        border: 1px solid #b3d7ff;
    }
    .role-form { display: flex; gap: 10px; align-items: center; }
    .role-form select { 
        padding: 8px; 
        border: 1px solid #ddd; 
        border-radius: 6px; 
        background-color: #f8f9fa;
    }
    .save-btn, .delete-btn, .ai-summary-btn {
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .save-btn {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
    }
    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    .delete-btn {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    .delete-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    .ai-summary-btn {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }
    .ai-summary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
    }
    .self-note { font-style: italic; color: #adb5bd; font-size: 12px; }
    .success-alert { padding: 15px; margin-bottom: 20px; border-radius: 8px; color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
    .error-alert { padding: 15px; margin-bottom: 20px; border-radius: 8px; color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }

</style>

@endsection
