@extends('layouts.main')

@section('title', 'Task Client')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-gray-700 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-medium">Task Client</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Task Client</h1>
            <p class="text-sm text-gray-500">Submit captcha tasks and track client order status.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0 7-7m-7 7h18"/>
            </svg>
            Back to Console
        </a>
    </div>
@endsection

@php
    $items = $pagination->items();
    $visible_count = count($items);
    $completed_count = 0;
    $processing_count = 0;
    $pending_count = 0;
    $visible_total_amount = 0;

    foreach ($items as $task) {
        $visible_total_amount += (float) ($task->amount ?? 0);

        if (($task->status ?? '') === 'completed') {
            $completed_count++;
        } elseif (($task->status ?? '') === 'processing') {
            $processing_count++;
        } elseif (($task->status ?? '') === 'pending') {
            $pending_count++;
        }
    }
@endphp

@section('content')
    <div class="space-y-6 sm:space-y-8">
        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-base font-medium text-gray-900">Task Client Overview</h2>
                    <p class="mt-1 text-sm text-gray-500">Review submitted captcha tasks, billing amount, current status, and returned results.</p>
                </div>
                <a href="/docs" class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-50 hover:text-cyan-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500/30 sm:w-auto motion-reduce:transition-none">
                    API Docs
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3 px-5 py-5 sm:grid-cols-4 sm:px-6">
                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="text-xs text-gray-500">Total Orders</p>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h10"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-lg font-normal text-gray-950">{{ $pagination->total() }}</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $visible_count }} visible</p>
                </div>

                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="text-xs text-gray-500">Completed</p>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 13 4 4L19 7"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-lg font-normal text-gray-950">{{ $completed_count }}</p>
                    <p class="mt-1 text-xs text-gray-400">Completed on this page</p>
                </div>

                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="text-xs text-gray-500">In Queue</p>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m4-2a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-lg font-normal text-gray-950">{{ $processing_count + $pending_count }}</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $pending_count }} pending</p>
                </div>

                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <p class="text-xs text-gray-500">Page Amount</p>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-lg font-normal text-gray-950">${{ number_format($visible_total_amount, 5) }}</p>
                    <p class="mt-1 text-xs text-gray-400">Current page total</p>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <g fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect width="14" height="17" x="5" y="4" rx="2" />
                                <path stroke-linecap="round" d="M9 9h6m-6 4h6m-6 4h4" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-950">Order History</h3>
                        <p class="mt-1 text-xs text-gray-500">Latest client captcha orders.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500">Order Number</th>
                            <th scope="col" class="px-5 py-3 text-xs font-semibold text-gray-500">Captcha Type</th>
                            <th scope="col" class="px-5 py-3 text-xs font-semibold text-gray-500">Amount</th>
                            <th scope="col" class="px-5 py-3 text-xs font-semibold text-gray-500">Status</th>
                            <th scope="col" class="px-5 py-3 text-xs font-semibold text-gray-500">Result</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($pagination->items() as $item)
                            <tr class="align-middle transition-colors duration-150 hover:bg-gray-50/80 motion-reduce:transition-none">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-950">#{{ $item->order_no }}</div>
                                    <div class="mt-0.5 text-xs text-gray-400">ID {{ $item->id }}</div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-normal text-gray-700">{{ $item->taskType->code }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm font-normal text-gray-900">${{ number_format((float) ($item->amount ?? 0), 5) }}</td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm">
                                    @if($item->status == 'processing')
                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">Processing</span>
                                    @elseif($item->status === 'completed')
                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-100">Completed</span>
                                    @elseif($item->status === 'cancel')
                                        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200">Cancelled</span>
                                    @elseif($item->status === 'timeout')
                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-100">Timeout</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-100">Failed</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">
                                    <span class="block truncate" title="{{ $item->result ?? '' }}">{{ $item->result ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->created_at ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">No captcha orders yet</p>
                                        <p class="mt-1 text-sm text-gray-500">Orders submitted through your API will appear here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-200 px-6 py-4 text-sm text-gray-500">
                <p class="hidden sm:block">Total {{ $pagination->total() }} orders</p>
                @include('components.paginator', ['pagination' => $pagination])
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white px-4 py-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-900">API submissions</h3>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">This page lists tasks submitted through the client API.</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white px-4 py-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-900">Processing status</h3>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">Pending and processing orders are still being worked on.</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white px-4 py-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-900">Need help?</h3>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">If an order is stuck or billed incorrectly, submit a support ticket with the order number.</p>
            </div>
        </section>
    </div>
@endsection
