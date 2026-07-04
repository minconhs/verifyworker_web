@extends('layouts.main')

@section('title', 'Verification Failed')

@section('header')
    @parent
@endsection

@section('content')
    <section class="bg-white">
        <div class="mx-auto flex min-h-[calc(100vh-65px)] w-full max-w-7xl items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20m3.53 12.47a.75.75 0 1 1-1.06 1.06L12 13.06l-2.47 2.47a.75.75 0 0 1-1.06-1.06L10.94 12L8.47 9.53a.75.75 0 0 1 1.06-1.06L12 10.94l2.47-2.47a.75.75 0 1 1 1.06 1.06L13.06 12z" />
                    </svg>
                </div>

                <h1 class="mt-6 text-3xl font-medium text-gray-900 sm:text-4xl">
                    This verification link is invalid
                </h1>

                <p class="mx-auto mt-4 max-w-md text-base leading-7 text-gray-600">
                    The link may have expired, already been used, or been opened from an incomplete address.
                </p>

                <div class="mt-6 rounded-lg border border-red-100 bg-red-50 px-4 py-3 text-sm leading-6 text-red-700">
                    {{ $message }}
                </div>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2" href="/">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M6 19h3v-5q0-.425.288-.712T10 13h4q.425 0 .713.288T15 14v5h3v-9l-6-4.5L6 10zm-2 0v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4q-.425 0-.712-.288T13 20v-5h-2v5q0 .425-.288.713T10 21H6q-.825 0-1.412-.587T4 19" />
                        </svg>
                        Back to Home
                    </a>

                    <a class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:text-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2" href="/auth/signin">
                        Sign In
                        <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7l-7 7" />
                        </svg>
                    </a>
                </div>

                <p class="mt-6 text-xs leading-5 text-gray-400">
                    If you requested a new verification email, use the most recent link from your inbox.
                </p>
            </div>
        </div>
    </section>
@endsection

@section('footer')
@endsection
