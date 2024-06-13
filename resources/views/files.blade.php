@extends('layouts.dashboard')

@section('title', 'Dashboard - Files')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-full w-full">
        <div class="w-full mx-auto  rounded-lg overflow-hidden ">
            <div class="md:flex w-full">
                <div class="w-full p-4 ">
                    <h2 class="text-center text-3xl font-extrabold text-gray-900 mb-4">
                        My Uploaded Files
                    </h2>

                    {{-- Error Update --}}
                    <x-error-message field="error" class="text-center text-3xl font-extrabold" />

                    {{-- Success Update --}}
                    <x-success-message field="success" class="text-center text-3xl font-extrabold" />


                    {{-- Files Table --}}
                    <div class="overflow-x-auto w-full  shadow-xl rounded-sm">
                        <table class="min-w-full divide-y divide-gray-200 bg-red-900">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        File Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Uploaded At</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th> {{-- Add Actions column --}}
                                </tr>
                            </thead>
                            {{-- List Of all files --}}
                            <tbody class="bg-white divide-y divide-gray-200 w-full">
                                @forelse ($files as $file)
                                    <tr class="w-full">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-grey-600 hover:text-grey-900">{{ $file->filename }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $file->created_at->format('d M Y, H:i') }}</td>

                                        {{-- Actions --}}
                                        <td class="pl-auto py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{-- View --}}
                                            <a href="{{ route('view', $file->id) }}"
                                                class="text-green-600 hover:text-green-900 mr-2 font-extrabold">View</a>
                                            {{-- Download --}}
                                            <a href="{{ asset('storage/' . $file->filepath) }}" target="_blank"
                                                class="text-blue-500 hover:text-blue-900 mr-2 font-extrabold">Download</a>
                                            {{-- Delete --}}
                                            <form action="{{ route('delete', $file->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 font-extrabold">Delete</button>
                                            </form>
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
                </div>
            </div>
        </div>
    </div>
@endsection
