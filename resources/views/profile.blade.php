@extends('layouts.dashboard')

@section('title', 'Dashboard - Profile')

@section('content')
    <div class="h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 shadow-2xl p-16 bg-gray-200 rounded-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    My Profile
                </h2>

                {{-- Failed Update --}}
                <x-error-message field="error" class="text-center text-3xl font-extrabold" />

                {{-- Success Update --}}
                <x-success-message field="success" class="text-center text-3xl font-extrabold" />
            </div>

            <form class="mt-8 space-y-6" action="{{ route('profile') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px flex flex-col gap-2">
                    <div>
                        <label for="name" class="sr-only">Name address</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Name" value="{{ auth()->user()->name }}">
                        {{-- Error Message --}}
                        <x-error-message field="name" class="mb-3" />
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address" value="{{ auth()->user()->email }}" readonly>
                        {{-- Error Message --}}
                        <x-error-message field="email" class="mb-3" />
                    </div>
                    <div>
                        <label for="phone" class="sr-only">Phone Number</label>
                        <input id="phone" name="phone" type="text" autocomplete="phone" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Phone number" value="{{ auth()->user()->phone }}">
                        {{-- Error Message --}}
                        <x-error-message field="phone" class="mb-3" />
                    </div>

                    <div>
                        {{-- Helper Text --}}
                        <p class="text-xs text-yellow-600 my-2 mx-2">Leave blank if you don't want to change your password
                        </p>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="text" autocomplete="password"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password">
                        {{-- Error Message --}}
                        <x-error-message field="password" class="mb-3" />
                    </div>

                </div>

                <div>
                    <button type="submit"
                        class="group relative w-15 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mx-auto">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
