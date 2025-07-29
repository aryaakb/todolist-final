@extends('layouts.app')

@section('title', 'Detail Tugas')
@section('header', 'Detail Tugas')

@section('content')
<div class="container mx-auto">
    <!-- Header Card -->
    <x-card class="mb-6" glassmorphism="true" shadow="lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold bg-gradient-unimus bg-clip-text text-transparent mb-2">
                    <i class="fas fa-eye mr-3 text-unimus-primary"></i>Detail Tugas
                </h2>
                <p class="text-gray-600">
                    Informasi lengkap tugas: <span class="font-semibold text-unimus-primary">{{ $task->title }}</span>
                </p>
            </div>
            <x-button 
                href="{{ route('tasks.index') }}" 
                variant="outline" 
                icon="fas fa-arrow-left"
                class="w-full md:w-auto"
            >
                Kembali ke Daftar
            </x-button>
        </div>
    </x-card>

    <!-- Main Details Card -->
    <x-card title="Informasi Tugas" glassmorphism="true" shadow="xl" class="max-w-4xl mx-auto mb-6">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="bg-gradient-unimus p-3 rounded-lg mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Detail lengkap informasi tugas</p>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flag mr-2 text-gray-400"></i>Status Tugas
                    </label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    ">
                        @if($task->status === 'pending')
                            📋 Pending - Belum Dimulai
                        @elseif($task->status === 'in_progress')
                            ⚡ In Progress - Sedang Dikerjakan
                        @else
                            ✅ Completed - Selesai
                        @endif
                    </span>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-gray-400"></i>Ditugaskan Kepada
                    </label>
                    <p class="text-gray-900 font-medium">{{ $task->assignedTo->name ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie mr-2 text-gray-400"></i>Dibuat Oleh
                    </label>
                    <p class="text-gray-900 font-medium">{{ $task->createdBy->name ?? 'System' }}</p>
                </div>

                @if($task->course)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book mr-2 text-gray-400"></i>Mata Kuliah
                    </label>
                    <p class="text-gray-900 font-medium">{{ $task->course }}</p>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Deadline
                    </label>
                    <p class="text-gray-900 font-medium">
                        @if($task->due_date)
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y, H:i') }}
                        @else
                            <em class="text-gray-500">Tidak ditentukan</em>
                        @endif
                    </p>
                </div>

                @if($task->priority)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-exclamation-circle mr-2 text-gray-400"></i>Prioritas
                    </label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $task->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        @if($task->priority === 'low')
                            🟢 Rendah - Tidak Mendesak
                        @elseif($task->priority === 'medium')
                            🟡 Sedang - Cukup Penting
                        @else
                            🔴 Tinggi - Sangat Penting
                        @endif
                    </span>
                </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>Dibuat Pada
                    </label>
                    <p class="text-gray-900 font-medium">{{ $task->created_at->format('d M Y, H:i') }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-edit mr-2 text-gray-400"></i>Diperbarui Pada
                    </label>
                    <p class="text-gray-900 font-medium">{{ $task->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-align-left mr-2 text-gray-400"></i>Deskripsi Tugas
            </label>
            <div class="bg-gray-50 p-4 rounded-lg min-h-[100px]">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $task->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>
    </x-card>

    @if($task->submission_file_path)
    <!-- Submission Details Card -->
    <x-card title="Detail Pengumpulan" glassmorphism="true" shadow="lg" class="max-w-4xl mx-auto mb-6">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg mr-4">
                    <i class="fas fa-upload text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Detail Pengumpulan</h3>
                    <p class="text-sm text-gray-600 mt-1">Informasi file yang telah dikumpulkan</p>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <label class="block text-sm font-medium text-green-700 mb-2">
                    <i class="fas fa-calendar-check mr-2"></i>Dikumpulkan Pada
                </label>
                <p class="text-green-900 font-medium">
                    @if($task->submitted_at)
                        {{ \Carbon\Carbon::parse($task->submitted_at)->format('d M Y, H:i') }}
                    @else
                        <em>Tidak tercatat</em>
                    @endif
                </p>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <label class="block text-sm font-medium text-blue-700 mb-2">
                    <i class="fas fa-file mr-2"></i>File Bukti
                </label>
                <x-button 
                    href="{{ route('tasks.download', $task) }}" 
                    variant="primary" 
                    size="sm"
                    icon="fas fa-download"
                    class="w-full"
                >
                    Unduh File
                </x-button>
            </div>
        </div>
    </x-card>
    @endif

    <!-- Action Buttons Card -->
    <x-card glassmorphism="true" shadow="lg" class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(auth()->user()->isAdmin())
                <x-button 
                    href="{{ route('tasks.edit', $task->id) }}" 
                    variant="primary" 
                    size="lg"
                    icon="fas fa-edit"
                    class="flex-1 sm:flex-none"
                >
                    Edit Tugas
                </x-button>
                
                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="flex-1 sm:flex-none">
                    @csrf
                    @method('DELETE')
                    <x-button 
                        type="submit" 
                        variant="danger" 
                        size="lg"
                        icon="fas fa-trash"
                        class="w-full"
                        onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                    >
                        Hapus Tugas
                    </x-button>
                </form>
                
            @elseif($task->status !== 'completed' && $task->assignedTo && $task->assignedTo->id === auth()->id())
                <x-button 
                    href="{{ route('tasks.edit', $task->id) }}" 
                    variant="success" 
                    size="lg"
                    icon="fas fa-upload"
                    class="flex-1 sm:flex-none"
                >
                    Kumpulkan Tugas
                </x-button>
            @endif
        </div>
    </x-card>
</div>
@endsection