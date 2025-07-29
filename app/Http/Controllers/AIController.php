<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AIController extends Controller
{
    /**
     * Process AI command from the chatbot.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processCommand(Request $request)
    {
        $command = strtolower($request->input('command', ''));

        // Command: "hapus user [nama]"
        if (Str::startsWith($command, 'hapus user ')) {
            $name = Str::after($command, 'hapus user ');
            $user = User::where('name', 'like', '%' . $name . '%')->first();

            if (!$user) {
                return response()->json(['reply' => "Maaf, pengguna dengan nama '{$name}' tidak ditemukan."]);
            }

            if ($user->id === Auth::id()) {
                return response()->json(['reply' => 'Anda tidak dapat menghapus akun Anda sendiri melalui AI.']);
            }

            $user->delete();
            return response()->json([
                'status' => 'success',
                'reply' => "Baik, pengguna '{$user->name}' telah berhasil dihapus. Halaman akan dimuat ulang."
            ]);
        }

        // Command: "jadikan [nama] admin" atau "jadikan [nama] mahasiswa"
        if (Str::startsWith($command, 'jadikan ')) {
            $parts = explode(' ', $command);
            $name = $parts[1] ?? '';
            $role = end($parts); // admin or mahasiswa

            if ($role !== 'admin' && $role !== 'mahasiswa') {
                return response()->json(['reply' => "Peran yang Anda maksud tidak valid. Gunakan 'admin' atau 'mahasiswa'."]);
            }

            $user = User::where('name', 'like', '%' . $name . '%')->first();

            if (!$user) {
                return response()->json(['reply' => "Maaf, pengguna dengan nama '{$name}' tidak ditemukan."]);
            }
            
            if ($user->id === Auth::id()) {
                return response()->json(['reply' => 'Anda tidak dapat mengubah role Anda sendiri melalui AI.']);
            }

            $role_id = ($role === 'admin') ? 1 : 2;
            $user->update(['role_id' => $role_id]);

            return response()->json([
                'status' => 'success',
                'reply' => "Siap! Role untuk '{$user->name}' telah diubah menjadi {$role}. Halaman akan dimuat ulang."
            ]);
        }

        // Command: "statistik" atau "stats"
        if (in_array($command, ['statistik', 'stats', 'laporan'])) {
            $totalUsers = User::count();
            $totalAdmins = User::where('role_id', 1)->count();
            $totalStudents = User::where('role_id', 2)->count();
            $totalTasks = Task::count();
            $completedTasks = Task::where('status', 'completed')->count();
            $pendingTasks = Task::where('status', 'pending')->count();

            return response()->json([
                'reply' => "📊 <strong>Statistik Sistem UNIMUS:</strong><br><br>
                👥 <strong>Pengguna:</strong><br>
                • Total: {$totalUsers}<br>
                • Admin/Dosen: {$totalAdmins}<br>
                • Mahasiswa: {$totalStudents}<br><br>
                📋 <strong>Tugas:</strong><br>
                • Total: {$totalTasks}<br>
                • Selesai: {$completedTasks}<br>
                • Pending: {$pendingTasks}"
            ]);
        }

        // Command: "daftar user" atau "list user"
        if (in_array($command, ['daftar user', 'list user', 'tampilkan user'])) {
            $users = User::select('name', 'email', 'role_id')->get();
            $userList = "👥 <strong>Daftar Pengguna:</strong><br><br>";
            
            foreach ($users as $user) {
                $role = $user->role_id == 1 ? 'Admin/Dosen' : 'Mahasiswa';
                $userList .= "• {$user->name} ({$role})<br>";
            }

            return response()->json(['reply' => $userList]);
        }

        // Command: "hapus tugas [judul]"
        if (Str::startsWith($command, 'hapus tugas ')) {
            $title = Str::after($command, 'hapus tugas ');
            $task = Task::where('title', 'like', '%' . $title . '%')->first();

            if (!$task) {
                return response()->json(['reply' => "Maaf, tugas dengan judul '{$title}' tidak ditemukan."]);
            }

            $taskTitle = $task->title;
            $task->delete();
            
            return response()->json([
                'status' => 'success',
                'reply' => "Baik, tugas '{$taskTitle}' telah berhasil dihapus. Halaman akan dimuat ulang."
            ]);
        }

        // Command: "tugas pending" atau "tugas belum selesai"
        if (in_array($command, ['tugas pending', 'tugas belum selesai', 'pending tasks'])) {
            $pendingTasks = Task::where('status', 'pending')
                ->with(['assignedTo', 'createdBy'])
                ->get();

            if ($pendingTasks->isEmpty()) {
                return response()->json(['reply' => "🎉 Hebat! Tidak ada tugas yang pending saat ini."]);
            }

            $taskList = "⏳ <strong>Tugas Pending:</strong><br><br>";
            foreach ($pendingTasks as $task) {
                $assignedTo = $task->assignedTo ? $task->assignedTo->name : 'Belum ditugaskan';
                $taskList .= "• {$task->title} → {$assignedTo}<br>";
            }

            return response()->json(['reply' => $taskList]);
        }

        // Command: "bantuan" atau "help"
        if (in_array($command, ['bantuan', 'help', 'perintah'])) {
            return response()->json([
                'reply' => "🤖 <strong>Perintah AI Assistant UNIMUS:</strong><br><br>
                👥 <strong>Manajemen User:</strong><br>
                • hapus user [nama] - Menghapus pengguna<br>
                • jadikan [nama] admin - Ubah role ke admin<br>
                • jadikan [nama] mahasiswa - Ubah role ke mahasiswa<br>
                • daftar user - Tampilkan semua pengguna<br><br>
                📋 <strong>Manajemen Tugas:</strong><br>
                • hapus tugas [judul] - Menghapus tugas<br>
                • tugas pending - Tampilkan tugas pending<br><br>
                📊 <strong>Informasi Sistem:</strong><br>
                • statistik - Tampilkan statistik sistem<br>
                • bantuan - Tampilkan perintah ini"
            ]);
        }

        // Default reply if command is not understood
        return response()->json([
            'reply' => "🤔 Maaf, saya belum mengerti perintah '<strong>{$command}</strong>'. Ketik '<strong>bantuan</strong>' untuk melihat daftar perintah yang tersedia."
        ]);
    }
}
