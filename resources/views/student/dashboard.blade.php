<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Today's Schedule -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Today's Schedule</h3>
                            <ul class="space-y-2">
                                @forelse ($schedules as $schedule)
                                    <li class="p-4 bg-gray-50 rounded-md">
                                        <span>{{ $schedule->subject_name }}</span>
                                    </li>
                                @empty
                                    <li>No classes scheduled for today.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Absences -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Recent Absences</h3>
                            <ul class="space-y-3">
                                @forelse ($recentAbsences as $absence)
                                    <li class="p-3 bg-gray-50 rounded-md">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">{{ $absence->subject->name }}</p>
                                                <p class="text-sm text-gray-600">{{ ucfirst($absence->status) }}</p>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $absence->date->format('d M Y') }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li>No recent absences.</li>
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
                                <span>Total Subjects:</span>
                                <span class="font-bold">{{ $attendanceSummary['total_subjects'] }}</span>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>