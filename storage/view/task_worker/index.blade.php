@extends('layouts.main')

@section('title', 'Worker Task')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Worker Task</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Worker Task</h1>
            <p class="text-sm text-gray-500">Complete assigned captcha tasks and track worker performance.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Console
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">

        <!-- Today's Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

                    <!-- Today's Completed -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Completed</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">{{ $completed_count }}</p>
                        <p class="text-xs text-gray-400 mt-1">Tasks finished today</p>
                    </div>

                    <!-- Today's Success Rate -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Accuracy Rate</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">{{ $success_rate }}%</p>
                        <p class="text-xs text-gray-400 mt-1">Today's accuracy</p>
                    </div>

                    <!-- Today's Income -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Income</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">${{ $task_income }}</p>
                        <p class="text-xs text-gray-400 mt-1">Earned today</p>
                    </div>

                    <!-- Current Balance -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M19 20H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2Z"/>
                                            <path fill="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16.5 14a.5.5 0 1 1 0-1a.5.5 0 0 1 0 1"/>
                                            <path d="M18 7V5.603a2 2 0 0 0-2.515-1.932l-11 2.933A2 2 0 0 0 3 8.537V9"/>
                                        </g>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Balance</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">${{ $wallet_task->balance }}</p>
                        <p class="text-xs text-gray-400 mt-1">Available to withdraw</p>
                    </div>

        </div>

        <!-- Workspace + Worker Tips -->
        <div class="grid grid-cols-1 gap-6">

            <!-- Workspace -->
            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Workspace</h2>
                </div>

                <div id="worker_task_app" class="relative min-h-[360px] w-full bg-white v-cloak">
                    <div class="absolute inset-0 flex items-center justify-center bg-white backdrop-blur-sm">
                        <div class="text-center py-12">
                            <svg class="animate-spin h-8 w-8 text-cyan-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Loading...</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Worker Tips -->
            <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Worker Tips</h2>
                </div>

                <div class="p-5 space-y-4">
                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">How to claim a task?</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Click <span class="font-medium text-cyan-600">Start</span> in the workspace to fetch a new captcha task. Tasks are auto-assigned based on availability.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Time limit</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Each task has a countdown. If you don't submit before time runs out, the task is auto-cancelled and may affect your success rate.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Earnings calculation</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Earnings are based on task type and difficulty. The amount is credited to your task balance after a successful submission is verified.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Success rate</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Wrong answers, timeouts, and frequent cancellations all reduce your success rate. Persistent low rates may limit how many tasks you can claim.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Workspace stuck or blank?</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Refresh the page. If the issue persists, check your internet connection or submit a ticket from the Support menu.</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
@push('scripts')
<link rel="stylesheet" crossorigin href="/assets/css/index-eZQt9ahK.css">
<script type="module" crossorigin src="/assets/js/index-g4vBKTXk.js"></script>
@endpush
