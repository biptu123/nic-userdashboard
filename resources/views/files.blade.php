@extends('layouts.dashboard')

@section('title', 'Dashboard - Files')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen w-full">
        <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">
            My&nbsp; Uploaded&nbsp; Files
        </h2>

        {{-- Error Update --}}
        <x-error-message field="error" class="text-center text-3xl font-extrabold" />

        {{-- Success Update --}}
        <x-success-message field="success" class="text-center text-3xl font-extrabold" />

        {{-- Search bar --}}
        <div class="flex items-center justify-between mt-5 mb-3">
            <input id="search-input" type="text" class="form-control w-full md:w-1/2 p-4 rounded-lg"
                placeholder="Search files by name or date" name="search" />

        </div>

        {{-- Files Table --}}
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        File Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Uploaded At</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    </th> {{-- Add Actions column --}}
                </tr>
            </thead>
            {{-- List Of all files --}}
            <tbody id="files-tbody" class="bg-white divide-y divide-gray-200 w-full">
                @forelse ($files as $file)
                    <tr class="w-full file-row" data-filename="{{ $file->filename }}"
                        data-uploaded-at="{{ $file->created_at->format('d M Y, H:i') }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-grey-600 hover:text-grey-900">{{ $file->filename }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $file->created_at->format('d M Y, H:i') }}</td>

                        {{-- Actions --}}
                        <td class="pl-auto py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)"
                                    class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="5"
                                            d="M12 6v.01M12 12v.01M12 18v.01" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute dropdown-menu hidden origin-top-right right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="options-menu">
                                        <a href="{{ route('view', $file->id) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">View</a>
                                        <a href="{{ asset('storage/' . $file->filepath) }}" target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">Download</a>
                                        <form action="{{ route('delete', $file->id) }}" method="POST"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- If there is no file --}}
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center">No files uploaded
                            yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('search-input').addEventListener('input', function(event) {
            const searchTerm = event.target.value.toLowerCase();
            const rows = document.querySelectorAll('.file-row');

            rows.forEach(row => {
                const filename = row.getAttribute('data-filename').toLowerCase();
                const uploadedAt = row.getAttribute('data-uploaded-at').toLowerCase();

                if (filename.includes(searchTerm) || uploadedAt.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function toggleDropdown(button) {
            var dropdown = button.nextElementSibling;
            var isHidden = dropdown.classList.contains('hidden');

            // Close all dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.add('hidden');
                menu.classList.remove('block');
            });

            // Toggle the clicked dropdown
            if (isHidden) {
                dropdown.classList.remove('hidden');
                dropdown.classList.add('block');
            } else {
                dropdown.classList.add('hidden');
                dropdown.classList.remove('block');
            }
        }

        document.addEventListener('click', function(event) {
            var isClickInside = event.target.closest('.relative');
            if (!isClickInside) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('block');
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
