@extends('layouts.dashboard')

@section('title', 'Dashboard - Files')

@section('content')
    <div class="container mx-auto  px-1 sm:px-6 lg:px-8 min-h-screen w-full h-fit overflow-x-auto pt-12"
        style="padding-bottom: 150px;">
        <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">
            My&nbsp; Uploaded&nbsp; Files
        </h2>

        {{-- Error Update --}}
        <x-error-message field="error" class="text-center text-3xl font-extrabold" />

        {{-- Success Update --}}
        <x-success-message field="success" class="text-center text-3xl font-extrabold" />

        {{-- Search bar --}}
        <div class="relative flex flex-col md:flex-row items-center justify-between mt-5 mb-10 gap-2 ">
            <input id="search-input" type="text" class=" form-control w-full md:w-1/3 py-2 pl-10 pr-4 rounded-lg shadow-lg"
                placeholder="Search files by name or date" name="search" />
            <div class="absolute top-0 left-0 h-10 aspect-square flex content-center items-center p-2 ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-6">
                    <path fill="#8c8c8c"
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg>
            </div>


            <div class="flex space-x-2">
                <button id="table-view-button" class="p-2 bg-blue-500 text-white rounded">Table View</button>
                <button id="card-view-button" class="p-2 bg-blue-500 text-white rounded">Card View</button>
            </div>
        </div>

        {{-- Files Table --}}
        <div id="table-view" class="min-w-full divide-y divide-gray-200">
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
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                role="menuitem">
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

        {{-- Files Card View --}}
        <div id="card-view" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($files as $file)
                <div class="file-card border p-4 rounded-lg shadow-sm bg-gray-50" data-filename="{{ $file->filename }}"
                    data-uploaded-at="{{ $file->created_at->format('d M Y, H:i') }}">
                    <p class="text-grey-600 hover:text-grey-900">{{ $file->filename }}</p>
                    <p class="text-sm text-gray-500">{{ $file->created_at->format('d M Y, H:i') }}</p>
                    <div class="flex space-x-2 mt-2 justify-end">
                        <div class="relative inline-block text-left mt-2">
                            <button onclick="toggleDropdown(this)"
                                class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
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
                    </div>
                </div>
            @empty
                <p class="text-center w-full col-span-full">No files uploaded yet.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.getElementById('search-input').addEventListener('input', function(event) {
            const searchTerm = event.target.value.toLowerCase();
            const rows = document.querySelectorAll('.file-row');
            const cards = document.querySelectorAll('.file-card');

            rows.forEach(row => {
                const filename = row.getAttribute('data-filename').toLowerCase();
                const uploadedAt = row.getAttribute('data-uploaded-at').toLowerCase();

                if (filename.includes(searchTerm) || uploadedAt.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            cards.forEach(card => {
                const filename = card.getAttribute('data-filename').toLowerCase();
                const uploadedAt = card.getAttribute('data-uploaded-at').toLowerCase();

                if (filename.includes(searchTerm) || uploadedAt.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        document.getElementById('table-view-button').addEventListener('click', function() {
            document.getElementById('table-view').classList.remove('hidden');
            document.getElementById('card-view').classList.add('hidden');
        });

        document.getElementById('card-view-button').addEventListener('click', function() {
            document.getElementById('table-view').classList.add('hidden');
            document.getElementById('card-view').classList.remove('hidden');
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
