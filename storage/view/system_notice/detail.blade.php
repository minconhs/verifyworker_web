@extends('web.layouts.app')

@php
$categories = [
    'product' => ['label' => 'Product Updates', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
    'feature' => ['label' => 'Feature Release', 'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
    'event'  => ['label' => 'Event Benefits', 'color' => 'bg-purple-50 text-purple-700 border-purple-200'],
    'policy' => ['label' => 'Policy Notice', 'color' => 'bg-orange-50 text-orange-700 border-orange-200'],
];
@endphp

@section('title', $notice_info->title)

@section('header')
    @parent
@endsection

@section('content')
    <div class="bg-white min-h-screen py-6 sm:py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-1.5 text-xs mb-5">
                <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="/notices" class="text-gray-400 hover:text-cyan-600 transition-colors">Notices</a>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-600 font-medium truncate max-w-45">Detail</span>
            </nav>

            <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">
                        Notice Details
                    </h1>
                    <p class="text-sm text-gray-500">
                        View the full content of the announcement and related information
                    </p>
                </div>
                <a href="/notices" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back
                </a>
            </div>


            <!-- Article Card -->
            <article class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">

                <!-- Header -->
                <div class="px-5 sm:px-8 pt-6 sm:pt-8 pb-5 border-b border-gray-100">
                    <h1 class="text-xl sm:text-2xl font-medium text-gray-900 leading-snug mb-4">{{ $notice_info->title }}</h1>

                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ date('Y-m-d H:i', strtotime($notice_info->created_at)) }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-5 sm:px-8 py-6 sm:py-8">
                    <div class="prose max-w-none">
                        {!! $notice_info->content !!}
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-5 sm:px-8 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                        <span>Last updated {{ date('Y-m-d H:i', strtotime($notice_info->created_at)) }}</span>
                    </div>
                </div>
            </article>

            <section class="mt-6 sm:mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($other_notices as $item)
                        <a href="/notices/detail/{{ $item->id }}" class="block bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-md transition-all duration-200 group">
                            <div class="flex flex-col sm:flex-row gap-4 p-4">
                                <div class="w-full sm:w-48 lg:w-56 h-36 shrink-0 bg-gray-50 rounded-lg border border-gray-100 overflow-hidden">
                                    @if(!empty($item->thumbnail))
                                        <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://picsum.photos/seed/notice-{{ $item->id }}/640/360" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <div class="flex flex-1 min-w-0 flex-col py-1 sm:py-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1 group-hover:text-cyan-600 transition-colors">{{ $item->title }}</h3>
                                    <div class="mb-1 inline-flex w-fit items-center gap-1.5 rounded-md bg-gray-50 px-2.5 py-1.5 text-xs font-medium text-gray-500">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ date('Y-m-d', strtotime($item->created_at)) }}
                                    </div>
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $item->summary }}</p>
                                    <div class="mt-auto inline-flex items-center gap-1.5 pt-4 text-xs font-medium text-gray-500 group-hover:text-cyan-600 transition-colors">
                                        Read more
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
