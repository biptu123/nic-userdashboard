@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 shadow-2xl p-16 bg-gray-200 rounded-lg">
            <div>
                <h2 class=" text-center text-3xl font-extrabold text-gray-900">
                    Register
                </h2>
            </div>
            <form class="mt-8" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px flex flex-col gap-4">
                    {{-- Name Input --}}
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input id="name" name="name" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Name">

                        {{-- For error message --}}
                        <x-error-message field="name" class="mb-3" />

                    </div>

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address">

                        {{-- For error message --}}
                        <x-error-message field="email" class="mb-3" />
                    </div>

                    {{-- Phone no Input --}}
                    <div>
                        <label for="phone" class="sr-only">Phone Number</label>
                        <input id="phone" name="phone" type="tel" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Phone Number">

                        {{-- For error message --}}
                        <x-error-message field="phone" class="mb-3" />
                    </div>
                    {{-- Password Input --}}
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password">

                        {{-- For error message --}}
                        <x-error-message field="password" class="mb-3" />
                    </div>
                    {{-- Conf Password Input --}}
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm Password">

                        {{-- For error message --}}
                        <x-error-message field="password_confirmation" class="mb-3" />
                    </div>
                </div>

                <div class="mt-20">
                    <button type="submit"
                        class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-32 mx-auto">
                        Register
                    </button>
                </div>
                <div class="text-center mt-2">
                    <p class="text-sm text-gray-600">
                        Already have an account? <a href="{{ route('login') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection
