<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
              document.documentElement.classList.add('dark')
            } else {
              document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body 
        x-data="{
            theme: localStorage.getItem('theme') || 'dark',
            toggleTheme() {
                this.theme = this.theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.theme);
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }"
        class="font-sans text-slate-800 dark:text-slate-200 bg-slate-100 dark:bg-slate-900 transition-colors duration-300"
    >
        <button
            @click="toggleTheme"
            class="absolute top-6 right-6 p-2 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-100 dark:focus:ring-offset-slate-900"
        >
            <template x-if="theme === 'dark'">
                <x-icons.sun class="w-6 h-6" />
            </template>
            <template x-if="theme !== 'dark'">
                <x-icons.moon class="w-6 h-6" />
            </template>
        </button>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            {{ $slot }}
        </div>
    </body>
</html>