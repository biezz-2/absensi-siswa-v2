<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Teacher for :subject in :class', ['subject' => $subject->name, 'class' => $class->name]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.classes.subjects.update', [$class, $subject]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="teacher_id" :value="__('Teacher')" />
                            <select name="teacher_id" id="teacher_id" class="block mt-1 w-full form-select">
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $currentTeacherId == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Teacher') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
