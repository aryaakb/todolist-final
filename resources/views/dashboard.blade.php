@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('styles')
{{-- Font dan library animasi --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        {{-- Header --}}
        <header class="header-container">
            <div class="header-greeting">
                <h1 class="greeting-text">
                    <span class="gradient-text">
                        @php
                            $hour = \Carbon\Carbon::now(new \DateTimeZone('Asia/Jakarta'))->hour;
                            $greeting = 'Malam';
                            if ($hour >= 4 && $hour < 11) { $greeting = 'Pagi'; }
                            elseif ($hour >= 11 && $hour < 15) { $greeting = 'Siang'; }
                            elseif ($hour >= 15 && $hour < 18) { $greeting = 'Sore'; }
                        @endphp
                        Selamat {{ $greeting }}, {{ Auth::user()->isAdmin() ? 'Bapak/Ibu Dosen' : 'Mahasiswa' }}
                    </span>
                    <span class="user-name">{{ Auth::user()->name ?? 'Pengguna' }}!</span>
                </h1>
            </div>
            <div class="header-actions">
                <div id="live-clock" class="live-clock"></div>

                {{-- Notifikasi --}}
                <div class="relative z-30" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open; markNotificationsAsRead()" class="notification-button">
                        <i class="fas fa-bell"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @else
                            <span class="notification-badge" style="display: none;">0</span>
                        @endif
                    </button>
                    <div x-show="open" x-cloak class="notification-dropdown">
                        <div class="dropdown-header">
                            <h4>Notifikasi</h4>
                        </div>
                        <div id="notification-list" class="dropdown-content">
                            @forelse(Auth::user()->notifications->take(10) as $notification)
                                <a href="#" class="notification-item">
                                    <p><b class="font-semibold">{{ $notification->data['sender_name'] ?? 'Sistem' }}</b> {{ $notification->data['message'] ?? 'telah mengirim notifikasi.' }}</p>
                                    <small class="text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            @empty
                                <div id="notification-empty-message" class="dropdown-empty">Tidak ada notifikasi.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Profile Dropdown --}}
                <!-- @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="profile-button">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=8b5cf6&color=FFFFFF' }}" alt="{{ Auth::user()->name }}">
                    </button>
                    <div x-show="open" x-cloak class="profile-dropdown">
                        <div class="dropdown-header">
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <small class="truncate">{{ Auth::user()->email }}</small>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profil</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item-logout">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth -->
            </div>
        </header>

        {{-- Stats Grid --}}
        <div class="stats-grid">
            <div class="stats-card" data-aos="fade-up">
                <div class="icon-wrapper bg-sky-100 text-sky-600"><i class="fas fa-clipboard-list"></i></div>
                <p class="stats-label">{{ Auth::user()->isAdmin() ? 'Total Tugas Diberikan' : 'Tugas Yang Diterima' }}</p>
                <p class="counter stats-value" data-target="{{ $totalTasks ?? 0 }}">0</p>
            </div>
            <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-wrapper bg-green-100 text-green-600"><i class="fas fa-user-graduate"></i></div>
                <p class="stats-label">{{ Auth::user()->isAdmin() ? 'Mahasiswa Terdaftar' : 'Dosen Mata Kuliah' }}</p>
                <p class="counter stats-value" data-target="{{ $activeUsers ?? 0 }}">0</p>
            </div>
            <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-wrapper bg-emerald-100 text-emerald-600"><i class="fas fa-check-double"></i></div>
                <p class="stats-label">{{ Auth::user()->isAdmin() ? 'Tugas Masuk Hari Ini' : 'Tugas Selesai Hari Ini' }}</p>
                <p class="counter stats-value" data-target="{{ $completedToday ?? 0 }}">0</p>
            </div>
            <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-wrapper bg-amber-100 text-amber-600"><i class="fas fa-exclamation-triangle"></i></div>
                <p class="stats-label">{{ Auth::user()->isAdmin() ? 'Tugas Berakhir Hari Ini' : 'Deadline Hari Ini' }}</p>
                <p class="counter stats-value" data-target="{{ $dueToday ?? 0 }}">0</p>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="main-content-grid">
            <div class="content-card tasks-card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header">
                    <h3>{{ Auth::user()->isAdmin() ? 'Tugas Yang Akan Berakhir' : 'Tugas Yang Harus Dikumpulkan' }}</h3>
                    <a href="{{ route('tasks.index') }}" class="btn-primary">{{ Auth::user()->isAdmin() ? 'Kelola Tugas' : 'Lihat Semua Tugas' }}</a>
                </div>
                <div class="table-wrapper">
                    <table id="tasksTable">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">{{ Auth::user()->isAdmin() ? 'Tugas & Mata Kuliah' : 'Tugas & Mata Kuliah' }} <span class="sort-icon"></span></th>
                                <th onclick="sortTable(1)">{{ Auth::user()->isAdmin() ? 'Ditugaskan Kepada' : 'Dosen Pemberi' }} <span class="sort-icon"></span></th>
                                <th onclick="sortTable(2)">Batas Pengumpulan <span class="sort-icon"></span></th>
                                <th onclick="sortTable(3)">{{ Auth::user()->isAdmin() ? 'Status Tugas' : 'Status Pengerjaan' }} <span class="sort-icon"></span></th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingDeadlines as $task)
                            <tr data-due-date="{{ $task->due_date }}" data-status="{{ $task->status }}">
                                <td data-label="{{ Auth::user()->isAdmin() ? 'Tugas & Mata Kuliah' : 'Tugas & Mata Kuliah' }}">
                                    <div class="font-semibold text-gray-800">{{ $task->title }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-book mr-1"></i>
                                            {{ $task->course ?? 'Sistem Informasi' }}
                                        </span>
                                    </div>
                                </td>
                                <td data-label="{{ Auth::user()->isAdmin() ? 'Ditugaskan Kepada' : 'Dosen Pemberi' }}">
                                    <div class="user-cell">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignedTo->name ?? 'N') }}&background=E0F2FE&color=0891B2&size=28&font-size=0.4&bold=true" alt="{{ $task->assignedTo->name ?? 'N/A' }}">
                                        <div>
                                            <span class="font-medium">{{ $task->assignedTo->name ?? 'N/A' }}</span>
                                            <div class="text-xs text-gray-500">
                                                {{ Auth::user()->isAdmin() ? 'Mahasiswa' : 'Dosen' }} • {{ $task->assignedTo->email ?? 'email@unimus.ac.id' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Batas Pengumpulan">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($task->due_date)->isoFormat('D MMM YYYY') }}</span>
                                        <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }})</span>
                                    </div>
                                </td>
                                <td data-label="{{ Auth::user()->isAdmin() ? 'Status Tugas' : 'Status Pengerjaan' }}">
                                    @php
                                        $statusMap = [
                                            'pending' => ['Belum Dikumpulkan', 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                                            'in_progress' => ['Sedang Dikerjakan', 'bg-blue-100 text-blue-800 border-blue-200'],
                                            'completed' => ['Sudah Dikumpulkan', 'bg-green-100 text-green-800 border-green-200'],
                                            'submitted' => ['Telah Dikirim', 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                                        ];
                                        $status = $statusMap[$task->status] ?? ['Status Unknown', 'bg-gray-100 text-gray-800 border-gray-200'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $status[1] }}">
                                        {{ $status[0] }}
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="{{ route('tasks.show', $task->id) }}" title="{{ Auth::user()->isAdmin() ? 'Lihat Detail Tugas' : 'Lihat & Kumpulkan' }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('tasks.edit', $task->id) }}" title="Edit Tugas" class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            @if($task->status !== 'completed')
                                                <a href="{{ route('tasks.submit', $task->id) }}" title="Kumpulkan Tugas" class="text-orange-600 hover:text-orange-800">
                                                    <i class="fas fa-upload"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="empty-cell">
                                    <div class="flex flex-col items-center py-8">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-clipboard-list text-2xl text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-600 font-medium">{{ Auth::user()->isAdmin() ? 'Belum ada tugas yang dibuat' : 'Tidak ada tugas yang perlu dikumpulkan' }}</p>
                                        <p class="text-gray-400 text-sm mt-1">{{ Auth::user()->isAdmin() ? 'Buat tugas baru untuk mahasiswa' : 'Semua tugas sudah selesai atau belum ada tugas baru' }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-card" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                    <h3>{{ Auth::user()->isAdmin() ? 'Pengumpulan Tugas Terbaru' : 'Aktivitas Tugas Saya' }}</h3>
                    <span class="text-xs text-gray-500">{{ Auth::user()->isAdmin() ? 'Tugas yang baru masuk' : 'Riwayat pengumpulan' }}</span>
                </div>
                <div class="activity-feed">
                    @forelse($recentActivities as $activity)
                    <div class="activity-item border-l-4 border-sky-400 pl-4 py-3">
                        <div class="flex items-start gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->assignedTo->name ?? 'S') }}&background=E0F2FE&color=0891B2&size=40&font-size=0.5" alt="{{ $activity->assignedTo->name ?? 'System' }}" class="rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-800">{{ $activity->assignedTo->name ?? 'Sistem' }}</span>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        {{ Auth::user()->isAdmin() ? 'Mahasiswa' : 'Saya' }}
                                    </span>
                                </div>
                                <p class="text-gray-600">
                                    {{ Auth::user()->isAdmin() ? 'mengumpulkan tugas' : 'berhasil mengumpulkan' }} 
                                    <span class="font-semibold text-blue-600">"{{ $activity->title }}"</span>
                                </p>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                    <span><i class="fas fa-clock mr-1"></i>{{ $activity->created_at->diffForHumans() }}</span>
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $activity->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            <div class="text-green-500">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-cell py-12">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-history text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600 font-medium">{{ Auth::user()->isAdmin() ? 'Belum ada pengumpulan tugas' : 'Belum ada aktivitas' }}</p>
                            <p class="text-gray-400 text-sm mt-1">{{ Auth::user()->isAdmin() ? 'Aktivitas pengumpulan akan muncul di sini' : 'Mulai kumpulkan tugas untuk melihat riwayat' }}</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* --- THEME ELEGANT: Variabel Desain Global --- */
:root {
    /* Light Mode Variables */
    --card-bg-light: rgba(255, 255, 255, 0.9);
    --text-primary-light: #1f2937;
    --text-secondary-light: #6b7280;
    --border-color-light: rgba(229, 231, 235, 0.8);
    
    /* Dark Mode Variables */
    --card-bg-dark: rgba(30, 41, 59, 0.8);
    --text-primary-dark: #f1f5f9;
    --text-secondary-dark: #94a3b8;
    --border-color-dark: rgba(75, 85, 99, 0.5);
    
    /* Universal */
    --primary-color: #0ea5e9;
    --primary-gradient: linear-gradient(90deg, #0ea5e9 0%, #0891b2 100%);

    /* Bayangan (Shadows) */
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);

    /* Dark Mode Shadows */
    --shadow-sm-dark: 0 1px 2px 0 rgb(0 0 0 / 0.3);
    --shadow-md-dark: 0 4px 6px -1px rgb(0 0 0 / 0.3), 0 2px 4px -2px rgb(0 0 0 / 0.2);
    --shadow-lg-dark: 0 10px 15px -3px rgb(0 0 0 / 0.4), 0 4px 6px -4px rgb(0 0 0 / 0.3);

    /* Transisi */
    --transition-ease: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Dynamic Variables Based on Theme - Only for dashboard page */
.dashboard-wrapper body.dark-mode,
body.dark-mode .dashboard-wrapper {
    --card-bg: var(--card-bg-dark);
    --text-primary: var(--text-primary-dark);
    --text-secondary: var(--text-secondary-dark);
    --border-color: var(--border-color-dark);
    --shadow-sm: var(--shadow-sm-dark);
    --shadow-md: var(--shadow-md-dark);
    --shadow-lg: var(--shadow-lg-dark);
}

.dashboard-wrapper body:not(.dark-mode),
body:not(.dark-mode) .dashboard-wrapper {
    --card-bg: rgba(255, 255, 255, 0.75);
    --text-primary: var(--text-primary-light);
    --text-secondary: var(--text-secondary-light);
    --border-color: rgba(255, 255, 255, 0.3);
    --shadow-sm: 0 4px 16px rgba(31, 41, 55, 0.08);
    --shadow-md: 0 8px 24px rgba(31, 41, 55, 0.12);
    --shadow-lg: 0 12px 32px rgba(31, 41, 55, 0.15);
}

.dashboard-container { min-height: 100vh; padding: 1.5rem; max-width: 1600px; margin: 0 auto; }
.relative { position: relative; }
[x-cloak] { display: none !important; }

/* Header */
.header-container { display: flex; flex-direction: column; justify-content: space-between; gap: 1rem; margin-bottom: 2rem; }
.header-greeting h1 { font-size: 2.25rem; font-weight: 800; line-height: 1.2; letter-spacing: -1px; }

/* Animasi Gradien Teks dengan warna UNIMUS */
.gradient-text {
    background: linear-gradient(90deg, #0ea5e9, #0891b2, #fbbf24, #0ea5e9);
    background-size: 250% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-flow 8s ease-in-out infinite;
}

@keyframes gradient-flow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.dashboard-wrapper .user-name { display: block; color: var(--text-primary); text-shadow: 1px 1px 3px rgba(0,0,0,0.5); }
.dashboard-wrapper .header-actions { display: flex; align-items: center; gap: 1rem; }
.dashboard-wrapper .live-clock { font-size: 0.875rem; font-weight: 500; color: var(--text-secondary); background-color: var(--card-bg); backdrop-filter: blur(10px); padding: 0.5rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border-color); white-space: nowrap; box-shadow: var(--shadow-sm); }
.dashboard-wrapper .notification-button, .dashboard-wrapper .profile-button { position: relative; border: 1px solid var(--border-color); background-color: var(--card-bg); backdrop-filter: blur(10px); border-radius: 9999px; transition: var(--transition-ease); color: var(--text-secondary); cursor: pointer; box-shadow: var(--shadow-sm); }
.notification-button { width: 44px; height: 44px; font-size: 1.1rem; display: inline-flex; align-items: center; justify-content: center; }
.notification-badge { position: absolute; top: -4px; right: -4px; width: 1.2rem; height: 1.2rem; background-color: #ef4444; color: white; font-size: 0.7rem; font-weight: 600; border-radius: 9999px; display: flex; justify-content: center; align-items: center; border: 2px solid #374151; animation: pulse-badge 2s infinite; }

@keyframes pulse-badge {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.profile-button img { width: 44px; height: 44px; border-radius: 9999px; object-fit: cover; }
.notification-button:hover, .profile-button:hover { color: var(--primary-color); border-color: var(--primary-color); transform: translateY(-2px); box-shadow: var(--shadow-md); }

/* Dropdowns - Scoped to dashboard */
.dashboard-wrapper .dropdown-header { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color); }
.dashboard-wrapper .dropdown-header h4 { font-weight: 600; color: var(--text-primary); }
.dashboard-wrapper .dropdown-content { max-height: 22rem; overflow-y: auto; }
.dashboard-wrapper .notification-item { display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color); transition: background-color 0.2s; }
.dashboard-wrapper .notification-item:last-child { border-bottom: none; }
.dashboard-wrapper .notification-item:hover { background-color: rgba(55, 65, 81, 0.7); }
.dashboard-wrapper .notification-item p { font-size: 0.875rem; color: var(--text-secondary); }
.dashboard-wrapper .notification-item b { color: var(--text-primary); }
.dashboard-wrapper .dropdown-empty { padding: 2rem 1rem; text-align: center; font-size: 0.875rem; color: var(--text-secondary); }
.dashboard-wrapper .notification-dropdown, .dashboard-wrapper .profile-dropdown { position: absolute; top: 100%; right: 0; margin-top: 0.75rem; background-color: var(--card-bg); backdrop-filter: blur(10px); border-radius: 0.75rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-lg); z-index: 40; overflow: hidden; }
.notification-dropdown { width: 24rem; }
.profile-dropdown { width: 14rem; }

/* Stats Grid & Main Content Grid - Scoped to dashboard */
.dashboard-wrapper .stats-card, .dashboard-wrapper .content-card {
    background-color: var(--card-bg);
    backdrop-filter: blur(15px) saturate(180%); /* Enhanced Glass Effect */
    border-radius: 1.25rem;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    transition: var(--transition-ease);
}

/* Light mode glass enhancement */
body:not(.dark-mode) .dashboard-wrapper .stats-card, 
body:not(.dark-mode) .dashboard-wrapper .content-card {
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(15px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(31, 41, 55, 0.08), 
                0 2px 8px rgba(31, 41, 55, 0.05);
}

body:not(.dark-mode) .dashboard-wrapper .stats-card:hover {
    background: rgba(255, 255, 255, 0.85);
    box-shadow: 0 16px 48px rgba(31, 41, 55, 0.12), 
                0 4px 16px rgba(31, 41, 55, 0.08);
}
.dashboard-wrapper .content-card { padding: 0; } /* Reset padding untuk content-card karena header punya padding sendiri */

.dashboard-wrapper .stats-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); background-color: rgba(30, 41, 59, 0.9); }
.dashboard-wrapper .icon-wrapper { width: 3.5rem; height: 3.5rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; transition: var(--transition-ease); }
.dashboard-wrapper .stats-card:hover .icon-wrapper { transform: scale(1.1) rotate(-5deg); }
.dashboard-wrapper .stats-label { font-size: 0.9rem; font-weight: 500; color: var(--text-secondary); margin-bottom: 0.25rem; }
.dashboard-wrapper .stats-value { font-size: 2.25rem; font-weight: 700; color: var(--text-primary); line-height: 1; }

.dashboard-wrapper .stats-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
.dashboard-wrapper .main-content-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 1.5rem; }
.dashboard-wrapper .card-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
.dashboard-wrapper .card-header h3 { font-size: 1.25rem; font-weight: 600; color: var(--text-primary); }

/* Animasi Tombol */
.btn-primary {
    background-image: var(--primary-gradient);
    color: white; font-size: 0.875rem; font-weight: 500;
    padding: 0.6rem 1.2rem; border-radius: 0.5rem;
    border: none; box-shadow: var(--shadow-md); cursor: pointer;
    background-size: 200% auto;
    transition: all 0.4s ease;
}
.btn-primary:hover {
    background-position: right center;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Table - Scoped to dashboard */
.dashboard-wrapper .table-wrapper { overflow-x: auto; }
.dashboard-wrapper table { width: 100%; border-collapse: collapse; }
.dashboard-wrapper table th, .dashboard-wrapper table td { padding: 1rem 1.5rem; text-align: left; font-size: 0.875rem; border-top: 1px solid var(--border-color); }
.dashboard-wrapper table th { font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; user-select: none; border-top: none; background-color: transparent; }
.dashboard-wrapper table tbody tr:hover { background-color: rgba(55, 65, 81, 0.5); }
.dashboard-wrapper .user-cell { display: flex; align-items: center; gap: 0.75rem; color: var(--text-primary); }
.dashboard-wrapper .user-cell small { color: var(--text-secondary); }
.dashboard-wrapper .user-cell img { width: 32px; height: 32px; border-radius: 9999px; }
.status-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; border: 1px solid; }
.status-pending { background-color: #fef9c3; color: #854d0e; border-color: #fde68a; }
.status-in_progress { background-color: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
.status-completed { background-color: #d1fae5; color: #065f46; border-color: #a7f3d0; }
.dashboard-wrapper .action-buttons { display: flex; justify-content: flex-end; gap: 0.5rem; }
.dashboard-wrapper .action-buttons a { color: var(--text-secondary); padding: 0.5rem; border-radius: 9999px; transition: var(--transition-ease); }
.dashboard-wrapper .action-buttons a:hover { color: var(--primary-color); background-color: rgba(55, 65, 81, 0.8); transform: scale(1.1); }
.dashboard-wrapper .empty-cell { text-align: center; padding: 3rem 1.5rem; color: var(--text-secondary); }
.dashboard-wrapper .empty-cell svg { margin: 0 auto 1rem; width: 3rem; height: 3rem; color: #4b5563; }
.dashboard-wrapper .empty-cell p { font-size: 1rem; font-weight: 500; }

/* Activity Feed - Scoped to dashboard */
.dashboard-wrapper .activity-feed { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }
.dashboard-wrapper .activity-item { display: flex; align-items: flex-start; gap: 1rem; position: relative; }
.dashboard-wrapper .activity-item img { width: 40px; height: 40px; border-radius: 9999px; object-fit: cover; z-index: 1; }
.dashboard-wrapper .activity-item p { font-size: 0.875rem; color: var(--text-primary); line-height: 1.5; }
.dashboard-wrapper .activity-item small { color: var(--text-secondary); }

/* Responsive Media Queries - Scoped to dashboard */
@media (max-width: 768px) { /* Mobile */
    .dashboard-wrapper .dashboard-container { 
        padding: 1rem !important; 
        min-height: auto !important;
    }
    
    .dashboard-wrapper .header-container { 
        flex-direction: column !important; 
        gap: 1rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .dashboard-wrapper .header-greeting h1 { 
        font-size: 1.75rem !important; 
        line-height: 1.3 !important;
        text-align: center !important;
    }
    
    .dashboard-wrapper .header-actions { 
        justify-content: center !important;
        flex-wrap: wrap !important;
    }
    
    .dashboard-wrapper .stats-grid { 
        grid-template-columns: repeat(1, 1fr) !important; 
        gap: 1rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .dashboard-wrapper .main-content-grid { 
        grid-template-columns: repeat(1, 1fr) !important; 
        gap: 1rem !important;
    }
    
    .dashboard-wrapper .stats-card { 
        padding: 1rem !important; 
    }
    
    .dashboard-wrapper .content-card { 
        margin-bottom: 1rem !important; 
    }
    
    .dashboard-wrapper .card-header { 
        padding: 1rem !important; 
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.5rem !important;
    }
    
    .dashboard-wrapper .btn-primary {
        font-size: 0.75rem !important;
        padding: 0.5rem 1rem !important;
    }
    
    .dashboard-wrapper .notification-dropdown {
        width: calc(100vw - 2rem) !important;
        left: 1rem !important;
        right: 1rem !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    
    .dashboard-wrapper .activity-feed { 
        padding: 1rem !important; 
    }
    
    .dashboard-wrapper .activity-item { 
        gap: 0.75rem !important; 
        padding: 0.75rem !important;
        border-radius: 0.5rem !important;
    }
    
    .dashboard-wrapper .activity-item img { 
        width: 32px !important; 
        height: 32px !important; 
    }
    
    .dashboard-wrapper .live-clock {
        font-size: 0.75rem !important;
        padding: 0.5rem 0.75rem !important;
    }
}

@media (min-width: 768px) { /* md */
    .dashboard-wrapper .dashboard-container { padding: 2rem; }
    .dashboard-wrapper .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1024px) { /* lg */
    .dashboard-wrapper .header-container { flex-direction: row; align-items: center; }
    .dashboard-wrapper .stats-grid { grid-template-columns: repeat(4, 1fr); }
    .dashboard-wrapper .main-content-grid { grid-template-columns: repeat(3, 1fr); }
    .dashboard-wrapper .tasks-card { grid-column: span 2 / span 2; }
}

/* Sorting Icon Logic */
.sort-icon { display: inline-block; width: 1rem; height: 1rem; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: center; vertical-align: middle; margin-left: 0.25rem; opacity: 0.5; transition: opacity 0.2s ease; }
th:hover .sort-icon { opacity: 1; }
th.asc .sort-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23a78bfa'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 15l7-7 7 7'/%3e%3c/svg%3e"); opacity: 1; }
th.desc .sort-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23a78bfa'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3e%3c/svg%3e"); opacity: 1; }

/* Dark Mode Specific Optimizations - Scoped to dashboard */
body.dark-mode .dashboard-wrapper .gradient-text {
    background: linear-gradient(90deg, #60a5fa, #3b82f6, #fbbf24, #60a5fa);
    background-size: 250% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradient-flow 8s ease-in-out infinite;
}

body.dark-mode .dashboard-wrapper .user-name {
    color: var(--text-primary);
    text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
}

body.dark-mode .dashboard-wrapper .notification-dropdown,
body.dark-mode .dashboard-wrapper .profile-dropdown {
    background-color: rgba(30, 41, 59, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(75, 85, 99, 0.5);
}

body.dark-mode .dashboard-wrapper .notification-item:hover {
    background-color: rgba(55, 65, 81, 0.8);
}

body.dark-mode .dashboard-wrapper .activity-item p {
    color: var(--text-primary);
}

body.dark-mode .dashboard-wrapper .activity-item small {
    color: var(--text-secondary);
}

/* Fix untuk text yang masih gelap di dark mode - Scoped to dashboard */
body.dark-mode .dashboard-wrapper .font-semibold.text-gray-800 {
    color: #f1f5f9 !important;
}

body.dark-mode .dashboard-wrapper .text-xs.text-gray-500 {
    color: #9ca3af !important;
}

body.dark-mode .dashboard-wrapper .font-medium {
    color: #e2e8f0 !important;
}

/* Ensure light mode text remains readable in dashboard */
body:not(.dark-mode) .dashboard-wrapper .font-semibold.text-gray-800 {
    color: #1f2937 !important;
}

body:not(.dark-mode) .dashboard-wrapper .text-xs.text-gray-500 {
    color: #6b7280 !important;
}

body:not(.dark-mode) .dashboard-wrapper .font-medium {
    color: #374151 !important;
}

/* Status badges optimizations for dark mode - Scoped to dashboard */
body.dark-mode .dashboard-wrapper .status-pending {
    background-color: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
    border-color: rgba(251, 191, 36, 0.3);
}

body.dark-mode .dashboard-wrapper .status-in_progress {
    background-color: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.3);
}

body.dark-mode .dashboard-wrapper .status-completed {
    background-color: rgba(34, 197, 94, 0.2);
    color: #4ade80;
    border-color: rgba(34, 197, 94, 0.3);
}

/* Activity Feed Text Visibility Fix */
body.dark-mode .dashboard-wrapper .activity-item .font-semibold.text-gray-800 {
    color: #f1f5f9 !important;
}

body.dark-mode .dashboard-wrapper .activity-item .text-gray-600 {
    color: #e2e8f0 !important;
}

body.dark-mode .dashboard-wrapper .activity-item .text-gray-500 {
    color: #94a3b8 !important;
}

body.dark-mode .dashboard-wrapper .activity-item .bg-green-100 {
    background: rgba(34, 197, 94, 0.2) !important;
}

body.dark-mode .dashboard-wrapper .activity-item .text-green-700 {
    color: #4ade80 !important;
}

body.dark-mode .dashboard-wrapper .activity-item .text-blue-600 {
    color: #60a5fa !important;
}

/* Table Text Visibility Fix */
body.dark-mode .dashboard-wrapper table .font-semibold.text-gray-800 {
    color: #f1f5f9 !important;
}

body.dark-mode .dashboard-wrapper table .text-gray-600 {
    color: #e2e8f0 !important;
}

body.dark-mode .dashboard-wrapper table .text-gray-500 {
    color: #94a3b8 !important;
}

body.dark-mode .dashboard-wrapper table .text-gray-400 {
    color: #9ca3af !important;
}

body.dark-mode .dashboard-wrapper table .text-blue-600 {
    color: #60a5fa !important;
}

body.dark-mode .dashboard-wrapper table .bg-blue-100 {
    background: rgba(59, 130, 246, 0.2) !important;
}

body.dark-mode .dashboard-wrapper table .text-blue-800 {
    color: #60a5fa !important;
}
</style>

<script>
// --- FUNGSI NOTIFIKASI OFFLINE ---

/**
 * Fungsi untuk memberitahu server bahwa notifikasi sudah dibaca.
 * Dipanggil saat ikon lonceng di-klik.
 */
async function markNotificationsAsRead() {
    let badge = document.querySelector('.notification-badge');
    
    // Hanya jalankan jika ada notifikasi yang belum dibaca
    if (badge && parseInt(badge.innerText) > 0) {
        try {
            await fetch('/notifications/mark-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            // Langsung sembunyikan badge di frontend untuk respons instan
            badge.innerText = '0';
            badge.style.display = 'none';
            // Hapus animasi setelah diklik
            badge.style.animation = 'none';

        } catch (error) {
            console.error('Gagal menandai notifikasi:', error);
        }
    }
}

/**
 * Fungsi ini mengambil notifikasi terbaru dari server secara berkala.
 */
async function fetchLatestNotifications() {
    try {
        const response = await fetch('/notifications/latest');
        if (!response.ok) throw new Error('Network response was not ok');
        const newNotifications = await response.json();

        if (newNotifications.length > 0) {
            setNotificationBadge(newNotifications.length);
            addNotificationsToDropdown(newNotifications);
        }
    } catch (error) {
        console.error('Gagal mengambil notifikasi:', error);
    }
}

/**
 * Fungsi ini MENGGANTI (SET) nilai badge, bukan menambahkannya.
 * @param {number} count - Jumlah total notifikasi baru.
 */
function setNotificationBadge(count) {
    let badge = document.querySelector('.notification-badge');
    if (badge) {
        badge.innerText = count;
        if (count > 0) {
            badge.style.display = 'flex';
            badge.style.animation = 'pulse-badge 2s infinite'; // Aktifkan lagi animasi jika ada notif baru
        } else {
            badge.style.display = 'none';
            badge.style.animation = 'none';
        }
    }
}

/**
 * Fungsi untuk menambahkan item notifikasi baru ke dalam daftar dropdown.
 */
function addNotificationsToDropdown(notifications) {
    const listElement = document.getElementById('notification-list');
    const emptyMessage = document.getElementById('notification-empty-message');
    if (!listElement) return;
    if (emptyMessage) emptyMessage.style.display = 'none';

    notifications.forEach(notification => {
        // Cek agar tidak menambahkan notifikasi yang sudah ada di daftar
        if (!document.querySelector(`[data-notification-id="${notification.id}"]`)) {
            const notificationHtml = `
                <a href="#" class="notification-item" data-notification-id="${notification.id}">
                    <p><b class="font-semibold">${notification.data.sender_name ?? 'Sistem'}</b> ${notification.data.message}</p>
                    <small class="text-slate-500 mt-1">${notification.created_at_human}</small>
                </a>
            `;
            listElement.insertAdjacentHTML('afterbegin', notificationHtml);
        }
    });
}


// --- FUNGSI DASAR DASHBOARD (TIDAK BERUBAH) ---
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        let start = 0;
        const target = +counter.getAttribute('data-target');
        if (target === 0) return;
        const duration = 1500;
        const increment = target / (duration / 16);

        const updateCount = () => {
            start += increment;
            if (start < target) {
                counter.innerText = Math.ceil(start).toLocaleString('id-ID');
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target.toLocaleString('id-ID');
            }
        };
        updateCount();
    });
}

function updateLiveClock() {
    const clockElement = document.getElementById('live-clock');
    if (!clockElement) return;
    const now = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long' };
    const dateString = now.toLocaleDateString('id-ID', options);
    const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    clockElement.textContent = `${dateString}, ${timeString}`;
}

let currentSort = { column: null, direction: 'asc' };
function sortTable(columnIndex) {
    const table = document.getElementById('tasksTable');
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const taskRows = rows.filter(row => row.hasAttribute('data-due-date'));
    const headers = table.querySelectorAll('thead th');

    if (currentSort.column === columnIndex) {
        currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
    } else {
        currentSort.column = columnIndex;
        currentSort.direction = 'asc';
    }
    const direction = currentSort.direction === 'asc' ? 1 : -1;

    taskRows.sort((a, b) => {
        let valA, valB;
        if (columnIndex === 2) { // Kolom Tanggal
            valA = new Date(a.dataset.dueDate).getTime();
            valB = new Date(b.dataset.dueDate).getTime();
        } else {
            const cellA = a.querySelectorAll('td')[columnIndex];
            const cellB = b.querySelectorAll('td')[columnIndex];
            valA = cellA ? cellA.innerText.trim().toLowerCase() : '';
            valB = cellB ? cellB.innerText.trim().toLowerCase() : '';
        }
        if (valA < valB) return -1 * direction;
        if (valA > valB) return 1 * direction;
        return 0;
    });

    taskRows.forEach(row => tbody.appendChild(row));
    headers.forEach(th => th.classList.remove('asc', 'desc'));
    if (headers[columnIndex]) headers[columnIndex].classList.add(currentSort.direction);
}


// --- INISIALISASI HALAMAN ---
document.addEventListener('DOMContentLoaded', () => {
    if (typeof AOS !== 'undefined') {
        AOS.init({ once: true, duration: 600, easing: 'ease-out-quad', delay: 100 });
    }
    animateCounters();
    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    // Mulai polling untuk notifikasi setiap 7 detik
    setInterval(fetchLatestNotifications, 7000);
});
</script>
@endsection
