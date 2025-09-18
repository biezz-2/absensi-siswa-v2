<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Records') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="class_id" class="block text-sm font-medium text-gray-700">Class</label>
                                <select name="class_id" id="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                                <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">All Students</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>{{ $student->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-transparent">&nbsp;</label>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Filter
                                </button>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-transparent">&nbsp;</label>
                                <a href="{{ route('admin.attendance.export', request()->query()) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full text-center block">
                                    Export to Excel
                                </a>
                            </div>
                        </div>
                    </form>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->student->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->class->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->subject->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($attendance->status)
                                                @case('present') bg-green-100 text-green-800 @break
                                                @case('absent') bg-red-100 text-red-800 @break
                                                @case('permission') bg-yellow-100 text-yellow-800 @break
                                                @case('sick') bg-blue-100 text-blue-800 @break
                                            @endswitch
                                        ">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No attendance records found for the selected filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
