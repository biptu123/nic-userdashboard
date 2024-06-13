@props(['field'])
{{-- If its an Session Error --}}
@session($field)
    <div class="bg-red-200 border-red-400 border-l-4 text-red-700 p-4 my-4">
        <div class="flex items-center">
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-1a7 7 0 100-14 7 7 0 000 14zm0-9a1 1 0 011 1v4a1 1 0 11-2 0V9a1 1 0 011-1zm0-4a1 1 0 100-2 1 1 0 000 2z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                {{ session($field) }}
            </div>
        </div>
    </div>
@endsession

{{-- If its an Validation Error --}}
@error($field)
    <div class="bg-red-200 border-red-400 border-l-4 text-red-700 p-4">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="h-4 w-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856a2 2 0 0 0 1.789-2.895l-6.947-13a2 2 0 0 0-3.578 0l-6.947 13A2 2 0 0 0 5.062 17z" />
            </svg>
            <span>{{ $message }}</span>
        </div>
    </div>
@enderror
