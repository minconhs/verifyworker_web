@extends('layouts.main')

@section('title', 'Setting')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Setting</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Setting</h1>
            <p class="text-sm text-gray-500">Manage account security, email preferences, and password settings.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Console
        </a>
    </div>
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="space-y-6">
        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif
        <!-- Account Settings Overview -->
        <section class="border border-gray-200 bg-white rounded-lg">
            <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-5 lg:divide-x lg:divide-y-0">
                <div class="p-5 lg:col-span-2">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2l4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622c5.176-1.332 9-6.03 9-11.622c0-1.042-.133-2.052-.382-3.016Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Security Score</p>
                                <div class="mt-1 flex items-baseline gap-2">
                                    <p class="text-3xl font-medium text-gray-900">{{ $security_score }}%</p>
                                    @if($security_score <= 25)
                                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">Low</span>
                                    @elseif($security_score <= 50)
                                        <span class="rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-700">Basic</span>
                                    @elseif($security_score <= 75)
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Good</span>
                                    @else
                                        <span class="rounded-full bg-cyan-500 px-2.5 py-1 text-xs font-medium text-white">Very Good</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                            @if($security_score <= 25)
                                <div class="h-full w-1/4 rounded-full bg-red-500"></div>
                            @elseif($security_score <= 50)
                                <div class="h-full w-1/2 rounded-full bg-orange-500"></div>
                            @elseif($security_score <= 75)
                                <div class="h-full w-3/4 rounded-full bg-amber-500"></div>
                            @else
                                <div class="h-full w-full rounded-full bg-cyan-500"></div>
                            @endif
                        </div>
                        <div class="mt-3 grid grid-cols-4 gap-1 text-[11px] font-medium text-gray-400">
                            <span>Low</span>
                            <span class="text-center">Basic</span>
                            <span class="text-center">Good</span>
                            <span class="text-right">Strong</span>
                        </div>
                    </div>

                    @if($security_score < 100)
                        <p class="mt-4 text-sm text-gray-500">Complete the remaining security items to strengthen account protection.</p>
                    @else
                        <p class="mt-4 text-sm text-gray-500">Your account protection is complete and all key security checks are active.</p>
                    @endif
                </div>

                <div class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Login Password</p>
                    <p class="mt-2 text-sm font-medium text-gray-900">Enabled</p>
                    <p class="mt-1 text-xs text-gray-500">Required for sign-in and sensitive changes.</p>
                </div>

                <div class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Payment Password</p>
                    <p class="mt-2 text-sm font-medium text-gray-900">Enabled</p>
                    <p class="mt-1 text-xs text-gray-500">Required for withdrawals and transfers.</p>
                </div>

                <div class="p-5">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Email Status</p>
                    @if($member->is_email_verified)
                        <p class="mt-2 text-sm font-medium text-emerald-700">Verified</p>
                    @else
                        <p class="mt-2 text-sm font-medium text-red-700">Not Verified</p>
                    @endif
                    <p class="mt-1 text-xs text-gray-500">Account status: {{ $member->status ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>
        </section>

        <section class="border border-gray-200 bg-white rounded-lg">
            <div class="scrollbar-hide overflow-x-auto px-5">
                <nav class="flex min-w-max gap-2 py-3" aria-label="Settings tabs">
                    <a href="/settings/email" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $tab === 'email' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        <svg class="h-4 w-4 {{ $tab === 'email' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/>
                        </svg>
                        Change Email
                    </a>
                    <a href="/settings/password" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $tab === 'password' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        <svg class="h-4 w-4 {{ $tab === 'password' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 0 0-8 0v4m-2 0h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2Z"/>
                        </svg>
                        Change Password
                    </a>
                    <a href="/settings/payment-password" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $tab === 'payment-password' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        <svg class="h-4 w-4 {{ $tab === 'payment-password' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm12 8h.01"/>
                        </svg>
                        Payment Password
                    </a>
                    <a href="/settings/notice" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $tab === 'notice' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        <svg class="h-4 w-4 {{ $tab === 'notice' ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        Notification
                    </a>
                </nav>
            </div>
        </section>

        <section>
            @yield('main')
        </section>
    </div>
@endsection
