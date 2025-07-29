@extends('layouts.app')

@section('title', 'Tambah Tugas Baru')
@section('header', 'Tambah Tugas Baru')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Card -->
    <x-card class="mb-6" glassmorphism="true" shadow="lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold bg-gradient-unimus bg-clip-text text-transparent mb-2">
                    <i class="fas fa-plus-circle mr-3 text-unimus-primary"></i>Buat Tugas Baru
                </h2>
                <p class="text-gray-600">Buat tugas baru untuk mahasiswa dengan detail yang jelas dan deadline yang tepat</p>
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

    <!-- Form Card -->
    <x-card title="Formulir Tugas" glassmorphism="true" shadow="xl" class="w-full max-w-4xl mx-auto">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="bg-gradient-unimus p-3 rounded-lg mr-4">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Detail Tugas</h3>
                    <p class="text-sm text-gray-600 mt-1">Isi informasi tugas dengan lengkap</p>
                </div>
            </div>
        </x-slot>

        <form action="{{ route('tasks.store') }}" method="POST" data-validate-form class="space-y-6">
            @csrf
            
            <!-- Progress Indicator -->
            <div class="bg-gradient-to-r from-blue-50 to-sky-50 p-4 rounded-xl border border-blue-100">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-blue-700 font-medium">
                        <i class="fas fa-info-circle mr-2"></i>Formulir Pembuatan Tugas
                    </span>
                    <span class="text-blue-600">Langkah 1 dari 1</span>
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
                        required
                        data-validate="required|min:5|max:100"
                        help="Masukkan judul tugas yang jelas dan deskriptif (5-100 karakter)"
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
                                placeholder="Jelaskan detail tugas, instruksi pengerjaan, kriteria penilaian, dan hal-hal penting lainnya..."
                                data-validate="required|min:20"
                            >{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Minimal 20 karakter. Semakin detail, semakin baik untuk mahasiswa.
                        </p>
                    </div>

                    <x-form-select
                        name="assigned_to"
                        label="Ditugaskan Kepada"
                        :options="$users->pluck('name', 'id')->toArray()"
                        placeholder="Pilih mahasiswa yang akan mengerjakan tugas"
                        required
                        help="Pilih satu mahasiswa yang akan bertanggung jawab atas tugas ini"
                    />
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <x-form-input
                        name="due_date"
                        label="Tanggal & Waktu Deadline"
                        type="datetime-local"
                        icon="fas fa-calendar-alt"
                        required
                        data-validate="required"
                        help="Tentukan kapan tugas harus dikumpulkan"
                    />

                    <x-form-select
                        name="status"
                        label="Status Awal"
                        :options="[
                            'pending' => '📋 Pending - Belum Dimulai',
                            'in_progress' => '⚡ In Progress - Sedang Dikerjakan', 
                            'completed' => '✅ Completed - Selesai'
                        ]"
                        selected="pending"
                        required
                        help="Status awal tugas (biasanya Pending untuk tugas baru)"
                    />

                    <!-- Additional Course Field -->
                    <x-form-input
                        name="course"
                        label="Mata Kuliah"
                        type="text"
                        icon="fas fa-book"
                        placeholder="Contoh: Pemrograman Web, Basis Data, dll"
                        data-validate="required|alpha:spaces"
                        help="Nama mata kuliah tempat tugas ini diberikan"
                    />

                    <!-- Priority Level -->
                    <x-form-select
                        name="priority"
                        label="Tingkat Prioritas"
                        :options="[
                            'low' => '🟢 Rendah - Tidak Mendesak',
                            'medium' => '🟡 Sedang - Cukup Penting',
                            'high' => '🔴 Tinggi - Sangat Penting'
                        ]"
                        selected="medium"
                        help="Seberapa penting dan mendesak tugas ini"
                    />
                </div>
            </div>

            <!-- Additional Instructions Card -->
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 rounded-xl border border-amber-200">
                <h4 class="flex items-center text-amber-800 font-semibold mb-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Tips Membuat Tugas yang Efektif
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-amber-700">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-0.5 text-amber-600"></i>
                        <span>Judul yang jelas dan deskriptif</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-0.5 text-amber-600"></i>
                        <span>Deadline yang realistis dan achievable</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-0.5 text-amber-600"></i>
                        <span>Deskripsi yang detail dan mudah dipahami</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-0.5 text-amber-600"></i>
                        <span>Kriteria penilaian yang jelas</span>
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
                    class="flex-1 sm:flex-none sm:px-8"
                    id="submit-btn"
                >
                    Simpan Tugas
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
                    href="{{ route('tasks.index') }}" 
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


<!-- Preview Modal -->
<div id="task-preview-modal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-modal">
    <div class="modal-content max-w-2xl mx-auto mt-10">
        <x-card title="Preview Tugas" class="bg-white">
            <x-slot name="title">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Preview Tugas</h3>
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

// Prevent double submit
document.querySelector('form[data-validate-form]').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submit-btn');
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Menyimpan...';
    
    // Re-enable after 10 seconds as fallback
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Tugas';
    }, 10000);
});
</script>

<style>
/* Task Form Dark Mode Optimizations - BRIGHT WHITE TEXT */
body.dark-mode .task-form-textarea,
body.dark-mode textarea#description,
body.dark-mode form textarea {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode .task-form-textarea:focus,
body.dark-mode textarea#description:focus,
body.dark-mode form textarea:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode .task-form-textarea::placeholder,
body.dark-mode textarea#description::placeholder,
body.dark-mode form textarea::placeholder {
    color: #9ca3af !important;
    opacity: 0.7 !important;
}

/* All Form Elements Dark Mode */
body.dark-mode input,
body.dark-mode select,
body.dark-mode .form-group input,
body.dark-mode .form-group select,
body.dark-mode form input,
body.dark-mode form select {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode input:focus,
body.dark-mode select:focus,
body.dark-mode .form-group input:focus,
body.dark-mode .form-group select:focus,
body.dark-mode form input:focus,
body.dark-mode form select:focus {
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
}

body.dark-mode select option,
body.dark-mode .form-group select option,
body.dark-mode form select option {
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
}

body.dark-mode input::placeholder,
body.dark-mode .form-group input::placeholder,
body.dark-mode form input::placeholder {
    color: #9ca3af !important;
    opacity: 0.7 !important;
}

/* Form Labels and Text */
body.dark-mode .text-gray-500,
body.dark-mode .text-gray-600,
body.dark-mode .text-gray-700,
body.dark-mode .text-gray-900 {
    color: #e2e8f0 !important;
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

/* Gradient Cards Dark Mode */
body.dark-mode .bg-gradient-to-r.from-blue-50 {
    background: linear-gradient(to right, rgba(30, 41, 59, 0.8), rgba(55, 65, 81, 0.8)) !important;
    border-color: rgba(75, 85, 99, 0.5) !important;
}

body.dark-mode .text-blue-700 {
    color: #60a5fa !important;
}

body.dark-mode .text-blue-600 {
    color: #3b82f6 !important;
}

body.dark-mode .bg-gradient-to-r.from-amber-50 {
    background: linear-gradient(to right, rgba(45, 55, 72, 0.8), rgba(55, 65, 81, 0.8)) !important;
    border-color: rgba(75, 85, 99, 0.5) !important;
}

body.dark-mode .text-amber-800 {
    color: #fbbf24 !important;
}

body.dark-mode .text-amber-700 {
    color: #f59e0b !important;
}

body.dark-mode .text-amber-600 {
    color: #d97706 !important;
}

/* Light Mode Protection */
body:not(.dark-mode) .task-form-textarea {
    background: white !important;
    border: 1px solid #d1d5db !important;
    color: #1f2937 !important;
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
}

@media (min-width: 641px) and (max-width: 1023px) {
    .grid.grid-cols-1.lg\\:grid-cols-2 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        gap: 1.5rem !important;
    }
}
</style>
@endsection
