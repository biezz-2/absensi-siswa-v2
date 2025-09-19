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
                    <div class="flex justify-end mb-4">
                        <button id="summarize-btn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Summarize') }}
                        </button>
                    </div>
                    
                    <!-- Responsive Wrapper -->
                    <div class="w-full">
                        <!-- Table for Medium screens and up -->
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-slate-700">
                            <thead class="bg-gray-50 dark:bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><input type="checkbox" id="select-all"></th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Document</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                @forelse ($submissions as $submission)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap"><input type="checkbox" class="submission-checkbox" value="{{ $submission->id }}"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->student->user->name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($submission->reason, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $submission->category }}</td>
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
                                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No submissions found.</td></tr>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-300">Category: {{ $submission->category }}</p>
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

    <!-- Summary Modal -->
    <div id="summary-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Absence Submission Summary
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="summary-content">
                                    Loading...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="close-modal-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const summarizeBtn = document.getElementById('summarize-btn');
            const modal = document.getElementById('summary-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const summaryContent = document.getElementById('summary-content');
            const selectAllCheckbox = document.getElementById('select-all');
            const submissionCheckboxes = document.querySelectorAll('.submission-checkbox');

            summarizeBtn.addEventListener('click', function () {
                const selectedIds = Array.from(submissionCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Please select at least one submission to summarize.');
                    return;
                }

                modal.classList.remove('hidden');
                summaryContent.textContent = 'Loading...';

                fetch('{{ route("admin.absence-submissions.summarize") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ submission_ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    summaryContent.textContent = data.summary;
                })
                .catch(error => {
                    console.error('Error:', error);
                    summaryContent.textContent = 'Failed to load summary.';
                });
            });

            closeModalBtn.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            selectAllCheckbox.addEventListener('change', function () {
                submissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
