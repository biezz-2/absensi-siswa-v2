<div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-2xl shadow-slate-200/50 dark:shadow-black/50 w-full border border-slate-200 dark:border-slate-700">
    <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-2 text-center">Buat Akun Baru</h2>
    <p class="text-center text-slate-500 dark:text-slate-400 mb-8">Isi data diri Anda</p>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500"><x-input-icon type="idcard" /></div>
            <x-text-input x-model="fullName" id="name" name="name" type="text" class="pl-10" placeholder="Nama Lengkap" :value="old('name')" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <div class="flex items-center gap-2">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500"><x-input-icon type="user" /></div>
                    <x-text-input x-model="nickname" id="nickname" name="nickname" type="text" class="pl-10" placeholder="Nama Panggilan" :value="old('nickname')" required />
                </div>
                <button type="button" @click="handleSuggestNicknames" :disabled="isLoading || !fullName" class="flex items-center justify-center p-3 rounded-lg bg-indigo-100 hover:bg-indigo-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-indigo-600 dark:text-indigo-300 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <template x-if="isLoading"><div class="w-5 h-5 border-2 border-t-transparent border-current rounded-full animate-spin"></div></template>
                    <template x-if="!isLoading"><x-icons.sparkle class="w-5 h-5" /></template>
                </button>
            </div>
            <p x-show="error" x-text="error" class="text-sm text-red-500 dark:text-red-400 mt-2"></p>
            <div x-show="suggestions.length > 0" class="mt-2 flex flex-wrap gap-2">
                <template x-for="(s, i) in suggestions" :key="i">
                    <button @click="nickname = s" type="button" class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full dark:bg-indigo-900/50 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-900/80 transition-colors" x-text="s"></button>
                </template>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500"><x-input-icon type="email" /></div>
            <x-text-input id="email-register" name="email" type="email" class="pl-10" placeholder="Email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500"><x-input-icon type="password" /></div>
            <x-text-input id="password-register" name="password" type="password" class="pl-10" placeholder="Password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 dark:text-slate-500"><x-input-icon type="password" /></div>
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="pl-10" placeholder="Konfirmasi Password" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="pt-2">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 w-full transition-all duration-300" type="submit">Daftar</button>
        </div>
    </form>
    <p class="text-center text-slate-600 dark:text-slate-400 text-sm mt-8">
        Sudah punya akun? 
        <button @click="mode = 'login'" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 focus:outline-none focus:underline">Login di sini</button>
    </p>
</div>
