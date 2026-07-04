@extends('layouts.app')

@section('title', 'Forbidden')

@section('header')
    @parent
@endsection

@section('content')
    <div class="bg-white min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <!-- Illustration -->
            <div class="relative mx-auto w-64 h-52">
                <!-- Lock shield icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-28 h-28 text-rose-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <!-- Forbidden slash overlay -->
                <div class="absolute top-6 right-12">
                    <svg class="w-10 h-10 text-rose-400 drop-shadow-sm animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <!-- Small floating dots -->
                <div class="absolute top-4 left-14 w-2 h-2 bg-cyan-500 rounded-full animate-pulse"></div>
                <div class="absolute bottom-8 right-10 w-3 h-3 bg-cyan-500 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                <div class="absolute top-12 left-8 w-1 h-1 bg-cyan-200 rounded-full animate-pulse" style="animation-delay: 1s"></div>
            </div>

            <!-- Description -->
            <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md mx-auto">
                {{ $message ?? "You don't have permission to access this resource." }}
            </p>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
