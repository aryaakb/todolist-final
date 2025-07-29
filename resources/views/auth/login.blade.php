<x-guest-layout>
    {{--
        Kode ini telah disederhanakan agar sesuai dengan layout guest.blade.php yang baru.
        Layout guest sekarang menangani wadah kartu, jadi kita hanya perlu menampilkan form di sini.
    --}}

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Alamat Email -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
            </label>
            <input id="email" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
            @error('email')
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-500"></i>Password
            </label>
            <input id="password" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda" />
            @error('password')
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Ingat Saya -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-500 shadow-sm focus:ring-blue-500 focus:ring-opacity-20" name="remember">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-300" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Tombol Login -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i>MASUK SISTEM
            </button>
        </div>

        <!-- Link Register -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-300" href="{{ route('register') }}">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
