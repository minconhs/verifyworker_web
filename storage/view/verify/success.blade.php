@extends('layouts.main')

@section('title', 'Verification Complete')

@section('header')
    @parent
@endsection

@section('content')
    <section class="bg-white">
        <div class="mx-auto flex min-h-[calc(100vh-65px)] w-full max-w-7xl items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20m4.28 7.78l-5 5a.75.75 0 0 1-1.06 0l-2.5-2.5a.75.75 0 1 1 1.06-1.06l1.97 1.97l4.47-4.47a.75.75 0 0 1 1.06 1.06" />
                    </svg>
                </div>

                <h1 class="mt-6 text-3xl font-medium text-gray-900 sm:text-4xl">
                    Verification complete
                </h1>

                <p class="mx-auto mt-4 max-w-md text-base leading-7 text-gray-600">
                    {{ $message }}
                </p>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2" href="/auth/signin">
                        Sign In
                        <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7l-7 7" />
                        </svg>
                    </a>

                    <a class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:text-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2" href="/">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
@endsection
