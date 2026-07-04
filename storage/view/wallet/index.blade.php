@extends('layouts.main')

@section('title', 'Wallet')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-slate-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-900 font-medium">Wallet</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-slate-900 mb-1">Wallet</h1>
            <p class="text-sm text-slate-500">Manage balances, wallet types, and recent transaction activity.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Console
        </a>
    </div>
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">
        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm12 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">3 wallets</span>
            </div>
            <p class="text-xs text-gray-500">Total Balance</p>
            <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $sum_balance }}</p>
            <p class="mt-1 text-xs text-gray-400">Frozen: ${{ $sum_frozen }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Recharge</span>
            </div>
            <p class="text-xs text-gray-500">Recharge Balance</p>
            <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $recharge_balance }}</p>
            <p class="mt-1 text-xs text-gray-400">Frozen: ${{ $recharge_frozen }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 13 4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Task</span>
            </div>
            <p class="text-xs text-gray-500">Task Balance</p>
            <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $task_balance }}</p>
            <p class="mt-1 text-xs text-gray-400">Frozen: ${{ $task_frozen }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded bg-blue-50 text-cyan-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v13m0-13V6a2 2 0 1 1 2 2h-2Zm0 0V5.5A2.5 2.5 0 1 0 9.5 8H12Zm-7 4h14M5 12a2 2 0 1 1 0-4h14a2 2 0 1 1 0 4M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"/>
                    </svg>
                </div>
                <span class="text-xs text-gray-400">Commission</span>
            </div>
            <p class="text-xs text-gray-500">Commission Balance</p>
            <p class="mt-1 text-xl font-normal text-gray-950 sm:text-2xl">${{ $commission_balance }}</p>
            <p class="mt-1 text-xs text-gray-400">Frozen: ${{ $commission_frozen }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
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
                    <h3 class="text-sm font-medium text-gray-950">Transaction History</h3>
                    <p class="mt-1 text-xs text-gray-500">Recent balance changes across your wallets</p>
                </div>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <div class="inline-flex w-full rounded-lg border border-gray-200 bg-gray-50 p-1 sm:w-auto">
                    <a href="/wallet" class="flex-1 rounded-md px-3 py-1.5 text-center text-sm transition-colors sm:flex-none {{ $wallet_type === '' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-600 hover:text-gray-950' }}">All</a>
                    <a href="/wallet?wallet_type=recharge" class="flex-1 rounded-md px-3 py-1.5 text-center text-sm transition-colors sm:flex-none {{ $wallet_type === 'recharge' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-600 hover:text-gray-950' }}">Recharge</a>
                    <a href="/wallet?wallet_type=task" class="flex-1 rounded-md px-3 py-1.5 text-center text-sm transition-colors sm:flex-none {{ $wallet_type === 'task' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-600 hover:text-gray-950' }}">Task</a>
                    <a href="/wallet?wallet_type=commission" class="flex-1 rounded-md px-3 py-1.5 text-center text-sm transition-colors sm:flex-none {{ $wallet_type === 'commission' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-600 hover:text-gray-950' }}">Commission</a>
                </div>
                <a href="/wallet/records" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-950">
                    View All
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[980px] w-full text-left">
                <thead class="border-b border-gray-200 bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500">Order Number</th>
                    <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Direction</th>
                    <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Category</th>
                    <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500">Amount</th>
                    <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500">Before</th>
                    <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500">After</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500">Time</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($pagination->items() as $item)
                    <tr class="align-middle transition-colors duration-150 hover:bg-gray-50 motion-reduce:transition-none">
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex rounded-md border border-gray-200 bg-gray-50 px-2.5 py-1 font-mono text-xs font-medium text-gray-700">#{{ $item->order_no ?? 'N/A' }}</span>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4">
                            @if($item->transaction_type == 'income')
                                <span class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                    Income
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-rose-100 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                                    Out
                                </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-4">
                            @if($item->operation_type == 'task')
                                <span class="inline-flex items-center rounded-full border border-cyan-100 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700">
                                    Task
                                </span>
                            @elseif($item->operation_type == 'transfer')
                                <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-700">
                                    Transfer
                                </span>
                            @elseif($item->operation_type == 'withdraw')
                                <span class="inline-flex items-center rounded-full border border-rose-100 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                                    Withdraw
                                </span>
                            @elseif($item->operation_type == 'recharge')
                                <span class="inline-flex items-center rounded-full border border-cyan-100 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700">
                                    Recharge
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-600">
                                    {{ $item->operation_type ?? '-' }}
                                </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-right">
                            @if($item->transaction_type == 'income')
                                <span class="font-mono text-sm font-medium text-emerald-700">+${{ $item->amount }}</span>
                            @else
                                <span class="font-mono text-sm font-medium text-rose-600">-${{ $item->amount }}</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-right">
                            <span class="font-mono text-sm text-gray-500">{{ isset($item->balance_before) ? '$' . $item->balance_before : '-' }}</span>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-right">
                            <span class="font-mono text-sm font-medium text-gray-800">
                                @if($item->transaction_type == 'income')
                                    ${{ bcadd($item->balance_before, $item->amount, 5) }}
                                @else
                                    ${{ bcsub($item->balance_before, $item->amount, 5) }}
                                @endif
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <p class="text-sm text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="mx-auto max-w-sm">
                                <p class="text-sm font-medium text-gray-950">No transactions found</p>
                                <p class="mt-1 text-sm text-gray-500">Your transaction history will appear here once you start earning or spending.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
