@extends('layouts.main')

@section('title', 'Deposits Records')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet/deposits" class="text-gray-400 hover:text-cyan-600 transition-colors">Deposits</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Deposit Records</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Deposit Records</h1>
            <p class="text-sm text-gray-500">Search and review historical deposit records.</p>
        </div>
        <a href="/wallet/deposits" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Deposits
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
            <form method="get" class="grid gap-4 px-6 py-5 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="order_no" class="mb-2 block text-sm font-medium text-gray-700">Order Number</label>
                    <input id="order_no" name="order_no" type="text" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter order number" value="{{ $old['order_no'] ?? '' }}">
                </div>

                <div>
                    <label for="method" class="mb-2 block text-sm font-medium text-gray-700">Payment Method</label>
                    <select id="method" name="method" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        <option value="">All</option>
                        <option value="minx" {{ ($old['method'] ?? '') === 'minx' ? 'selected' : '' }}>MinxPay</option>
                        <option value="mixpay" {{ ($old['method'] ?? '') === 'mixpay' ? 'selected' : '' }}>MixPay</option>
                        <option value="paypal" {{ ($old['method'] ?? '') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        <option value="">All</option>
                        <option value="0" {{ (string)($old['status'] ?? '') === '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ (string)($old['status'] ?? '') === '1' ? 'selected' : '' }}>Paid</option>
                        <option value="2" {{ (string)($old['status'] ?? '') === '2' ? 'selected' : '' }}>Failed</option>
                        <option value="3" {{ (string)($old['status'] ?? '') === '3' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="amount" class="mb-2 block text-sm font-medium text-gray-700">Amount</label>
                    <input id="amount" name="amount" type="number" step="0.00001" min="0" class="block w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Enter amount" value="{{ $old['amount'] ?? '' }}">
                </div>

                <div class="flex items-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 -mx-6 -mb-5 md:col-span-2 xl:col-span-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                        <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                        </svg>
                        Search
                    </button>

                    <a href="/wallet/deposits/records" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700 cursor-pointer">
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
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Method</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Paid Time</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if(in_array($item->method, ['minx', 'mixpay'], true))
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                                            <svg class="h-5 w-5" viewBox="0 0 123 141" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#164AFF" d="M5.8250618,10.9662284 C2.41795018,12.1722752 0,15.5711343 0,19.5181965 L0,77.189161 C0,107.559612 43.1933828,132.996235 57.591177,140.122875 C58.8001521,140.780719 60.3388477,141 61.5478228,141 C62.7567979,141 64.2954934,140.671078 65.5044685,140.122875 C80.0121696,133.105876 123.095646,107.559612 123.095646,77.189161 L123.095646,40.569195 L52.8651835,93.196691 C48.5788173,96.3762689 42.424035,95.1702222 39.7862712,90.4556756 L18.7940673,58.002053 C17.4751854,55.8092407 20.0030424,53.2875065 22.3110858,54.6031939 L43.6330101,69.2950366 L44.0726374,69.5143178 C46.0509603,70.5010834 48.4689104,70.5010834 50.5571401,69.5143178 L123.315459,31.5786644 L123.315459,19.6278371 C123.315459,15.6807749 120.897509,12.2819158 117.490397,11.075869 C99.5755847,4.05886954 82.6499334,0.00216671483 61.6577296,0.00216671483 C40.6655258,-0.107473902 23.7398745,3.94922892 5.8250618,10.9662284 Z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">MinxPay</p>
                                            <p class="text-xs text-gray-400">Payment channel</p>
                                        </div>
                                    @else
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                                            <svg class="h-5 w-5 text-blue-600" width="0.85em" height="1em" viewBox="0 0 256 302">
                                                <path d="M0 0h256v302H0z" fill="none" />
                                                <path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765" />
                                                <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">PayPal</p>
                                            <p class="text-xs text-gray-400">Payment channel</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-emerald-700">+${{ $item->amount }}</td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->status == 0)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($item->status == 1)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13l4 4L19 7"/>
                                        </svg>
                                        Paid
                                    </span>
                                @elseif($item->status == 2)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Failed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($item->paid_at)
                                    <p class="text-gray-700">{{ $item->paid_at->format('M j, Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->paid_at->format('g:i A') }}</p>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No deposits records yet</p>
                                    <p class="mt-1 text-sm text-gray-500">Your deposits history will appear here.</p>
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
