<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Take Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">Your Teaching Schedule</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($schedules as $schedule)
                            <a href="{{ route('teacher.attendance.create', ['school_class' => $schedule->class_id, 'subject' => $schedule->subject_id]) }}" class="block p-6 bg-gray-100 hover:bg-gray-200 rounded-lg shadow">
                                <p class="text-lg font-bold">{{ $schedule->class_name }}</p>
                                <p class="text-md text-gray-700">{{ $schedule->subject_name }}</p>
                                <p class="text-sm text-blue-600 mt-4">Take today's attendance &rarr;</p>
                            </a>
                        @empty
                            <p>You have no assigned classes.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
