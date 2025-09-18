<x-guest-layout>
    <div x-data="{
        mode: 'login',
        isLoading: false,
        error: '',
        suggestions: [],
        fullName: '',
        nickname: '',
        handleSuggestNicknames: async function() {
            if (!this.fullName.trim()) { this.error = 'Silakan isi nama lengkap terlebih dahulu.'; return; }
            this.error = ''; this.isLoading = true; this.suggestions = [];
            try {
                const response = await fetch('{{ route("api.nickname.suggest") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ full_name: this.fullName })
                });
                if (!response.ok) { throw new Error(`API error: ${response.statusText}`); }
                const result = await response.json();
                if (result.suggestions) { this.suggestions = result.suggestions; } 
                else { throw new Error('Tidak ada saran yang diterima dari API.'); }
            } catch (err) {
                console.error(err);
                this.error = 'Gagal mendapatkan saran. Silakan coba lagi.';
            } finally {
                this.isLoading = false;
            }
        }
    }" class="relative w-full max-w-md mx-4" style="min-height: 650px;">

        {{-- Login Form --}}
        <div x-show="mode === 'login'" x-transition:enter="transition-all duration-700 ease-in-out" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition-all duration-300 ease-in-out" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="absolute w-full">
            @include('auth.partials.login-form')
        </div>

        {{-- Signup Form --}}
        <div x-show="mode === 'signup'" x-transition:enter="transition-all duration-700 ease-in-out" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition-all duration-300 ease-in-out" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="absolute w-full">
            @include('auth.partials.register-form')
        </div>

    </div>
</x-guest-layout>