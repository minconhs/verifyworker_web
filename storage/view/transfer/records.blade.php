@extends('layouts.main')

@section('title', 'Transfer Records')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet/transfer" class="text-gray-400 hover:text-cyan-600 transition-colors">Transfer</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Transfer Records</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Transfer Records</h1>
            <p class="text-sm text-gray-500">Search and review historical transfer records.</p>
        </div>
        <a href="/wallet/transfer" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Transfer
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">

        <!-- Filter Section -->
        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="text-base font-medium text-gray-900">Filter Records</h2>
            </div>
            <form method="get" class="grid gap-4 px-6 py-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <label for="order_no" class="mb-2 block text-sm font-medium text-gray-700">Order Number</label>
                    <input id="order_no" name="order_no" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter order number" value="{{ $old['order_no'] ?? '' }}">
                </div>

                <div>
                    <label for="to_username" class="mb-2 block text-sm font-medium text-gray-700">Recipient</label>
                    <input id="to_username" name="to_username" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter recipient username" value="{{ $old['to_username'] ?? '' }}">
                </div>

                <div>
                    <label for="amount" class="mb-2 block text-sm font-medium text-gray-700">Amount</label>
                    <input id="amount" name="amount" type="number" step="0.00001" min="0" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter amount" value="{{ $old['amount'] ?? '' }}">
                </div>

                <div class="flex items-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 -mx-6 -mb-5 md:col-span-2 xl:col-span-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                        <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                        </svg>
                        Search
                    </button>

                    <a href="/wallet/transfer/records" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700 cursor-pointer">
                        <svg class="h-4 w-4" width="2em" height="2em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2v2a8 8 0 1 0 5.135 1.865L15 8V2h6l-2.447 2.447A9.98 9.98 0 0 1 22 12" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <!-- List Section -->
        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50/80">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500">Order Number</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Receiving Member</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Fee</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Actual Amount</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-medium text-cyan-700">
                                        {{ mb_strtoupper(mb_substr($item->toMember->username, 0, 1, 'UTF-8')) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-gray-900">{{ $item->toMember->username }}</p>
                                        <p class="max-w-[240px] truncate text-xs text-gray-400" title="{{ $item->toMember->email }}">{{ $item->toMember->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-gray-900">${{ $item->amount }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($item->to_member_id == $member->id)
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">No fee</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">-${{ $item->fee }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-emerald-700">${{ $item->actual_amount }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No transfers found</p>
                                    <p class="mt-1 text-sm text-gray-500">Your internal transfer history will appear here once you send funds.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-sm text-gray-500">
                <p>Total {{ $pagination->total() }} records</p>
                @include('components.paginator', ['$pagination' => $pagination])
            </div>
        </section>
    </div>
@endsection
