<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('teacher.attendance.update', $attendance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="student_name" :value="__('Student Name')" />
                            <x-text-input id="student_name" class="block mt-1 w-full" type="text" name="student_name" :value="$attendance->student->user->name" disabled />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="text" name="date" :value="$attendance->date" disabled />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full form-select">
                                <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="sick" {{ $attendance->status == 'sick' ? 'selected' : '' }}>Sick</option>
                                <option value="permit" {{ $attendance->status == 'permit' ? 'selected' : '' }}>Permit</option>
                                <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Attendance') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
