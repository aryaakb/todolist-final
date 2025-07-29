@extends('layouts.app')

@section('title', 'Edit Tugas')
@section('header', 'Edit Tugas')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Card -->
    <x-card class="mb-6" glassmorphism="true" shadow="lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold bg-gradient-unimus bg-clip-text text-transparent mb-2">
                    <i class="fas fa-edit mr-3 text-unimus-primary"></i>Edit Tugas
                </h2>
                <p class="text-gray-600">
                    Perbarui informasi tugas: <span class="font-semibold text-unimus-primary">{{ $task->title }}</span>
                </p>
            </div>
            <div class="flex gap-2">
                <x-button 
                    href="{{ route('tasks.show', $task->id) }}" 
                    variant="ghost" 
                    icon="fas fa-eye"
                    class="w-full md:w-auto"
                >
                    Lihat Detail
                </x-button>
                <x-button 
                    href="{{ route('tasks.index') }}" 
                    variant="outline" 
                    icon="fas fa-arrow-left"
                    class="w-full md:w-auto"
                >
                    Kembali
                </x-button>
            </div>
        </div>
    </x-card>

    <!-- Form Card -->
    <x-card title="Edit Tugas" glassmorphism="true" shadow="xl" class="w-full max-w-4xl mx-auto">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="bg-gradient-unimus p-3 rounded-lg mr-4">
                    <i class="fas fa-pencil-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Perbarui Detail Tugas</h3>
                    <p class="text-sm text-gray-600 mt-1">Ubah informasi tugas sesuai kebutuhan</p>
                </div>
            </div>
        </x-slot>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" data-validate-form class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Status Info Card -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-100">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-green-700 font-medium">
                        <i class="fas fa-info-circle mr-2"></i>Status Tugas Saat Ini
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <x-form-input
                        name="title"
                        label="Judul Tugas"
                        type="text"
                        icon="fas fa-heading"
                        placeholder="Contoh: Tugas Pemrograman Web Minggu 3"
                        :value="$task->title"
                        required
                        data-validate="required|min:5|max:100"
                        help="Judul tugas yang jelas dan deskriptif (5-100 karakter)"
                    />

                    <div class="form-group">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Tugas
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 text-gray-400 pointer-events-none z-10">
                                <i class="fas fa-align-left text-sm"></i>
                            </div>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                class="task-form-textarea w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-unimus-primary focus:border-unimus-primary resize-vertical"
                                placeholder="Jelaskan detail tugas, instruksi pengerjaan, kriteria penilaian..."
                                data-validate="required|min:20"
                            >{{ old('description', $task->description) }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <x-form-select
                        name="assigned_to"
                        label="Ditugaskan Kepada"
                        :options="$users->pluck('name', 'id')->toArray()"
                        :selected="$task->assigned_to"
                        placeholder="Pilih mahasiswa yang akan mengerjakan tugas"
                        required
                        help="Pilih mahasiswa yang bertanggung jawab atas tugas ini"
                    />
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <x-form-input
                        name="due_date"
                        label="Tanggal & Waktu Deadline"
                        type="datetime-local"
                        icon="fas fa-calendar-alt"
                        :value="$task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i') : ''"
                        required
                        data-validate="required"
                        help="Tentukan kapan tugas harus dikumpulkan"
                    />

                    <x-form-select
                        name="status"
                        label="Status Tugas"
                        :options="[
                            'pending' => '📋 Pending - Belum Dimulai',
                            'in_progress' => '⚡ In Progress - Sedang Dikerjakan', 
                            'completed' => '✅ Completed - Selesai'
                        ]"
                        :selected="$task->status"
                        required
                        help="Update status berdasarkan progress terkini"
                    />

                    <x-form-input
                        name="course"
                        label="Mata Kuliah"
                        type="text"
                        icon="fas fa-book"
                        placeholder="Contoh: Pemrograman Web, Basis Data"
                        :value="$task->course ?? ''"
                        data-validate="alpha:spaces"
                        help="Nama mata kuliah tempat tugas ini diberikan"
                    />

                    <x-form-select
                        name="priority"
                        label="Tingkat Prioritas"
                        :options="[
                            'low' => '🟢 Rendah - Tidak Mendesak',
                            'medium' => '🟡 Sedang - Cukup Penting',
                            'high' => '🔴 Tinggi - Sangat Penting'
                        ]"
                        :selected="$task->priority ?? 'medium'"
                        help="Seberapa penting dan mendesak tugas ini"
                    />
                </div>
            </div>

            <!-- Changes Log Card -->
            <div class="bg-gradient-to-r from-blue-50 to-sky-50 p-6 rounded-xl border border-blue-200">
                <h4 class="flex items-center text-blue-800 font-semibold mb-3">
                    <i class="fas fa-history mr-2"></i>
                    Informasi Perubahan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700">
                    <div>
                        <span class="font-medium block">Dibuat:</span>
                        <span>{{ $task->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium block">Terakhir diubah:</span>
                        <span>{{ $task->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium block">Dibuat oleh:</span>
                        <span>{{ $task->createdBy->name ?? 'System' }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <x-button 
                    type="submit" 
                    variant="primary" 
                    size="lg" 
                    icon="fas fa-save"
                    data-loading="Menyimpan perubahan..."
                    class="flex-1 sm:flex-none sm:px-8"
                >
                    Simpan Perubahan
                </x-button>
                
                <x-button 
                    type="button" 
                    variant="ghost" 
                    size="lg" 
                    icon="fas fa-eye"
                    onclick="previewTask()"
                    class="flex-1 sm:flex-none"
                >
                    Preview
                </x-button>
                
                <x-button 
                    href="{{ route('tasks.show', $task->id) }}" 
                    variant="outline" 
                    size="lg" 
                    icon="fas fa-times"
                    class="flex-1 sm:flex-none"
                >
                    Batal
                </x-button>
            </div>
        </form>
    </x-card>
</div>

<!-- Preview Modal (sama seperti di create) -->
<div id="task-preview-modal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-modal">
    <div class="modal-content max-w-2xl mx-auto mt-10">
        <x-card title="Preview Tugas" class="bg-white">
            <x-slot name="title">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Preview Perubahan Tugas</h3>
                    <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </x-slot>
            
            <div id="preview-content">
                <!-- Preview content will be populated by JavaScript -->
            </div>
        </x-card>
    </div>
</div>

<script>
function previewTask() {
    const form = document.querySelector('form[data-validate-form]');
    if (!form) {
        alert('Form tidak ditemukan!');
        return;
    }
    
    const formData = new FormData(form);
    
    // Debug: log semua form data
    console.log('Form data:', Object.fromEntries(formData));
    
    const preview = {
        title: formData.get('title') || 'Belum diisi',
        description: formData.get('description') || 'Belum diisi',
        assigned_to: form.querySelector('select[name="assigned_to"] option:checked')?.textContent || 'Belum dipilih',
        due_date: formData.get('due_date') || 'Belum diisi',
        status: form.querySelector('select[name="status"] option:checked')?.textContent || 'Pending',
        course: formData.get('course') || 'Belum diisi',
        priority: form.querySelector('select[name="priority"] option:checked')?.textContent || 'Sedang'
    };
    
    // Debug: log preview object
    console.log('Preview data:', preview);
    
    document.getElementById('preview-content').innerHTML = `
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                <span class="text-yellow-800 font-medium">Preview perubahan yang akan disimpan</span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Judul Tugas</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.title}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Mata Kuliah</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.course}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Ditugaskan Kepada</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.assigned_to}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Deadline</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.due_date}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Status</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.status}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Prioritas</h4>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${preview.priority}</p>
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                <div class="text-gray-900 bg-gray-50 p-4 rounded-lg min-h-[100px] whitespace-pre-wrap">${preview.description}</div>
            </div>
        </div>
    `;
    
    document.getElementById('task-preview-modal').classList.remove('hidden');
    document.getElementById('task-preview-modal').classList.add('flex');
}

function closePreview() {
    document.getElementById('task-preview-modal').classList.add('hidden');
    document.getElementById('task-preview-modal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('task-preview-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePreview();
    }
});
</script>

<style>
/* Task Form Dark Mode Optimizations - BRIGHT WHITE TEXT */
body.dark-mode textarea.task-form-textarea,
body.dark-mode textarea#description,
body.dark-mode form textarea,
body.dark-mode .task-form-textarea {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode textarea.task-form-textarea:focus,
body.dark-mode textarea#description:focus,
body.dark-mode form textarea:focus,
body.dark-mode .task-form-textarea:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode textarea.task-form-textarea::placeholder,
body.dark-mode textarea#description::placeholder,
body.dark-mode form textarea::placeholder,
body.dark-mode .task-form-textarea::placeholder {
    color: #9ca3af !important;
    opacity: 0.7 !important;
}

/* Select Dropdown Dark Mode - SUPER SPECIFIC */
body.dark-mode select,
body.dark-mode .form-group select,
body.dark-mode form select {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
}

body.dark-mode select option,
body.dark-mode .form-group select option,
body.dark-mode form select option {
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
}

body.dark-mode select option:hover,
body.dark-mode select option:focus,
body.dark-mode select option:checked,
body.dark-mode .form-group select option:hover,
body.dark-mode .form-group select option:focus,
body.dark-mode .form-group select option:checked {
    background: rgba(14, 165, 233, 0.8) !important;
    color: #ffffff !important;
}

/* Input Fields Dark Mode - SUPER SPECIFIC */
body.dark-mode input,
body.dark-mode .form-group input,
body.dark-mode form input {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode input:focus,
body.dark-mode .form-group input:focus,
body.dark-mode form input:focus {
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
}

body.dark-mode input::placeholder,
body.dark-mode .form-group input::placeholder,
body.dark-mode form input::placeholder {
    color: #9ca3af !important;
    opacity: 0.7 !important;
}

/* Preview Modal Dark Mode */
body.dark-mode #task-preview-modal .modal-content {
    background: rgba(30, 41, 59, 0.95) !important;
    backdrop-filter: blur(15px);
    border: 1px solid rgba(75, 85, 99, 0.5);
}

body.dark-mode #preview-content .bg-gray-50 {
    background: rgba(55, 65, 81, 0.5) !important;
}

body.dark-mode #preview-content h4 {
    color: #e2e8f0 !important;
}

body.dark-mode #preview-content p {
    color: #f1f5f9 !important;
}

/* Form Icon Dark Mode */
body.dark-mode .text-gray-400 {
    color: #9ca3af !important;
}

/* Header Text Dark Mode */
body.dark-mode .text-gray-600 {
    color: #94a3b8 !important;
}

body.dark-mode .text-gray-900 {
    color: #f1f5f9 !important;
}

/* Form Labels Dark Mode */
body.dark-mode .text-gray-700 {
    color: #e2e8f0 !important;
}

/* Gradient Cards Dark Mode */
body.dark-mode .bg-gradient-to-r.from-green-50 {
    background: linear-gradient(to right, rgba(30, 41, 59, 0.8), rgba(55, 65, 81, 0.8)) !important;
    border-color: rgba(75, 85, 99, 0.5) !important;
}

body.dark-mode .text-green-700 {
    color: #4ade80 !important;
}

body.dark-mode .text-green-800 {
    color: #22c55e !important;
}

body.dark-mode .bg-green-100 {
    background: rgba(34, 197, 94, 0.2) !important;
}

body.dark-mode .bg-gradient-to-r.from-blue-50 {
    background: linear-gradient(to right, rgba(30, 41, 59, 0.8), rgba(55, 65, 81, 0.8)) !important;
    border-color: rgba(75, 85, 99, 0.5) !important;
}

body.dark-mode .text-blue-700 {
    color: #60a5fa !important;
}

body.dark-mode .text-blue-800 {
    color: #3b82f6 !important;
}

/* Light Mode Protection */
body:not(.dark-mode) .task-form-textarea {
    background: white !important;
    border: 1px solid #d1d5db !important;
    color: #1f2937 !important;
}

body:not(.dark-mode) .task-form-textarea:focus {
    background: rgba(255, 255, 255, 0.95) !important;
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
}

body:not(.dark-mode) .task-form-textarea::placeholder {
    color: #9ca3af !important;
}

/* Mobile Responsive Cards */
@media (max-width: 640px) {
    .container {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    
    .grid.grid-cols-1.lg\\:grid-cols-2 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1rem !important;
    }
    
    .bg-gradient-to-r {
        padding: 1rem !important;
    }
    
    .flex.flex-col.sm\\:flex-row {
        flex-direction: column !important;
    }
    
    .flex.flex-col.sm\\:flex-row .flex-1 {
        width: 100% !important;
    }
    
    .grid.grid-cols-1.md\\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 0.75rem !important;
    }
}

@media (min-width: 641px) and (max-width: 1023px) {
    .grid.grid-cols-1.lg\\:grid-cols-2 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1.5rem !important;
    }
    
    .grid.grid-cols-1.md\\:grid-cols-3 {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 1rem !important;
    }
}
</style>
@endsection
