<!DOCTYPE html>
<html lang="ja">
<head>
    @include('layouts.partials.head')
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="bg-slate-50">
@php use App\Services\DemoRepository; $u = DemoRepository::currentUser(); @endphp
<div class="flex min-h-screen" x-data="{ sidebar: false }">
    {{-- Sidebar (desktop) --}}
    <aside class="hidden w-64 shrink-0 flex-col border-r border-slate-200 bg-white lg:flex">
        @include('layouts.partials.sidebar')
    </aside>

    {{-- Sidebar (mobile drawer) --}}
    <div x-show="sidebar" x-cloak class="fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-slate-900/40" @click="sidebar = false"></div>
        <aside class="relative flex h-full w-72 flex-col bg-white"
               x-show="sidebar" x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0">
            @include('layouts.partials.sidebar')
        </aside>
    </div>

    <div class="flex min-w-0 flex-1 flex-col">
        {{-- Header --}}
        <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">
            <button @click="sidebar = true" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden" aria-label="メニュー">
                <x-icon name="menu" class="h-5 w-5" />
            </button>
            <div class="min-w-0">
                <h1 class="truncate text-base font-bold text-slate-900 sm:text-lg">@yield('title', 'ダッシュボード')</h1>
                @hasSection('subtitle')<p class="truncate text-xs text-slate-500">@yield('subtitle')</p>@endif
            </div>

            <div class="ml-auto flex items-center gap-3">
                @if ($u)
                    <div class="flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">
                            {{ mb_substr($u['name'], 0, 1) }}
                        </div>
                        <div class="hidden text-right sm:block">
                            <div class="text-xs font-semibold text-slate-800">{{ $u['name'] }}</div>
                            <div class="text-[10px] text-slate-500">{{ $u['email'] }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-red-600" title="ログアウト">
                                <x-icon name="logout" class="h-5 w-5" />
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>
    </div>
</div>

@include('layouts.partials.toast')
</body>
</html>
