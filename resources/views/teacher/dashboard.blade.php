<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Teacher Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Total Classes</h3>
                        <p class="text-3xl font-bold">{{ $teacherStats['total_classes'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Total Subjects</h3>
                        <p class="text-3xl font-bold">{{ $teacherStats['total_subjects'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Total Students</h3>
                        <p class="text-3xl font-bold">{{ $teacherStats['total_students'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Today's Schedule -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Today's Schedule</h3>
                            <ul class="space-y-2">
                                @forelse ($schedules as $schedule)
                                    <li class="p-4 bg-gray-50 rounded-md flex justify-between items-center">
                                        <span>{{ $schedule->class_name }} - <strong>{{ $schedule->subject_name }}</strong></span>
                                        <a href="{{ route('teacher.attendance.qrcode', ['school_class_id' => $schedule->class_id, 'subject_id' => $schedule->subject_id]) }}" class="text-sm text-blue-600 hover:underline">Generate QR Code &rarr;</a>
                                    </li>
                                @empty
                                    <li>No classes scheduled for today.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Student Performance -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Student Performance</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold mb-2">Most Absences</h4>
                                    <ul class="space-y-2">
                                        @forelse ($studentPerformance['most_absences'] as $student)
                                            <li class="text-sm">{{ $student->user->name }} ({{ $student->attendances->where('status', 'absent')->count() }} absences)</li>
                                        @empty
                                            <li class="text-sm text-gray-500">No students with absences.</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2">Perfect Attendance</h4>
                                    <ul class="space-y-2">
                                        @forelse ($studentPerformance['perfect_attendance'] as $student)
                                            <li class="text-sm">{{ $student->user->name }}</li>
                                        @empty
                                            <li class="text-sm text-gray-500">No students with perfect attendance.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Absence Submissions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Recent Absence Submissions</h3>
                            <ul class="space-y-3">
                                @forelse ($recentSubmissions as $submission)
                                    <li class="p-3 bg-gray-50 rounded-md">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">{{ $submission->student->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $submission->reason }}</p>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li>No recent absence submissions.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Attendance Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Attendance Summary (Today)</h3>
                            <div class="flex justify-between items-center">
                                <span>Total Students:</span>
                                <span class="font-bold">{{ $attendanceSummary['total_students'] }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span>Present:</span>
                                <span class="font-bold text-green-600">{{ $attendanceSummary['present'] }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span>Absent:</span>
                                <span class="font-bold text-red-600">{{ $attendanceSummary['absent'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $attendanceSummary['percentage'] }}%"></div>
                            </div>
                            <p class="text-right text-sm mt-1">{{ $attendanceSummary['percentage'] }}% Present</p>
                        </div>
                    </div>

                    <!-- Daily Attendance Chart -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Daily Attendance</h3>
                            <canvas id="dailyAttendanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Weekly Attendance Trend -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Weekly Attendance Trend (%)</h3>
                            <canvas id="weeklyAttendanceChart"></canvas>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                            <ul class="space-y-2">
                                <li class="text-sm text-gray-600">- Parent-teacher meeting on Friday.</li>
                                <li class="text-sm text-gray-600">- School anniversary on Monday.</li>
                            </ul>
                        </div>
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
                type: 'line',
                data: {
                    labels: @json($weeklyTrend['labels']),
                    datasets: [{
                        label: 'Attendance %',
                        data: @json($weeklyTrend['data']),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        tension: 0.3
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

            const dailyCtx = document.getElementById('dailyAttendanceChart').getContext('2d');
            const dailyAttendanceChart = new Chart(dailyCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($dailyAttendanceChart['labels']),
                    datasets: [{
                        label: 'Daily Attendance',
                        data: @json($dailyAttendanceChart['data']),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        </script>
    @endpush
</x-app-layout>