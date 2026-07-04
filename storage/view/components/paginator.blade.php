@if($pagination->lastPage() > 1)
    @php
        $current = $pagination->currentPage();
        $last = $pagination->lastPage();
        $window = 5; // 当前页前后各显示几页

        $start = max(1, $current - $window);
        $end = min($last, $current + $window);

        // 保证总共最多显示10页（不含首尾省略逻辑）
        if (($end - $start + 1) < 10) {
            if ($start == 1) {
                $end = min($last, $start + 9);
            } else {
                $start = max(1, $end - 9);
            }
        }
    @endphp

    <div class="flex flex-wrap justify-center sm:justify-start gap-1.5 py-4">
        {{-- 上一页 --}}
        @if($pagination->onFirstPage())
            <span class="grid size-8 place-content-center rounded border border-gray-200 text-gray-300 cursor-not-allowed rtl:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </span>
        @else
            <a href="{{ $pagination->previousPageUrl() }}" class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </a>
        @endif

        {{-- 首页 + 省略号 --}}
        @if($start > 1)
            <a href="{{ $pagination->url(1) }}" class="block size-8 rounded border border-gray-200 text-center text-sm/8 font-medium transition-colors hover:bg-gray-50">1</a>
            @if($start > 2)
                <span class="grid size-8 place-content-center text-sm text-gray-400">…</span>
            @endif
        @endif

        {{-- 中间页码 --}}
        @foreach($pagination->getUrlRange($start, $end) as $page => $url)
            @if($page == $current)
                <span class="block size-8 rounded bg-cyan-500 text-center text-sm/8 font-medium text-white">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="block size-8 rounded border border-gray-200 text-center text-sm/8 font-medium transition-colors hover:bg-gray-50">{{ $page }}</a>
            @endif
        @endforeach

        {{-- 省略号 + 尾页 --}}
        @if($end < $last)
            @if($end < $last - 1)
                <span class="grid size-8 place-content-center text-sm text-gray-400">…</span>
            @endif
            <a href="{{ $pagination->url($last) }}" class="block size-8 rounded border border-gray-200 text-center text-sm/8 font-medium transition-colors hover:bg-gray-50">{{ $last }}</a>
        @endif

        {{-- 下一页 --}}
        @if($current == $last)
            <span class="grid size-8 place-content-center rounded border border-gray-200 text-gray-300 cursor-not-allowed rtl:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </span>
        @else
            <a href="{{ $pagination->nextPageUrl() }}" class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </a>
        @endif
    </div>
@endif