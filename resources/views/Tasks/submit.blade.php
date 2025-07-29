@extends('layouts.app')

@section('title', 'Kumpulkan Tugas')
@section('header', 'Kumpulkan Tugas')

@section('content')
<div class="content-section responsive-card">
    <div class="section-header">
        <h2>{{ $task->title }}</h2>
        <a href="{{ route('tasks.index') }}" class="view-all" style="text-decoration: none;">Kembali</a>
    </div>
    <div style="padding: 20px;">
        {{-- Detail Tugas (Read-only) --}}
        <div class="task-details">
            <p><strong>Ditugaskan oleh:</strong> <span class="task-creator">{{ $task->createdBy->name ?? 'N/A' }}</span></p>
            <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($task->due_date)->isoFormat('D MMMM YYYY') }}</p>
            <div class="description">
                <strong>Deskripsi:</strong>
                <p>{{ $task->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <hr class="my-6">

        {{-- Form Pengumpulan --}}
        <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="submission_file">Upload Bukti Pengumpulan</label>
                <input type="file" id="submission_file" name="submission_file" required>
                <p class="field-hint">Format yang didukung: PDF, JPG, PNG, ZIP (Maks: 10MB)</p>
                @error('submission_file')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Kumpulkan Tugas</button>
        </form>
    </div>
</div>

<style>
    .task-details { margin-bottom: 20px; }
    .task-details p { margin-bottom: 5px; }
    .task-details .description { margin-top: 15px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
    .form-group input[type="file"] {
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        width: 100%;
        font-weight: 500;
    }
    
    .form-group input[type="file"]:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }
    .field-hint { font-size: 12px; color: #6c757d; margin-top: 5px; }
    .submit-btn {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }
    .submit-btn:hover { 
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
    }
    .error-message { color: #dc3545; font-size: 12px; margin-top: 5px; }

    /* Dark Mode Support */
    body.dark-mode .task-creator {
        color: #e2e8f0 !important;
        font-weight: 500;
    }

    body.dark-mode .task-details p,
    body.dark-mode .task-details strong {
        color: #e2e8f0 !important;
    }

    body.dark-mode .form-group label {
        color: #e2e8f0 !important;
    }

    body.dark-mode .form-group input[type="file"] {
        background: rgba(55, 65, 81, 0.9) !important;
        border: 2px solid rgba(75, 85, 99, 0.5) !important;
        color: #ffffff !important;
    }

    body.dark-mode .form-group input[type="file"]:focus {
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
        background: rgba(55, 65, 81, 0.95) !important;
        color: #ffffff !important;
    }

    body.dark-mode .field-hint {
        color: #94a3b8 !important;
    }
    
    /* Responsive Card Layout */
    .responsive-card {
        margin: 0.5rem;
        border-radius: 8px;
    }
    
    @media (min-width: 640px) {
        .responsive-card {
            margin: 1rem;
            border-radius: 10px;
        }
    }
    
    @media (min-width: 1024px) {
        .responsive-card {
            margin: 1.5rem 2rem;
        }
    }
    
    .section-header {
        padding: 15px 20px !important;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    @media (min-width: 640px) {
        .section-header {
            padding: 20px 30px !important;
            flex-wrap: nowrap;
        }
    }
    
    .section-header h2 {
        font-size: 1.25rem !important;
        margin: 0;
    }
    
    @media (min-width: 640px) {
        .section-header h2 {
            font-size: 1.5rem !important;
        }
    }
</style>
@endsection
