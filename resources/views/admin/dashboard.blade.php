<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- AI Prompt -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">AI Assistant</h3>
                    <form action="{{ route('admin.dashboard.prompt') }}" method="POST">
                        @csrf
                        <div class="flex space-x-4">
                            <x-text-input id="prompt" name="prompt" class="block w-full" placeholder="e.g., tambahkan guru baru bernama syarif yang mengajar mata pembelajaran informatika kelas 10 A sampai kelas 10 C" />
                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Users</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Teachers</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['teachers'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Students</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['students'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Classes</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['classes'] }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Pending Submissions</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['pending_submissions'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Weekly Trend -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Weekly Attendance Trend (%)</h3>
                    <canvas id="weeklyAttendanceChart"></canvas>
                </div>

                <!-- Right Column: Attendance Summary & AI Insights -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Today's Attendance</h3>
                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-slate-700">
                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $stats['attendance_percentage'] }}%"></div>
                        </div>
                        <p class="text-right text-sm mt-2 text-gray-600 dark:text-gray-400">{{ $stats['attendance_percentage'] }}% Present</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">AI Performance Insights</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $insights }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const weeklyCtx = document.getElementById('weeklyAttendanceChart').getContext('2d');
            const weeklyAttendanceChart = new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: @json($weeklyTrend['labels']),
                    datasets: [{
                        label: 'Attendance %',
                        data: @json($weeklyTrend['data']),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>