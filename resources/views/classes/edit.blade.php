<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ Auth::user()->role->name === 'admin' ? route('admin.classes.update', $class) : route('teacher.classes.update', $class) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Class Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name', $class->name) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700">Homeroom Teacher</label>
                            <select name="teacher_id" id="teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">None</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" @selected(old('teacher_id', $class->teacher_id) == $teacher->id)>{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
