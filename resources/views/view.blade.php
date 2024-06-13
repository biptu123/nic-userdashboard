@extends('layouts.dashboard')

@section('title', 'View File')

@section('content')
    <div class="container mx-auto ">
        <div class=" mx-auto bg-white rounded-lg overflow-hidden">
            <div class="md:flex">
                <div class="w-full p-4">
                    <div class="bg-gray-200 py-5 px-4 rounded-lg">
                        <h2 class="text-center text-3xl font-extrabold text-gray-900 mb-4">
                            File Details
                        </h2>

                        {{-- Display File Details --}}
                        <h2 id="file-name" class="text-lg text-gray-900">
                            File Name: {{ $file->filename }}
                        </h2>
                        <h2 id="file-path" class="text-lg text-gray-900">
                            File Path:
                            @php
                                $filePathParts = explode('/', $file->filepath);
                                echo array_pop($filePathParts);
                            @endphp
                        </h2>
                    </div>
                    <div id="file-details" class="mt-4 p-4 border border-gray-300 rounded-md bg-gray-50 w-full ">
                        <div class="overflow-x-auto overflow-y-auto">
                            <table id="file-content" class="min-w-full divide-y divide-gray-200 mt-4 hidden">
                                <thead id="file-header"></thead>
                                <tbody id="file-content-body" class="bg-white divide-y divide-gray-200">
                                    <!-- File details will be displayed here -->
                                </tbody>
                            </table>
                            <div id="pagination" class="mt-4 flex justify-center">
                                <!-- Pagination controls will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show Excel file details with pagination
        async function showFileDetails(filePath) {
            const response = await fetch(filePath);
            if (!response.ok) {
                console.error('Failed to fetch the file');
                return;
            }

            const fileData = await response.arrayBuffer();
            const workbook = XLSX.read(fileData, {
                type: 'array'
            });
            const firstSheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[firstSheetName];
            const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                header: 1
            });

            document.getElementById('file-details').classList.remove('hidden');

            // Set up pagination variables
            const rowsPerPage = 11;
            let currentPage = 1;
            const totalPages = Math.ceil(jsonData.length / rowsPerPage);

            function displayPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = jsonData.slice(start, end);

                const tableBody = document.getElementById('file-content-body');
                tableBody.innerHTML = '';
                pageData.forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.textContent = cell;
                        td.classList.add('px-4', 'py-4', 'whitespace-wrap', 'text-sm', 'text-gray-500');
                        tr.appendChild(td);
                    });
                    tableBody.appendChild(tr);
                });

                document.getElementById('file-content').classList.remove('hidden');
            }

            function updatePagination() {
                const paginationDiv = document.getElementById('pagination');
                paginationDiv.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.classList.add('px-3', 'py-1', 'mx-1', 'text-sm', 'bg-blue-500', 'text-white', 'rounded');
                    if (i === currentPage) {
                        pageButton.classList.add('bg-blue-700');
                    }
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        displayPage(currentPage);
                        updatePagination();
                    });
                    paginationDiv.appendChild(pageButton);
                }
            }

            // Initialize the first page and pagination controls
            displayPage(currentPage);
            updatePagination();
        }

        showFileDetails('{{ asset('storage/' . $file->filepath) }}');
    </script>
@endsection
