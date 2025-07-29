<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-blue-500"></i>Nama Lengkap
            </label>
            <input id="name" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            @error('name')
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
            </label>
            <input id="email" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Masukkan email Anda" />
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
            <input id="password" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password Anda" />
            @error('password')
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-500"></i>Konfirmasi Password
            </label>
            <input id="password_confirmation" class="block w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-20 px-4 py-3 text-sm transition-all duration-300" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password Anda" />
            @error('password_confirmation')
                <p class="text-sm text-red-600 mt-2 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Tombol Register -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                <i class="fas fa-user-plus mr-2"></i>DAFTAR AKUN
            </button>
        </div>

        <!-- Link Login -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-300" href="{{ route('login') }}">
                    Masuk sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
