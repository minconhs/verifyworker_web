@extends('layouts.main')

@section('title', 'Support Tickets')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Support Tickets</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Support Tickets</h1>
            <p class="text-sm text-gray-500">Manage support requests and follow ticket status.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="/ticket/create" class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-cyan-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Ticket
            </a>
            <a href="/console" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Console
            </a>
        </div>
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                        <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Total</span>
                </div>
                <p class="text-2xl font-medium text-gray-900">{{ $total_count }}</p>
                <p class="mt-1 text-xs text-gray-400">All support requests</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                        <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Open</span>
                </div>
                <p class="text-2xl font-medium text-gray-900">{{ $open_count }}</p>
                <p class="mt-1 text-xs text-gray-400">Waiting for review</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                        <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">In Progress</span>
                </div>
                <p class="text-2xl font-medium text-gray-900">{{ $processing_count + $reply_count }}</p>
                <p class="mt-1 text-xs text-gray-400">Processing or replied</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                        <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Closed</span>
                </div>
                <p class="text-2xl font-medium text-gray-900">{{ $closed_count }}</p>
                <p class="mt-1 text-xs text-gray-400">Resolved tickets</p>
            </div>
        </div>

        <!-- List -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
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
                        <h3 class="text-sm font-medium text-gray-950">Ticket List</h3>
                        <p class="mt-1 text-xs text-gray-500">Your ticket history</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 xl:justify-end">
                    <a href="/ticket" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ empty($status) ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        All <span class="text-xs opacity-80">{{ $total_count }}</span>
                    </a>
                    <a href="/ticket?status=open" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $status == 'open' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        Open <span class="text-xs opacity-80">{{ $open_count }}</span>
                    </a>
                    <a href="/ticket?status=processing" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $status == 'processing' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        In Progress <span class="text-xs opacity-80">{{ $processing_count }}</span>
                    </a>
                    <a href="/ticket?status=reply" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $status == 'reply' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        Reply <span class="text-xs opacity-80">{{ $reply_count }}</span>
                    </a>
                    <a href="/ticket?status=closed" class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm transition-colors {{ $status == 'closed' ? 'bg-cyan-500 text-white' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700' }}">
                        Closed <span class="text-xs opacity-80">{{ $closed_count }}</span>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Ticket</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Priority</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Category</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Created</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $item)
                        <tr class="cursor-pointer hover:bg-gray-50/70" onclick="window.location.href='/ticket/detail/{{ $item->id }}'">
                            <td class="px-5 py-4">
                                <div class="max-w-[420px]">
                                    <p class="truncate text-sm font-medium text-gray-900">{{ $item->subject }}</p>
                                    <p class="mt-1 truncate text-xs text-gray-500">{{ $item->description }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->status == 'open')
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Open</span>
                                @elseif($item->status == 'processing')
                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-cyan-700">In Progress</span>
                                @elseif($item->status == 'reply')
                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Reply</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Closed</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm">
                                @if($item->priority == 'high')
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">High</span>
                                @elseif($item->priority == 'medium')
                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Medium</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Low</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ ucwords($item->category) }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $item->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No tickets found</p>
                                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or create a new ticket.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-100 px-5 py-4 text-sm text-gray-500">
                <p>Total {{ $pagination->total() }} tickets</p>
                @include('components.paginator', ['$pagination' => $pagination])
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @parent
@endsection
