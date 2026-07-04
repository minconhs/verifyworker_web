@extends('layouts.main')

@section('title', 'Withdraw Record')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-slate-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/wallet/withdraw" class="text-slate-400 hover:text-cyan-600 transition-colors">Withdraw</a>
        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-900 font-medium">Withdraw Records</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-slate-900 mb-1">Withdraw Records</h1>
            <p class="text-sm text-slate-500">Search and review historical withdrawal records.</p>
        </div>
        <a href="/wallet/withdraw" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Withdraw
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">

        <!-- Filter Section -->
        <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-base font-medium text-slate-900">Filter Records</h2>
            </div>
            <form method="get" class="grid gap-4 px-6 py-5 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="order_no" class="mb-2 block text-sm font-medium text-slate-700">Order Number</label>
                    <input id="order_no" name="order_no" type="text" class="block h-11 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10" placeholder="Enter order number" value="{{ $old['order_no'] ?? '' }}">
                </div>

                <div>
                    <label for="method" class="mb-2 block text-sm font-medium text-slate-700">Withdrawal Method</label>
                    <select id="method" name="method" class="block h-11 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10">
                        <option value="">All</option>
                        <option value="polygon" {{ ($old['method'] ?? '') === 'polygon' ? 'selected' : '' }}>Polygon USDT</option>
                        <option value="paypal" {{ ($old['method'] ?? '') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                    <select id="status" name="status" class="block h-11 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10">
                        <option value="">All</option>
                        <option value="0" {{ (string)($old['status'] ?? '') === '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ (string)($old['status'] ?? '') === '1' ? 'selected' : '' }}>Completed</option>
                        <option value="2" {{ (string)($old['status'] ?? '') === '2' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <div>
                    <label for="amount" class="mb-2 block text-sm font-medium text-slate-700">Amount</label>
                    <input id="amount" name="amount" type="number" step="0.00001" min="0" class="block h-11 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10" placeholder="Enter amount" value="{{ $old['amount'] ?? '' }}">
                </div>

                <div class="flex items-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 -mx-6 -mb-5 md:col-span-2 xl:col-span-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors bg-cyan-500 text-white hover:bg-cyan-600 cursor-pointer">
                        <svg class="h-4 w-4" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M18 10c0-4.41-3.59-8-8-8s-8 3.59-8 8s3.59 8 8 8c1.85 0 3.54-.63 4.9-1.69l5.1 5.1L21.41 20l-5.1-5.1A8 8 0 0 0 18 10M4 10c0-3.31 2.69-6 6-6s6 2.69 6 6s-2.69 6-6 6s-6-2.69-6-6" />
                        </svg>
                        Search
                    </button>

                    <a href="/wallet/withdraw/records" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700 cursor-pointer">
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
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50/80">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-slate-500">Order Number</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Method</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Amount</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Account</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Status</th>
{{--                        <th scope="col" class="px-5 py-3 text-xs font-medium text-slate-500">Message</th>--}}
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-slate-500">Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="align-middle transition-colors hover:bg-slate-50/70">
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">#{{ $item->order_no }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->method === 'polygon')
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 ring-1 ring-slate-200">
                                            <svg class="h-5 w-5 text-cyan-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m16.364 15.217l4.27-2.435a.73.73 0 0 0 .366-.627V7.284a.72.72 0 0 0-.366-.627l-4.27-2.435a.74.74 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v8.704l-2.994 1.707l-2.994-1.707v-3.415l2.994-1.707l1.974 1.127V9.702l-1.608-.918a.75.75 0 0 0-.732 0l-4.27 2.435a.72.72 0 0 0-.366.627v4.87c0 .258.14.498.366.627l4.27 2.436a.75.75 0 0 0 .732 0l4.27-2.436a.72.72 0 0 0 .366-.626V8.012l.053-.03l2.94-1.677l2.994 1.707v3.415l-2.994 1.707l-1.972-1.124v2.291l1.606.916a.75.75 0 0 0 .732 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">Polygon USDT</p>
                                            <p class="text-xs text-slate-400">Crypto withdrawal</p>
                                        </div>
                                    @else
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 ring-1 ring-slate-200">
                                            <svg class="h-5 w-5 text-cyan-600" width="0.85em" height="1em" viewBox="0 0 256 302">
                                                <path d="M0 0h256v302H0z" fill="none" />
                                                <path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765" />
                                                <path fill="#27346a" d="M102.397 68.84a11.7 11.7 0 0 1 5.053-1.14h73.318c8.682 0 16.78.565 24.18 1.756a102 102 0 0 1 6.177 1.182a90 90 0 0 1 8.59 2.347c3.638 1.215 7.026 2.63 10.14 4.287c3.67-23.416-.026-39.34-12.687-53.765C203.226 7.625 178.046.816 145.823.816H52.295C45.71.816 40.108 5.61 39.076 12.11L.136 259.068c-.774 4.878 2.997 9.282 7.925 9.282h57.744L95.888 77.58a11.72 11.72 0 0 1 6.509-8.74" />
                                                <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477" />
                                                <path fill="#1f264f" d="M216.952 72.128a90 90 0 0 0-5.818-1.49a110 110 0 0 0-6.177-1.174c-7.408-1.199-15.5-1.765-24.19-1.765h-73.309a11.6 11.6 0 0 0-5.053 1.149a11.68 11.68 0 0 0-6.51 8.74l-15.582 98.798l-.45 2.88c1.025-6.501 6.585-11.296 13.17-11.296h27.444c53.898 0 96.1-21.892 108.428-85.221c.367-1.873.675-3.688.958-5.477q-4.682-2.47-10.14-4.279a83 83 0 0 0-2.77-.865" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">PayPal</p>
                                            <p class="text-xs text-slate-400">Account withdrawal</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-rose-600">-${{ $item->amount }}</td>
                            <td class="px-5 py-4 text-sm text-slate-600">
                                <div class="max-w-[360px] rounded-lg bg-slate-50 px-3 py-2 ring-1 ring-slate-200">
                                    <p class="break-all font-mono text-xs leading-5 text-slate-700">{{ $item->account }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->status == 0)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($item->status == 1)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-xs font-medium text-cyan-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13l4 4L19 7"/>
                                        </svg>
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Failed
                                    </span>
                                @endif
                            </td>
{{--                            <td class="px-5 py-4 text-sm text-slate-600">--}}
{{--                                <p class="max-w-[300px] truncate" title="{{ $item->status_message ?? '-' }}">{{ $item->status_message ?? '-' }}</p>--}}
{{--                            </td>--}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <p class="text-slate-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-slate-900">No withdrawal records found</p>
                                    <p class="mt-1 text-sm text-slate-500">Your withdrawal history will appear here once you submit a request.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-slate-200 px-6 py-4 text-sm text-slate-500">
                <p>Total {{ $pagination->total() }} records</p>
                @include('components.paginator', ['$pagination' => $pagination])
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @parent
@endsection
