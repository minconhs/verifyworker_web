@extends('layouts.main')

@section('title', 'Daily Check-in')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 transition-colors hover:text-cyan-600">Console</a>
        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="/welfare" class="text-gray-400 transition-colors hover:text-cyan-600">Welfare</a>
        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900">Daily Check-in</span>
    </nav>

    <div class="mb-6 flex flex-col gap-4 sm:mb-8 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="mb-1 text-2xl font-medium text-gray-900 sm:text-3xl">Daily Check-in</h1>
            <p class="text-sm text-gray-500">Complete daily worker tasks, claim rewards, and keep your streak active.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-cyan-700">
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0 7-7m-7 7h18"/>
            </svg>
            Back to Console
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6 sm:space-y-8">

        @if($error)
            @include('components.wrong', ['message' => $error, 'margin' => true])
        @endif

        @if($success)
            @include('components.success', ['message' => $success, 'margin' => true])
        @endif

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="mb-3 flex flex-wrap items-center gap-2">
                        <span class="rounded bg-blue-50 px-2.5 py-1 text-xs font-medium uppercase tracking-wide text-cyan-700">Streak Rewards</span>
                        <span class="rounded border border-gray-200 bg-white px-2.5 py-1 text-xs font-medium text-gray-500">Daily available</span>
                    </div>
                    <h2 class="text-xl font-medium text-gray-950 sm:text-2xl">Keep your daily check-in active</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">Finish today's worker requirements to unlock the available reward and keep your check-in progress active.</p>
                </div>

                <a href="/check_task" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 13 4 4L19 7"/>
                    </svg>
                    Check In Now
                </a>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <p class="text-xs text-gray-500">Today Reward</p>
                    <p class="mt-1 text-lg font-normal text-gray-950">${{ $today_checkin_reward_amount }}</p>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <p class="text-xs text-gray-500">Tasks Completed</p>
                    <p class="mt-1 text-lg font-normal text-gray-950">{{ $today_task_completed }} / 4</p>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <p class="text-xs text-gray-500">Accuracy</p>
                    <p class="mt-1 text-lg font-normal text-gray-950">{{ $today_task_success_rate }}%</p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 items-stretch gap-6 xl:grid-cols-[1.35fr_0.65fr]">
            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ date('F Y') }}</h3>
                            <p class="text-xs text-gray-500">Check-in calendar</p>
                        </div>
                    </div>
                </div>

                <div class="px-3 py-4 sm:px-6 sm:py-5">
                    <div class="mb-2 grid grid-cols-7 gap-1 sm:gap-1.5">
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                            <span class="py-1 text-center text-[10px] font-medium uppercase text-gray-400">{{ $day }}</span>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1.5 sm:gap-2">
                        @foreach($checkin_calendar as $item)
                            @if($item['signed'])
                                <div class="flex flex-col items-center py-1">
                                    <div class="flex h-9 w-9 flex-col items-center justify-center rounded-lg {{ $item['is_today'] ? "bg-cyan-500" : "bg-emerald-500" }}  shadow-sm sm:h-10 sm:w-10">
                                        <span class="text-xs font-medium leading-none text-white sm:text-sm">{{ $item['day'] }}</span>
                                        <svg class="mt-0.5 h-2.5 w-2.5 text-white sm:h-3 sm:w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="mt-0.5 h-[9px] text-[9px] font-medium {{ $item['is_today'] ? "text-cyan-600" : "text-emerald-600" }}">+${{ $item['reward_amount'] }}</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center py-1">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg {{ $item['is_today'] ? "bg-cyan-500" : "border border-dashed border-gray-200 bg-gray-50" }} sm:h-10 sm:w-10">
                                        <span class="text-xs font-medium {{ $item['is_today'] ? "text-white" : "text-gray-300" }} sm:text-sm">{{ $item['day'] }}</span>
                                    </div>
                                    <span class="mt-0.5 h-[9px]"></span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </section>

            <section class="flex h-full flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5h6M9 3h6a2 2 0 0 1 2 2v1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1V5a2 2 0 0 1 2-2Zm1 10 2 2 4-5"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Today's Tasks</h3>
                            <p class="text-xs text-gray-500">Complete to claim reward</p>
                        </div>
                    </div>
                </div>

                <div class="grid flex-1 grid-rows-4 divide-y divide-gray-100">

                    @foreach($today_task_stats as $index => $task)
                        <div class="flex min-h-[86px] items-center gap-4 px-5 py-4 sm:px-6">
                            @if($task['done'])
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-500">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 border-gray-200 bg-white">
                                    <span class="text-xs font-medium text-gray-500">{{ $index + 1 }}</span>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <p class="text-sm font-medium text-gray-900">{{ $task['title'] }}</p>
                                    @if($task['done'])
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-[10px] font-medium text-emerald-700">Done</span>
                                    @else
                                        <span class="rounded-full border border-gray-200 bg-gray-50 px-2 py-0.5 text-[10px] font-medium text-gray-400">Pending</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400">{{ $task['desc'] }}{{ $task['done'] ? '' : ' - ' . $task['progress'] . '% complete' }}</p>
                                @if(!$task['done'])
                                    <div class="mt-2 flex items-center gap-2">
                                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-gray-200">
                                            <div class="h-full rounded-full bg-cyan-500" style="width: {{ $task['progress'] }}%"></div>
                                        </div>
                                        <span class="w-9 text-right text-[10px] font-medium text-gray-500">{{ $task['progress'] }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p class="text-xs text-gray-500">Tasks reset daily at <span class="font-medium text-gray-700">00:00 UTC</span></p>
                    <a href="/task/worker" class="inline-flex items-center justify-center rounded-lg bg-cyan-500 px-3.5 py-2 text-xs font-medium text-white transition-colors hover:bg-cyan-600">Go to Tasks</a>
                </div>
            </section>
        </div>

        <div>
            <h2 class="sr-only">Milestone Rewards</h2>

            <ol class="grid grid-cols-1 divide-y divide-gray-100 overflow-hidden rounded-lg border border-gray-200 text-sm text-gray-600 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                @foreach($checkin_reward as $item)
                    <li class="flex items-center justify-center gap-3 p-4">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 ring-1 ring-gray-200">
                        <span class="text-xs font-medium">{{ $item->checkin_days }}</span>
                    </span>

                        <p class="leading-none">
                            <strong class="block font-medium text-gray-900">{{ $item->checkin_days }} Days</strong>
                            <small class="mt-1 block font-medium text-gray-500">${{ $item->reward_amount }} reward</small>
                        </p>
                    </li>
                @endforeach
{{--                <li class="flex items-center justify-center gap-3 p-4">--}}
{{--                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white">--}}
{{--                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">--}}
{{--                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0Z" clip-rule="evenodd"/>--}}
{{--                        </svg>--}}
{{--                    </span>--}}

{{--                    <p class="leading-none">--}}
{{--                        <strong class="block font-medium text-gray-900">3 Days</strong>--}}
{{--                        <small class="mt-1 block font-medium text-emerald-700">$0.80 reward</small>--}}
{{--                    </p>--}}
{{--                </li>--}}

{{--                <li class="relative flex items-center justify-center gap-3 bg-gray-50 p-4">--}}
{{--                    <span class="absolute -left-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 rotate-45 border border-gray-200 border-b-0 border-l-0 bg-white sm:block"></span>--}}
{{--                    <span class="absolute -right-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 rotate-45 border border-gray-200 border-b-0 border-l-0 bg-gray-50 sm:block"></span>--}}

{{--                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-cyan-500 text-white">--}}
{{--                        <span class="text-xs font-medium">15</span>--}}
{{--                    </span>--}}

{{--                    <p class="leading-none">--}}
{{--                        <strong class="block font-medium text-gray-900">15 Days</strong>--}}
{{--                        <small class="mt-1 block font-medium text-cyan-700">$5.00 reward</small>--}}
{{--                    </p>--}}
{{--                </li>--}}

{{--                <li class="flex items-center justify-center gap-3 p-4">--}}
{{--                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 ring-1 ring-gray-200">--}}
{{--                        <span class="text-xs font-medium">28</span>--}}
{{--                    </span>--}}

{{--                    <p class="leading-none">--}}
{{--                        <strong class="block font-medium text-gray-900">28 Days</strong>--}}
{{--                        <small class="mt-1 block font-medium text-gray-500">$12.00 reward</small>--}}
{{--                    </p>--}}
{{--                </li>--}}
            </ol>
        </div>

        <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-cyan-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Rules</h3>
                        <p class="text-xs text-gray-500">How the daily check-in reward works</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 px-5 py-5 sm:grid-cols-2 lg:grid-cols-4 sm:px-6">
                <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-500 text-xs font-medium text-white">1</span>
                    <h4 class="mt-3 text-sm font-medium text-gray-900">Complete all tasks</h4>
                    <p class="mt-2 text-xs leading-5 text-gray-500">Finish the daily worker requirements before the reset time.</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-500 text-xs font-medium text-white">2</span>
                    <h4 class="mt-3 text-sm font-medium text-gray-900">Claim reward</h4>
                    <p class="mt-2 text-xs leading-5 text-gray-500">Qualified check-ins unlock the available reward for that day.</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-500 text-xs font-medium text-white">3</span>
                    <h4 class="mt-3 text-sm font-medium text-gray-900">Keep continuity</h4>
                    <p class="mt-2 text-xs leading-5 text-gray-500">Missing a day can interrupt continuous check-in progress.</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-500 text-xs font-medium text-white">4</span>
                    <h4 class="mt-3 text-sm font-medium text-gray-900">Daily reset</h4>
                    <p class="mt-2 text-xs leading-5 text-gray-500">Task progress and reward eligibility refresh at 00:00 UTC.</p>
                </div>
            </div>

            <div class="border-t border-gray-200 bg-gray-50 px-5 py-4 sm:px-6">
                <p class="text-xs leading-5 text-gray-500">
                    Extra milestone rewards are automatically issued when your consecutive check-in streak reaches
                    <span class="font-medium text-gray-900">3 days</span>,
                    <span class="font-medium text-gray-900">15 days</span>, and
                    <span class="font-medium text-gray-900">28 days</span>. Each milestone reward is paid once per streak cycle.
                </p>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @parent
@endsection
