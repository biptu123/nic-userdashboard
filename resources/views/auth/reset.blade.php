<!-- resources/views/auth/reset-password.blade.php -->

@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 shadow-2xl p-16 bg-blue-100 rounded-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Reset Password
                </h2>

                {{-- Failed Message --}}
                <x-error-message field="error" class="text-center text-3xl font-extrabold" />
                {{-- Success Message --}}
                <x-success-message field="success" class="text-center text-3xl font-extrabold" />
            </div>

            <form class="mt-8" action="{{ route('reset') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ request('email') }}">
                <input type="hidden" name="token" value="{{ request('token') }}">

                <div class="rounded-md shadow-sm -space-y-px flex flex-col gap-2">
                    {{-- Password Input --}}
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password">
                        {{-- Error Message --}}
                        <x-error-message field="password" class="mb-3" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm Password">
                        {{-- Error Message --}}
                        <x-error-message field="password_confirmation" class="mb-3" />
                    </div>
                </div>

                <div class="mt-20">
                    <button type="submit"
                        class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-32 mx-auto">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
