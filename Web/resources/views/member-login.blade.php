<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member - MalangVerse</title>
    @vite(['resources/css/login/login.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full space-y-8 bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl">
        
        {{-- Logo/Header --}}
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl font-bold text-white">M</span>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900">
                Sugeng Rawuh, Sam! 👋
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Masuk ke MalangVerse untuk akses kamus dan kontribusi
            </p>
        </div>

        {{-- Form Login --}}
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ $errors->first('email') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">
                    Alamat Email
                </label>
                <div class="mt-1">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition" 
                        placeholder="sam_kera@ngalam.id">
                </div>
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">
                    Kata Sandi
                </label>
                <div class="mt-1">
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required 
                        class="appearance-none relative block w-full px-4 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition" 
                        placeholder="••••••••">
                </div>
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-slate-700">
                        Ingat Saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                        Lupa kata sandi?
                    </a>
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-lg hover:shadow-xl">
                    Masuk ke MalangVerse
                </button>
            </div>
        </form>

        {{-- Footer Links --}}
        <div class="text-center space-y-3">
            <p class="text-sm text-slate-600">
                Dereng gadhah akun? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500">
                    Daftar Sekarang
                </a>
            </p>
            <p class="text-xs text-slate-400">
                <a href="{{ route('admin.login') }}" class="hover:text-slate-600">
                    Login sebagai Admin →
                </a>
            </p>
        </div>

    </div>

</body>
</html>