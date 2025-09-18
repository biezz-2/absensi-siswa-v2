<div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-2xl shadow-slate-200/50 dark:shadow-black/50 w-full border border-slate-200 dark:border-slate-700">
    <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-2 text-center">Selamat Datang!</h2>
    <p class="text-center text-slate-500 dark:text-slate-400 mb-8">Masuk untuk melanjutkan</p>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500">
                <x-input-icon type="email" />
            </div>
            <x-text-input id="email" name="email" type="email" class="pl-10" placeholder="Email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-6 relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500">
                <x-input-icon type="password" />
            </div>
            <x-text-input id="password" name="password" type="password" class="pl-10" placeholder="Password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-center">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 w-full transition-all duration-300" type="submit">Login</button>
        </div>
    </form>
    <p class="text-center text-slate-600 dark:text-slate-400 text-sm mt-8">
        Belum punya akun? 
        <button @click="mode = 'signup'" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 focus:outline-none focus:underline">Daftar di sini</button>
    </p>
</div>
