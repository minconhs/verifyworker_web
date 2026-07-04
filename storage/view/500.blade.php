@extends('layouts.app')

@section('title', 'Server Error')

@section('header')
    @parent
@endsection

@section('content')
    <div class="bg-white min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <!-- Illustration -->
            <div class="relative mx-auto w-64 h-52 ">
                <!-- Broken gear icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-28 h-28 text-amber-400 animate-pulse" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="m12 3l10.22 17.7H1.78z"/><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="m12 3l10.22 17.7H1.78z"/><path stroke="currentColor" stroke-linecap="square" stroke-width="2" d="M12 10.5V14m0 3.5h.004v.004H12z"/></g></svg>
                </div>
                <!-- Lightning bolt overlay -->
                <div class="absolute top-6 right-12">
                    <svg class="w-10 h-10 text-amber-400 drop-shadow-sm animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z"/>
                    </svg>
                </div>
                <!-- Small floating dots -->
                <div class="absolute top-4 left-14 w-2 h-2 bg-cyan-500 rounded-full animate-pulse"></div>
                <div class="absolute bottom-8 right-10 w-3 h-3 bg-cyan-500 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                <div class="absolute top-12 left-8 w-1 h-1 bg-cyan-200 rounded-full animate-pulse" style="animation-delay: 1s"></div>
            </div>

            <!-- Description -->
            <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md mx-auto">
                {{ $message ?? 'Something went wrong on our end. Please try again later.' }}
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center mb-10">
                <a href="javascript:location.reload()"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-cyan-500 hover:bg-cyan-500/80 text-white font-semibold rounded transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-500/30 shadow-sm text-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Try Again
                </a>
                <a href="/"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded border border-gray-200 transition-all duration-200 text-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Back to Home
                </a>
                <a href="javascript:history.back()"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded border border-gray-200 transition-all duration-200 text-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Go Back
                </a>
            </div>

            <!-- Help Section -->
            <div class="border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-400">
                    Still having issues?
                    <a href="/ticket/create" class="text-cyan-600 hover:text-cyan-700 font-medium underline underline-offset-2 transition-colors">Submit a ticket</a>
                    or email us at
                    <a href="mailto:support@verifyworker.com" class="text-cyan-600 hover:text-blue-700 font-medium underline underline-offset-2 transition-colors">support@verifyworker.com</a>
                </p>
            </div>
        </div>
    </div>
@endsection