@props(['field'])

@session($field)
   <div class="bg-green-200 border-green-400 border-l-4 text-green-700 p-4 my-4">
        <div class="flex items-center">
            <div class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-1a7 7 0 100-14 7 7 0 000 14zm0-9a1 1 0 011 1v4a1 1 0 11-2 0V9a1 1 0 011-1zm0-4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                {{ session($field) }}
            </div>
        </div>
    </div>
@endsession