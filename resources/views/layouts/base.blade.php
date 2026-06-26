<!DOCTYPE html>
<html lang="ja">
<head>
    @include('layouts.partials.head')
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="bg-white">
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white">
                    <x-icon name="book" class="h-5 w-5" />
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-bold text-slate-900">N1 学習プラットフォーム</div>
                    <div class="text-[10px] font-medium text-brand-600">オンライン学習</div>
                </div>
            </a>
            <nav class="flex items-center gap-2">
                <a href="{{ route('roadmap') }}" class="btn-ghost hidden sm:inline-flex">ロードマップ</a>
                <a href="{{ route('portal') }}" class="btn-primary">ログイン</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="border-t border-slate-200 py-8 text-center text-sm text-slate-400">
        © 2026 N1 学習プラットフォーム
    </footer>

    @include('layouts.partials.toast')
</body>
</html>
