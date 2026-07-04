@extends('layouts.main')

@section('title', 'Transfer')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet" class="text-gray-400 hover:text-cyan-600 transition-colors">Wallet</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Transfer</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Transfer</h1>
            <p class="text-sm text-gray-500">Transfer task balance to another member and review recent transfers.</p>
        </div>
        <a href="/wallet" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Wallet
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif

        <!-- Transfer Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">

                    <!-- Available Balance -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-cyan-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Available Balance</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">${{ $wallet_task->balance ?? '0.00000' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Current task balance</p>
                    </div>

                    <!-- Total Sent -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-cyan-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M20.25 3.532a1 1 0 0 1 1.183 1.329l-6 15.5a1 1 0 0 1-1.624.362l-3.382-3.235l-1.203 1.202c-.636.636-1.724.186-1.724-.714v-3.288L2.309 9.723a1 1 0 0 1 .442-1.691l17.5-4.5Zm-2.114 4.305l-7.998 6.607l3.97 3.798zm-1.578-1.29L4.991 9.52l3.692 3.53l7.875-6.505Z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Total Sent</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">${{ number_format($total_transfer_amount, 2) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Total transferred out</p>
                    </div>

                    <!-- Transfers Count -->
                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-cyan-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Transfers</span>
                            </div>
                        </div>
                        <p class="text-2xl font-medium text-gray-900">{{ $total_transfer_count }}</p>
                        <p class="text-xs text-gray-400 mt-1">Successful transfers</p>
                    </div>

        </div>

        <!-- Send Money form + Transfer Tips -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Send Money Form -->
            <section class="rounded-lg border border-gray-200 bg-white lg:col-span-2">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Send Money</h2>
                </div>

                <form action="/wallet/transfer/submit" method="post" class="space-y-4 px-5 py-4">
                    <div>
                        <label for="amount" class="mb-2 block text-sm font-medium text-gray-700">Transfer Amount</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-sm font-medium text-gray-400">$</span>
                            </div>
                            <input id="amount" type="number" name="amount" step="0.5" value="{{ $old['amount'] ?? '' }}" placeholder="0.00" required class="block h-10 w-full rounded-lg border border-gray-200 bg-white pl-7 pr-4 text-base font-medium text-gray-900 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Enter the amount you wish to transfer, or pick a quick amount below.</p>

                        <div class="mt-3 grid grid-cols-4 gap-2">
                            <button type="button" onclick="document.getElementById('amount').value='10';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$10</button>
                            <button type="button" onclick="document.getElementById('amount').value='25';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$25</button>
                            <button type="button" onclick="document.getElementById('amount').value='50';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$50</button>
                            <button type="button" onclick="document.getElementById('amount').value='100';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$100</button>
                            <button type="button" onclick="document.getElementById('amount').value='250';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$250</button>
                            <button type="button" onclick="document.getElementById('amount').value='500';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$500</button>
                            <button type="button" onclick="document.getElementById('amount').value='1000';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$1,000</button>
                            <button type="button" onclick="document.getElementById('amount').value='2500';document.getElementById('amount').dispatchEvent(new Event('input'))" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs font-medium text-gray-700 transition-colors hover:border-cyan-500 hover:bg-cyan-500 hover:text-white cursor-pointer">$2,500</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Payee Email</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ $old['email'] ?? '' }}" placeholder="Enter payee email address" required class="block h-10 w-full rounded-lg border border-gray-200 bg-white pl-8 pr-4 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Please ensure the email is correct. Transfers to non-existent users will fail.</p>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Payment Password</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" stroke-width="1.8"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="1.8"/>
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" placeholder="Enter your payment password" required class="block h-10 w-full rounded-lg border border-gray-200 bg-white pl-8 pr-4 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Your payment password is required to authorize this transfer.</p>
                        </div>
                    </div>

                    <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}"/>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-gray-500">Transfers are instant and cannot be cancelled after confirmation.</p>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                            <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="m9 20.42l-6.21-6.21l2.83-2.83L9 14.77l9.88-9.89l2.83 2.83z" />
                            </svg>
                            Confirm transfer
                        </button>
                    </div>
                </form>
            </section>

            <!-- Transfer Tips -->
            <section class="rounded-lg border border-gray-200 bg-white lg:col-span-1">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Transfer Tips</h2>
                </div>

                <div class="p-5 space-y-4">
                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Minimum transfer amount</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">The minimum transfer amount is $1.00. There is no maximum limit for verified accounts.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Transfer speed</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Transfers between registered users are instant. The recipient will receive the funds immediately.</p>
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3">
                        <h3 class="text-sm font-medium text-gray-900">Transfer fees</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">A 15% transaction fee is charged for internal transfers between users; the receiving party does not need to pay any fee.</p>
                    </div>
                </div>
            </section>

        </div>

        <!-- Transfer Records -->
        <section class="rounded-lg border border-gray-200 bg-white">
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
                        <h3 class="text-sm font-medium text-gray-950">Transfer Records</h3>
                        <p class="mt-1 text-xs text-gray-500">Your transaction history</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="/wallet/transfer/records" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-950">
                        View All
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Order Number</th>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Receiving Member</th>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Amount</th>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Fee</th>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Actual Amount</th>
                            <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($pagination->items() as $item)
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-5 py-4 text-sm font-medium text-gray-700">#{{ $item->order_no }}</td>
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
                                <td class="px-5 py-4 text-sm text-gray-600">
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
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <p class="text-sm font-medium text-gray-900">No transfers found</p>
                                        <p class="mt-1 text-sm text-gray-500">Start sending money to see your transfer history.</p>
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
