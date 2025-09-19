<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">View Attendance</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.classes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Add Class') }}
                            </a>
                            <a href="{{ route('teacher.subjects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Add Subject') }}
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('teacher.attendance.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="class_id" :value="__('Class')" />
                                <select name="class_id" id="class_id" class="block mt-1 w-full form-select">
                                    @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->class_id }}">{{ $schedule->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="subject_id" :value="__('Subject')" />
                                <select name="subject_id" id="subject_id" class="block mt-1 w-full form-select">
                                    @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->subject_id }}">{{ $schedule->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="request('date', now()->format('Y-m-d'))" required />
                            </div>
                            <div>
                                <x-primary-button class="mt-7">
                                    {{ __('View Attendance') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>

                    @if ($attendances)
                        <div class="mt-6">
                            <h4 class="font-semibold text-md mb-2">Attendance for {{ $attendances->first()->class->name }} - {{ $attendances->first()->subject->name }} on {{ $attendances->first()->date->format('d M Y') }}</h4>
                            <div class="flex justify-end mb-4">
                                <a href="{{ route('teacher.attendance.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __('Export to Excel') }}
                                </a>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->student->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($attendance->status) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->created_at->format('H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('teacher.attendance.edit', $attendance) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('teacher.attendance.destroy', $attendance) }}" method="POST" class="inline-block ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>