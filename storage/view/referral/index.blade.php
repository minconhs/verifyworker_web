@extends('layouts.main')

@section('title', 'Referral Program')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Referral Program</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Referral Program</h1>
            <p class="text-sm text-gray-500">Invite users, copy referral details, and track referral earnings.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Console
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="grid gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-4-4h-1M7 20H2v-2a4 4 0 0 1 4-4h1m8 6v-2a4 4 0 0 0-8 0v2m8-11a3 3 0 1 1 6 0a3 3 0 0 1-6 0ZM6 9a3 3 0 1 1 6 0a3 3 0 0 1-6 0Z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Total Referrals</span>
                    </div>
                    <p class="text-2xl font-medium text-gray-900">{{ $referral_count }}</p>
                    <p class="mt-1 text-xs text-gray-400">Successful invited users</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m3-9.5A3.5 3.5 0 0 0 12 7c-1.657 0-3 .895-3 2s1.343 2 3 2s3 .895 3 2s-1.343 2-3 2a3.5 3.5 0 0 1-3-1.5M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Total Earnings</span>
                    </div>
                    <p class="text-2xl font-medium text-gray-900">$ {{ $referral_earnings }}</p>
                    <p class="mt-1 text-xs text-gray-400">Commission credited</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h4m-6 4h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Zm12-6l1.5 1.5L21 11"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">First Payment</span>
                    </div>
                    <p class="text-2xl font-medium text-gray-900">15%</p>
                    <p class="mt-1 text-xs text-gray-400">First payment commission</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V9m4 8V5m4 12v-6M5 17v-4m-2 6h18"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Task Revenue</span>
                    </div>
                    <p class="text-2xl font-medium text-gray-900">10%</p>
                    <p class="mt-1 text-xs text-gray-400">Revenue sharing rate</p>
                </div>
        </div>

        <section class="grid gap-6 lg:grid-cols-[minmax(0,1.5fr)_minmax(320px,0.9fr)]">
            <div class="rounded-lg border border-gray-200 bg-white">
                <div class="border-b border-gray-100 px-5 py-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H15a3 3 0 0 1 0 6h-1.5M10.5 12H9a3 3 0 0 1 0-6h1.5m-1 12H8a3 3 0 0 1 0-6h2.5m3 0H16a3 3 0 0 1 0 6h-2.5M8 12h8"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-medium text-gray-900">Invite Details</h2>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 p-5">
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="mb-3 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-cyan-600">Referral Code</p>
                                <p class="mt-1 text-sm text-gray-500">For users who enter a code manually.</p>
                            </div>
                            <a onclick="navigator.clipboard.writeText('{{ $referral_code }}');" class="text-sm font-medium text-cyan-600 transition-colors hover:text-cyan-700 cursor-pointer">Copy</a>
                        </div>
                        <p class="break-all font-mono text-sm font-medium tracking-wide text-gray-900">{{ $referral_code }}</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="mb-3 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-cyan-600">Referral Link</p>
                                <p class="mt-1 text-sm text-gray-500">Best for messages and social sharing.</p>
                            </div>
                            <a onclick="navigator.clipboard.writeText('{{ $referral_link }}');" class="text-sm font-medium text-cyan-600 transition-colors hover:text-cyan-700 cursor-pointer">Copy</a>
                        </div>
                        <p class="break-all font-mono text-sm leading-6 text-gray-800">{{ $referral_link }}</p>
                    </div>


                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">How It Works</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    <div class="px-5 py-4">
                        <p class="text-sm font-medium text-gray-900">1. Share the invite</p>
                        <p class="mt-1 text-sm text-gray-500">Send your referral link, or ask the user to enter your referral code during sign up.</p>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-sm font-medium text-gray-900">2. Friend creates an account</p>
                        <p class="mt-1 text-sm text-gray-500">The referral relationship is linked after successful registration.</p>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-sm font-medium text-gray-900">3. Commission is credited</p>
                        <p class="mt-1 text-sm text-gray-500">Eligible payments and task revenue generate commission records below.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <g fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="14" height="17" x="5" y="4" rx="2" />
                                <path stroke-linecap="round" d="M9 9h6m-6 4h6m-6 4h4" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-950">Referral Earnings</h3>
                        <p class="mt-1 text-xs text-gray-500">Recent balance changes across your wallets</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="/referral/records" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-950">
                        View All
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Order Number</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Referred User</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Email</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $item->fromMember->username }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $item->fromMember->email }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">${{ $item->amount }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-sm text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No referral earnings yet</p>
                                    <p class="mt-1 text-sm text-gray-500">Share your referral link to start earning commissions.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
