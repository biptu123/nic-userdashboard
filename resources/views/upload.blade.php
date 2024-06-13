@extends('layouts.dashboard')

@section('title', 'Dashboard - Upload')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 ">
        <div class="max-w-7xl mx-auto bg-blue-100 rounded-lg overflow-hidden  shadow-2xl p-5">
            <div class="p-4 ">
                <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">
                    Upload&nbsp; Excel File
                </h2>


                {{-- Error Update --}}
                <x-error-message field="error" class="text-center text-3xl font-extrabold" />

                {{-- Success Update --}}
                <x-success-message field="success" class="text-center text-3xl font-extrabold" />


                <form class="space-y-6" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="rounded-md shadow-sm -space-y-px flex flex-col gap-2">
                        <div>
                            <label for="name" class="sr-only">File Name</label>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="appearance-none relative block w-full px-3 py-3 border border-gray-300 bg-gray-100 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="File Name">
                            {{-- Error Message --}}
                            <x-error-message field="name" class="mb-3" />
                        </div>
                        <div class="relative">
                            <input id="file" name="file" type="file" accept=".xlsx,.xls"
                                class="absolute inset-0 opacity-0 cursor-pointer" onchange="showFilePreview(event)" hidden>
                            <div for="file" id="drop-area"
                                class="border border-gray-900 border-dashed rounded-md mt-2 text-center flex bg-gray-200 hover:bg-gray-300 transition-all">
                                <label for= 'file'
                                    class="text-gray-600 w-full py-10  cursor-pointer flex flex-col items-center gap-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1" stroke="currentColor" class="size-20 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    <span>Drag and drop your
                                        file here, or click to select</span>
                                </label>
                            </div>

                            {{-- Error message --}}
                            <x-error-message field="file" />
                        </div>
                        <div class="w-full hidden border border-gray-900  text-gray-900 bg-gray-100  rounded-md  px-3 py-2">
                            <p id="uploaded" class=" sm:text-sm" placeholder="File Name">

                            </p>
                            <button class="text-red-600 hover:text-red-900 font-extrabold ml-auto" type="button"
                                onclick = "handledelete()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </button>
                        </div>

                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-15 mx-auto flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>



        {{-- File Preview --}}
        <div id="file-preview"
            class="mt-4 p-4 border border-gray-300 rounded-md bg-gray-50 hidden max-w-7xl max-h-1xl mx-auto  shadow-2xl">
            <div class="bg-gray-200 py-5 px-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-700">File Preview</h3>
                <p id="file-name" class="text-sm text-gray-500"></p>
                <p id="file-type" class="text-sm text-gray-500"></p>
            </div>
            <div class="overflow-x-auto overflow-y-auto">
                <table id="file-content" class="min-w-full divide-y divide-gray-200 mt-4 hidden">
                    <tbody id="file-content-body" class="bg-white divide-y divide-gray-200">
                        <!--Preview Content will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function handledelete() {
            document.getElementById("file").value = null;
            document.getElementById('uploaded').parentNode.classList.remove('flex');
            document.getElementById('uploaded').parentNode.classList.add('hidden');
            document.getElementById('file-preview').classList.add('hidden');
        }


        // Getting the drop area
        const dropArea = document.getElementById('drop-area');

        // for preventing default behavior
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Adding event listner for mouse drop
        dropArea.addEventListener('drop', handleDrop, false);

        // For handling file drop
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            handleFiles(files);
        }

        document.getElementById('file').addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        // handle drop file
        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                document.getElementById('file-preview').classList.remove('hidden');
                document.getElementById('file-name').textContent = `File Name: ${file.name}`;
                document.getElementById('file-type').textContent = `File Type: ${file.type || 'Unknown'}`;

                document.getElementById('uploaded').parentNode.classList.remove('hidden');
                document.getElementById('uploaded').parentNode.classList.add('flex');

                document.getElementById('uploaded').innerText = file.name;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const firstSheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[firstSheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                        header: 1
                    });

                    // Display the first few rows of the Excel file
                    const tableBody = document.getElementById('file-content-body');
                    tableBody.innerHTML = ''; // Clear previous content
                    jsonData.slice(0, 20).forEach((row, index) => { // Limiting to first 5 rows for preview
                        const tr = document.createElement('tr');
                        row.forEach(cell => {
                            const td = document.createElement('td');
                            td.textContent = cell;
                            td.classList.add('px-2', 'py-4', 'whitespace-wrap', 'text-sm',
                                'text-gray-500');
                            tr.appendChild(td);
                        });
                        tableBody.appendChild(tr);
                    });

                    document.getElementById('file-content').classList.remove('hidden');
                };
                reader.readAsArrayBuffer(file);
            }
        }
    </script>
@endsection
