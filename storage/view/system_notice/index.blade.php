@extends('layouts.main')

@section('title', 'Notices')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Notices</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Notices</h1>
            <p class="text-sm text-gray-500">Read platform announcements and operational notices.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Console
        </a>
    </div>
@endsection

@section('header')
    @parent
@endsection

@php
    $category = $category ?? '';
    $search = $search ?? '';
    $categories = [
        '' => 'All',
        'product' => 'Product',
        'feature' => 'Feature',
        'event' => 'Event',
        'policy' => 'Policy',
    ];
@endphp

@section('content')
    <div class="space-y-2">

        <!-- Search -->
        <section class="rounded-lg border border-gray-200 bg-white">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="text-base font-medium text-gray-900">News & Announcements</h2>
            </div>

            <form action="/notices" method="get" class="space-y-4 px-5 py-5">
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
                    <div>
                        <label for="keyword" class="mb-2 block text-sm font-medium text-gray-700">Search Notices</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0a7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input id="keyword" type="text" name="keyword" value="{{ $search }}" placeholder="Search title or content" class="block w-full rounded-lg border border-gray-200 bg-white py-3 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        @if($category)
                            <input type="hidden" name="category" value="{{ $category }}">
                        @endif
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-cyan-500 px-5 py-3 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto">
                            Search
                        </button>
                        <a href="/notices" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition-colors hover:border-cyan-200 hover:text-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto">
                            Reset
                        </a>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $value => $label)
                        @php
                            $query = http_build_query(array_filter(['keyword' => $search, 'category' => $value]));
                            $href = $query ? '/notices?' . $query : '/notices';
                            $is_active = $category === $value || ($value === '' && empty($category));
                        @endphp
                        <a href="{{ $href }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $is_active ? 'bg-cyan-500 text-white' : 'border border-gray-200 bg-white text-gray-700 hover:border-cyan-200 hover:text-cyan-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </form>
        </section>

        <!-- Notice List -->
        <section class="rounded-lg border border-gray-200 bg-white">
            <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-medium text-gray-900">Notice List</h2>
                </div>
                <p class="text-sm text-gray-500">Total {{ $pagination->total() }} notices</p>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($pagination->items() as $item)
                    <a href="/notices/detail/{{ $item->id }}" class="block transition-colors hover:bg-gray-50/70">
                        <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-[180px_1fr]">
                            <div class="aspect-video overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                @if(!empty($item->thumbnail))
                                    <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-gray-300">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="mb-2 flex flex-wrap items-center gap-2">
                                    @if(!empty($item->category))
                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-cyan-700">{{ ucwords($item->category) }}</span>
                                    @endif
                                    <span class="text-xs text-gray-400">{{ date('M j, Y', strtotime($item->created_at)) }}</span>
                                </div>
                                <h3 class="truncate text-base font-medium text-gray-900">{{ $item->title }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-gray-500">{{ $item->summary }}</p>
                                <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-cyan-600">
                                    Read more
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7l-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-16 text-center">
                        <div class="mx-auto max-w-sm">
                            <p class="text-sm font-medium text-gray-900">No notices found</p>
                            <p class="mt-1 text-sm text-gray-500">Try another keyword or category.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-100 px-5 py-4 text-sm text-gray-500">
                <p>Total {{ $pagination->total() }} notices</p>
                <x-paginator :pagination="$pagination" />
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @parent
@endsection
