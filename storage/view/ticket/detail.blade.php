@extends('layouts.main')

@section('title', 'Ticket Detail')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="/ticket" class="text-gray-400 hover:text-cyan-600 transition-colors">Support Tickets</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Ticket Detail</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Ticket Detail</h1>
            <p class="text-sm text-gray-500">View ticket messages and continue the support conversation.</p>
        </div>
        <a href="/ticket" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Tickets
        </a>
    </div>
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="space-y-2">

        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif

        <!-- Ticket Summary -->
        <section class="border border-gray-200 bg-white rounded-lg">
            <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 xl:flex-row xl:items-start xl:justify-between">
                <div class="min-w-0">
                    <div class="mb-2 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-medium uppercase tracking-wide text-gray-400">#{{ $ticket->order_no }}</span>

                        @if($ticket->status == 'open')
                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Open</span>
                        @elseif($ticket->status == 'processing')
                            <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-cyan-700">In Progress</span>
                        @elseif($ticket->status == 'reply')
                            <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Reply</span>
                        @else
                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Closed</span>
                        @endif

                        @if($ticket->priority == 'high')
                            <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">High</span>
                        @elseif($ticket->priority == 'medium')
                            <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Medium</span>
                        @else
                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Low</span>
                        @endif
                    </div>
                    <h2 class="text-base font-medium text-gray-900">{{ $ticket->subject }}</h2>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row xl:justify-end">
                    @if($ticket->status !== 'closed')
                        <a href="/ticket/close/{{ $ticket->id }}" class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-gray-500 hover:text-red-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-4 lg:divide-x lg:divide-y-0">
                <div class="p-5 lg:col-span-3">
                    <h3 class="mb-3 text-sm font-medium text-gray-900">Description</h3>
                    <div class="min-h-36 whitespace-pre-wrap rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm leading-relaxed text-gray-700">{{ $ticket->description }}</div>
                </div>

                <div class="p-5">
                    <h3 class="mb-4 text-sm font-medium text-gray-900">Ticket Info</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Category</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-800">{{ ucwords($ticket->category ?? 'General') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Created</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-800">{{ $ticket->created_at->format('M j, Y') }}</dd>
                            <dd class="mt-0.5 text-xs text-gray-400">{{ $ticket->created_at->format('g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-800">{{ ucwords(str_replace('_', ' ', $ticket->status)) }}</dd>
                        </div>
                    </dl>

                </div>
            </div>
        </section>

        <!-- Conversation -->
        <section class="border border-gray-200 bg-white rounded-lg">
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-4">
                <div>
                    <h2 class="text-base font-medium text-gray-900">Conversation</h2>
                </div>
                <a href="#latest" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 transition-colors hover:text-cyan-600" aria-label="Scroll to reply" title="Scroll to reply">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($messages as $message)
                    @if($message->sender == 'member')
                        <div class="px-5 py-5">
                            <div class="mb-3 flex items-center gap-2.5">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-cyan-500 text-xs font-medium text-white">Me</div>
                                <span class="text-sm font-medium text-gray-900">{{ $member->username }}</span>
                                <span class="ml-auto hidden text-xs text-gray-400 sm:inline">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</span>
                            </div>
                            <div class="sm:ml-10 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm leading-relaxed text-gray-800 whitespace-pre-wrap">{{ $message->content }}</div>
                            <p class="mt-2 text-xs text-gray-400 sm:ml-10 sm:hidden">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</p>
                        </div>
                    @elseif($message->sender == 'robot')
                        <div class="px-5 py-5">
                            <div class="mb-3 flex items-center gap-2.5">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-xs font-medium text-white">Bot</div>
                                <span class="text-sm font-medium text-gray-900">Support Bot</span>
                                <span class="ml-auto hidden text-xs text-gray-400 sm:inline">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</span>
                            </div>
                            <div class="sm:ml-10 rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm leading-relaxed text-gray-700 whitespace-pre-wrap">{{ $message->content }}</div>
                            <p class="mt-2 text-xs text-gray-400 sm:ml-10 sm:hidden">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</p>
                        </div>
                    @else
                        <div class="px-5 py-5">
                            <div class="mb-3 flex items-center gap-2.5">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-xs font-medium text-white">Alex</div>
                                <span class="text-sm font-medium text-gray-900">Alex from Support</span>
                                <span class="ml-auto hidden text-xs text-gray-400 sm:inline">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</span>
                            </div>
                            <div class="sm:ml-10 rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm leading-relaxed text-gray-700 whitespace-pre-wrap">{{ $message->content }}</div>
                            <p class="mt-2 text-xs text-gray-400 sm:ml-10 sm:hidden">{{ date('M j, Y, h:i A', strtotime($message->created_at)) }}</p>
                        </div>
                    @endif
                @empty
                    <div class="px-5 py-12 text-center">
                        <p class="text-sm font-medium text-gray-900">No replies yet</p>
                        <p class="mt-1 text-sm text-gray-500">Support messages will appear here once this ticket receives a reply.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Reply Box -->
        <section class="rounded-lg border border-gray-200 bg-white" id="latest">
            @if($ticket->status === 'closed')
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Ticket Closed</h2>
                    <p class="mt-1 text-sm text-gray-500">This ticket can no longer receive replies</p>
                </div>

                <div class="px-5 py-5">
                    <div class="rounded-lg border border-dashed border-gray-300 bg-white px-4 py-8 text-center">
                        <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0v4m-9 0h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Replies are disabled</p>
                        <p class="mt-1 text-sm text-gray-500">Create a new ticket if you need more help with this issue.</p>
                    </div>
                </div>
            @else
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Write a Reply</h2>
                </div>

                <form action="/ticket/reply/{{ $ticket->id }}" method="POST" class="space-y-4 px-5 py-5">
                    <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">
                    <textarea class="block w-full resize-y rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" name="content" placeholder="Type your message here..." rows="8" required></textarea>
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-gray-400">Add any new details, screenshots descriptions, or steps you have tried.</p>
                        <button class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto" type="submit">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Send Reply
                        </button>
                    </div>
                </form>
            @endif
        </section>
    </div>
@endsection
