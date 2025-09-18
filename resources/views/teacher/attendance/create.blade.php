<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance for ') }} {{ $schoolClass->name }} - {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Date: <strong>{{ $today }}</strong></p>
                    <form action="{{ route('teacher.attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="school_class_id" value="{{ $schoolClass->id }}">
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        <input type="hidden" name="date" value="{{ $today }}">

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                            <select name="students[{{ $student->id }}][status]" class="rounded-md border-gray-300 shadow-sm">
                                                @php $currentStatus = $todaysAttendance[$student->id]->status ?? 'present'; @endphp
                                                <option value="present" @selected($currentStatus == 'present')>Present</option>
                                                <option value="absent" @selected($currentStatus == 'absent')>Absent</option>
                                                <option value="permission" @selected($currentStatus == 'permission')>Permission</option>
                                                <option value="sick" @selected($currentStatus == 'sick')>Sick</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
