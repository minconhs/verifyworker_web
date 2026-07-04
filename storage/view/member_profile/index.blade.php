@extends('layouts.main')

@section('title', 'Profile')

@section('breadcrumb')
    <nav class="flex items-center gap-2 text-sm mb-6 sm:mb-8" aria-label="Breadcrumb">
        <a href="/console" class="text-gray-400 hover:text-cyan-600 transition-colors">Console</a>
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 font-medium">Profile</span>
    </nav>

    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-medium text-gray-900 mb-1">Profile</h1>
            <p class="text-sm text-gray-500">Manage profile information and recent login activity.</p>
        </div>
        <a href="/console" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
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
        <!-- Account Overview -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-4 lg:divide-x lg:divide-y-0">
                <div class="p-5 lg:col-span-1">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-cyan-500">
                            <span class="text-2xl font-medium text-white">{{ mb_substr($member->username, 0, 1, 'UTF-8') }}</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="truncate text-xl font-medium text-gray-900">{{ $member->username }}</h3>
                            <p class="mt-1 truncate text-sm text-gray-500">{{ $member->email }}</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">UID: {{ $member->id }}</span>
                                @if($member->status)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Normal</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">Abnormal</span>
                                @endif
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-cyan-700">
                                    {{ $platform == 'client' ? 'Client' : 'Worker' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Email</p>
                            <p class="truncate text-sm font-medium text-gray-900">{{ $member->email }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Used for login, notifications, and security messages.</p>
                </div>

                <div class="p-5">
                    <div class="mb-3 flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50">
                            <svg class="h-5 w-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Joined</p>
                            <p class="text-sm font-medium text-gray-900">{{ date('M j, Y', strtotime($member->created_at)) }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Location: {{ $location }}</p>
                </div>
            </div>
        </section>

        <!-- Profile Form + Connections -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <section class="rounded-lg border border-gray-200 bg-white shadow-sm lg:col-span-2">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Edit Profile</h2>
                </div>

                <form action="/profile/update" method="post" class="space-y-5 px-5 py-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="first_name" class="mb-2 block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="First name" value="{{ $profile->first_name ?? $old['first_name'] ?? '' }}">
                            <p class="mt-2 text-xs text-gray-400">Your legal or preferred first name.</p>
                        </div>

                        <div>
                            <label for="last_name" class="mb-2 block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Last name" value="{{ $profile->last_name ?? $old['last_name'] ?? '' }}">
                            <p class="mt-2 text-xs text-gray-400">Your family name or surname.</p>
                        </div>

                        <div>
                            <label for="country" class="mb-2 block text-sm font-medium text-gray-700">Country</label>
                            <div class="relative">
                                <select name="country" id="country" class="block w-full appearance-none rounded-lg border border-gray-200 bg-white py-3 pl-4 pr-10 text-sm text-gray-800 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20">
                                    <option value="">Select country</option>
                                    @foreach($countries as $item)
                                        <option value="{{ $item['alpha2'] }}" {{ (($old['country'] ?? $profile->country ?? '') === $item['alpha2']) ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-400">Country or region of residence.</p>
                        </div>

                        <div>
                            <label for="state" class="mb-2 block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" id="state" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="State or province" value="{{ $profile->state ?? $old['state'] ?? '' }}">
                            <p class="mt-2 text-xs text-gray-400">State, province, or administrative area.</p>
                        </div>

                        <div>
                            <label for="city" class="mb-2 block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="City" value="{{ $profile->city ?? $old['city'] ?? '' }}">
                            <p class="mt-2 text-xs text-gray-400">City or locality.</p>
                        </div>

                        <div>
                            <label for="postal_code" class="mb-2 block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Postal code" value="{{ $profile->postal_code ?? $old['postal_code'] ?? '' }}">
                            <p class="mt-2 text-xs text-gray-400">ZIP or postal code.</p>
                        </div>
                    </div>

                    <div>
                        <label for="address_line1" class="mb-2 block text-sm font-medium text-gray-700">Address Line 1</label>
                        <input type="text" name="address_line1" id="address_line1" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Street address" value="{{ $profile->address_line1 ?? $old['address_line1'] ?? '' }}">
                        <p class="mt-2 text-xs text-gray-400">Street address, building, or PO box.</p>
                    </div>

                    <div>
                        <label for="address_line2" class="mb-2 block text-sm font-medium text-gray-700">Address Line 2</label>
                        <input type="text" name="address_line2" id="address_line2" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20" placeholder="Apartment, suite, unit, etc." value="{{ $profile->address_line2 ?? $old['address_line2'] ?? '' }}">
                        <p class="mt-2 text-xs text-gray-400">Apartment, suite, unit, or other address details.</p>
                    </div>

                    <input type="hidden" name="_csrf_token" value="{{ $csrf_token }}">

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-gray-400">Keep your profile details current for account review and support.</p>
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-500 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 sm:w-auto cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Profile
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-medium text-gray-900">Connected Accounts</h2>
                </div>

                <div class="space-y-4 px-5 py-5">
                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white">
                                <svg class="h-5 w-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-medium text-gray-900">Google</h3>
                                @if(!empty($oauth->google_id))
                                    <p class="mt-1 text-sm text-gray-500">Connected for faster and safer sign-in.</p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Link Google to improve security and speed up login.</p>
                                @endif
                            </div>
                        </div>

                        @if(!empty($oauth->google_id))
                            <a href="/oauth/google/unbind" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border px-4 py-2.5 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-700">
                                Disconnect Google
                            </a>
                        @else
                            <a href="/oauth/google/bind" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border px-4 py-2.5 text-sm transition-colors border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-cyan-700">
                                Connect Google
                            </a>
                        @endif
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-white px-4 py-4">
                        <h3 class="text-sm font-medium text-gray-900">Account Status</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">Your account is currently marked as {{ $member->status ? 'normal' : 'abnormal' }}. Contact support if this status looks incorrect.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Login Logs -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="text-base font-medium text-gray-900">Login Logs</h2>
                <p class="mt-1 text-sm text-gray-500">Recent login activity and security history</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">IP Address</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Location</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Device</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Status</th>
                        <th scope="col" class="px-5 py-3 text-xs font-medium text-gray-500">Login Time</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($pagination->items() as $log)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4 text-sm font-mono text-gray-700">{{ $log->ip_address }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $log->location }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $log->browser }} / {{ $log->system_os }}</td>
                            <td class="px-5 py-4 text-sm">
                                @if($log->status)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Successful</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                <p class="text-gray-700">{{ $log->created_at->format('M j, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $log->created_at->format('g:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto max-w-sm">
                                    <p class="text-sm font-medium text-gray-900">No login records</p>
                                    <p class="mt-1 text-sm text-gray-500">Your recent login activity will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-gray-100 px-5 py-4 text-sm text-gray-500">
                <p>Total {{ $pagination->total() }} records</p>
                @include('components.paginator', ['$pagination' => $pagination])
            </div>
        </section>
    </div>
@endsection