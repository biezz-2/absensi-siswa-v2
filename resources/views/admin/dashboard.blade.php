<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Baris Kartu Statistik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-shadow duration-300 flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 rounded-full p-3">
                        <x-icons.users-group class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['users'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-shadow duration-300 flex items-center space-x-4">
                    <div class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-300 rounded-full p-3">
                        <x-icons.user-circle class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Guru</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['teachers'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-shadow duration-300 flex items-center space-x-4">
                    <div class="bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-300 rounded-full p-3">
                        <x-icons.academic-cap class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['students'] }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-lg transition-shadow duration-300 flex items-center space-x-4">
                    <div class="bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-300 rounded-full p-3">
                        <x-icons.office-building class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Kelas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['classes'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Baris Data Visualisasi -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm text-center">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Kehadiran Hari Ini</h3>
                        <div class="relative w-40 h-40 mx-auto">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <circle class="text-gray-200 dark:text-gray-700" stroke-width="3" fill="none" stroke="currentColor" cx="18" cy="18" r="15.9155" />
                                <circle class="text-green-500" stroke-width="3" stroke-dasharray="{{ $stats['attendance_percentage'] }}, 100" stroke-linecap="round" fill="none" stroke="currentColor" cx="18" cy="18" r="15.9155" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['attendance_percentage'] }}%</span>
                            </div>
                        </div>
                        @if($stats['attendance_percentage'] == 0)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">Belum ada data kehadiran yang masuk.</p>
                        @endif
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Pengajuan Tertunda</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Pengajuan izin/sakit yang perlu ditinjau.</p>
                        <div class="flex justify-between items-center bg-orange-50 dark:bg-orange-900/50 border-l-4 border-orange-400 p-4 rounded-lg">
                            <span class="text-3xl font-bold text-orange-500">{{ $stats['pending_submissions'] }}</span>
                            <a href="{{ route('admin.absence-submissions.index') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 font-semibold text-sm transition-colors duration-300">
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Tren Kehadiran Mingguan</h3>
                    <div class="h-80 rounded-lg">
                        <canvas id="weeklyAttendanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const weeklyCtx = document.getElementById('weeklyAttendanceChart').getContext('2d');
        const weeklyData = @json($weeklyTrend['data']);
        const weeklyLabels = @json($weeklyTrend['labels']);

        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Kehadiran (%)',
                    data: weeklyData,
                    backgroundColor: 'rgba(79, 70, 229, 0.5)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>