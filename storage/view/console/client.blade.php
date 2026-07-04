@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-5">
        <section class="overflow-hidden rounded-lg border border-slate-800 bg-slate-950 shadow-sm">
            <a href="/wallet/deposits" class="group relative block min-h-[166px] cursor-pointer px-5 py-5 text-white sm:min-h-[184px] sm:px-7 sm:py-6">
                <div class="absolute inset-0" style="background: radial-gradient(circle at 78% 30%, rgba(245,158,11,.28), transparent 30%), radial-gradient(circle at 18% 0%, rgba(6,182,212,.28), transparent 34%), linear-gradient(118deg, #020617 0%, #0f172a 47%, #164e63 100%);"></div>
                <div class="absolute inset-y-0 right-0 hidden w-1/2 sm:block" style="background-image: linear-gradient(90deg, rgba(255,255,255,.09) 1px, transparent 1px), linear-gradient(0deg, rgba(255,255,255,.08) 1px, transparent 1px); background-size: 24px 24px; mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.22) 24%, #000 100%); -webkit-mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.22) 24%, #000 100%);"></div>
                <div class="absolute -bottom-16 left-8 hidden h-32 w-32 rounded-full border border-cyan-300/15 sm:block"></div>
                <div class="absolute right-0 top-0 h-full w-20 bg-gradient-to-b from-amber-300/20 via-transparent to-cyan-300/20"></div>

                <div class="relative z-10 flex min-h-[126px] flex-col justify-between gap-5 sm:min-h-[138px] sm:flex-row sm:items-center">
                    <div class="max-w-xl">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="rounded bg-amber-300 px-2.5 py-1 text-xs font-medium uppercase tracking-wide text-slate-950">Recharge Event</span>
                            <span class="rounded border border-white/15 bg-white/10 px-2.5 py-1 text-xs font-medium text-cyan-100">Double bonus</span>
                        </div>
                        <h2 class="text-2xl font-medium tracking-normal text-white sm:text-3xl">Double Recharge Rewards</h2>
                        <p class="mt-2 max-w-lg text-sm leading-6 text-slate-300">Recharge your client balance and receive matched bonus credits for task spending.</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-medium text-cyan-200 transition-colors duration-200 group-hover:text-white motion-reduce:transition-none">
                            Recharge now
                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5 motion-reduce:transition-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-5-5 5 5-5 5"/>
                            </svg>
                        </span>
                    </div>

                    <div class="relative flex shrink-0 items-center justify-end sm:w-[260px]">
                        <div class="absolute -left-3 top-1/2 hidden h-20 w-20 -translate-y-1/2 rounded-full bg-cyan-400/15 blur-2xl sm:block"></div>
                        <div class="relative w-full max-w-[238px] rounded-lg border border-white/15 bg-white/[.08] p-4 shadow-2xl shadow-cyan-950/40 backdrop-blur">
                            <div class="absolute -left-2 top-1/2 h-4 w-4 -translate-y-1/2 rounded-full bg-slate-950"></div>
                            <div class="absolute -right-2 top-1/2 h-4 w-4 -translate-y-1/2 rounded-full bg-slate-950"></div>
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-400">Bonus multiplier</p>
                                    <p class="mt-1 text-5xl font-semibold leading-none text-amber-300">2X</p>
                                </div>
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-300/15 text-cyan-200">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3Z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-3">
                                <span class="text-xs text-slate-400">Client balance</span>
                                <span class="text-xs font-medium text-cyan-100">Bonus credits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </section>

        <section class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm12 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">Available</span>
                </div>
                <p class="text-xs text-gray-500">Balance</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $wallet_recharge->balance }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">This month</span>
                </div>
                <p class="text-xs text-gray-500">Spending</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $monet_expend }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 13 4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">This month</span>
                </div>
                <p class="text-xs text-gray-500">Tasks Completed</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">{{ $completed_count }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2Zm0 0V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-400">Healthy</span>
                </div>
                <p class="text-xs text-gray-500">Success Rate</p>
                <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">{{ $success_rate }}%</p>
            </div>
        </section>

        <section>
            <div class="mb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-sm font-medium uppercase tracking-wide text-gray-700">Quick Actions</h2>
                    <p class="mt-1 text-xs text-gray-500">Jump to common client workflows</p>
                </div>
                <div class="inline-flex w-full rounded-lg border border-gray-200 bg-white p-1 sm:w-auto">
                    <a href="/member/switch_platform?platform=client" class="flex-1 rounded-md bg-gray-100 px-4 py-1.5 text-center text-sm text-gray-900 sm:flex-none">Client</a>
                    <a href="/member/switch_platform?platform=worker" class="flex-1 rounded-md px-4 py-1.5 text-center text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-900 sm:flex-none">Worker</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-7">
                <a href="/task/client" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5h6M9 3h6a2 2 0 0 1 2 2v1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a2 2 0 0 1 2-2Zm1 10 2 2 4-5"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Task</p>
                </a>

                <a href="/wallet/deposits" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm7 7v4m-2-2h4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Deposits</p>
                </a>

                <a href="/wallet" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2Zm0-7h-4a2 2 0 0 0 0 4h4M18 7V5.6a2 2 0 0 0-2.5-1.93L5 6.47"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Wallet</p>
                </a>

                <a href="/secret" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 0 1 2 2m4 0a6 6 0 0 1-7.7 5.7L11 17H9v2H7v2H4a1 1 0 0 1-1-1v-2.6a1 1 0 0 1 .3-.7l6-6A6 6 0 1 1 21 9Z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Api Secret</p>
                </a>

                <a href="/referral" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-2a3 3 0 1 0 0-6M2 21a6 6 0 0 1 12 0M14 17a5 5 0 0 1 8 4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Referral</p>
                </a>

                <a href="/settings" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.3 4.3c.4-1.7 2.9-1.7 3.4 0a1.7 1.7 0 0 0 2.5 1.1c1.5-.9 3.3.8 2.4 2.4a1.7 1.7 0 0 0 1.1 2.5c1.7.4 1.7 2.9 0 3.4a1.7 1.7 0 0 0-1.1 2.5c.9 1.5-.8 3.3-2.4 2.4a1.7 1.7 0 0 0-2.5 1.1c-.4 1.7-2.9 1.7-3.4 0a1.7 1.7 0 0 0-2.5-1.1c-1.5.9-3.3-.8-2.4-2.4a1.7 1.7 0 0 0-1.1-2.5c-1.7-.4-1.7-2.9 0-3.4a1.7 1.7 0 0 0 1.1-2.5c-.9-1.5.8-3.3 2.4-2.4a1.7 1.7 0 0 0 2.5-1.1ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Setting</p>
                </a>

                <a href="/ticket" class="group rounded-lg border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-200 hover:border-blue-200 hover:shadow-md motion-reduce:transition-none">
                    <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-cyan-600 transition-colors group-hover:bg-blue-100">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m-9 6 3-3h9a4 4 0 0 0 4-4V7a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v13Z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-900">Support</p>
                </a>
            </div>
        </section>

        <section>
            <div class="mb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-sm font-medium uppercase tracking-wide text-gray-700">Worker Task Overview</h2>
                    <p class="mt-1 text-xs text-gray-500">Daily client task statistics over the past 7 days</p>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-950">Task Trend</p>
                        <p class="mt-1 text-xs text-gray-500">Completed, canceled, and failed task movement</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                        <span class="inline-flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-cyan-600"></span>Completed</span>
                        <span class="inline-flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-amber-500"></span>Cancel</span>
                        <span class="inline-flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-rose-500"></span>Failed</span>
                    </div>
                </div>
                <div class="chart-container h-[260px] w-full p-4 sm:h-[300px]" style="position: relative;">
                    <canvas id="clientTaskChart" class="h-full w-full"></canvas>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                <h3 class="text-sm font-medium text-gray-950">Login Logs</h3>
                <p class="mt-1 text-xs text-gray-500">Your recent login activities</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">IP Address</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Location</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Device</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Login Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $log)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 text-sm font-mono text-gray-700">{{ $log->ip_address }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $log->location }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $log->browser }} / {{ $log->system_os }}</td>
                            <td class="px-5 py-4 text-sm">
                                @if($log->status)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Successful</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $log->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $log->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No login records</p>
                                    <p class="mt-1 text-sm text-gray-500">Your recent login activity will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div id="chart_data" class="hidden">{!! $chart !!}</div>
@endsection

@push('scripts')
    <script src="/assets/js/chart.js"></script>
    <script src="/assets/js/client.chart.js"></script>
@endpush
