<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absence Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Responsive Wrapper -->
                    <div class="w-full">
                        <!-- Table for Medium screens and up -->
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Document</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @forelse ($submissions as $submission)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->student->user->name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($submission->reason, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->document_path)
                                                <a href="{{ asset('storage/' . $submission->document_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">View Document</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @switch($submission->status)
                                                    @case('pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 @break
                                                    @case('approved') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 @break
                                                    @case('rejected') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @break
                                                @endswitch
                                            ">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->status === 'pending')
                                                <div class="flex items-center space-x-2">
                                                    <form action="{{ route('admin.absence-submissions.update', $submission) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="text-sm text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-semibold">Approve</button>
                                                    </form>
                                                    <form action="{{ route('admin.absence-submissions.update', $submission) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-sm text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold">Reject</button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No submissions found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Card view for Mobile -->
                        <div class="grid grid-cols-1 gap-4 md:hidden">
                            @forelse ($submissions as $submission)
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 space-y-3 border border-gray-200 dark:border-slate-700">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold">{{ $submission->student->user->name }}</h3>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($submission->status)
                                                @case('pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 @break
                                                @case('approved') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 @break
                                                @case('rejected') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @break
                                            @endswitch
                                        ">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $submission->reason }}</p>
                                    <div class="text-sm flex justify-between items-center pt-2 border-t border-gray-200 dark:border-slate-700">
                                        <div>
                                            @if($submission->document_path)
                                                <a href="{{ asset('storage/' . $submission->document_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">View Document</a>
                                            @else
                                                <span class="text-gray-400">No Document</span>
                                            @endif
                                        </div>
                                        @if($submission->status === 'pending')
                                            <div class="flex items-center space-x-2">
                                                <form action="{{ route('admin.absence-submissions.update', $submission) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="text-sm text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-semibold">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.absence-submissions.update', $submission) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold">Reject</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-400 py-4">No submissions found.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
