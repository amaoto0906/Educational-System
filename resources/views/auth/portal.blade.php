<!DOCTYPE html>
<html lang="ja">
<head>
    @include('layouts.partials.head')
    <title>ログイン入口｜N1 学習プラットフォーム</title>
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900">
    {{-- 背景ドット --}}
    <div class="pointer-events-none fixed inset-0 opacity-20"
         style="background-image:radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size:28px 28px;"></div>

    <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">

        {{-- ロゴ --}}
        <a href="{{ route('landing') }}" class="mb-8 flex items-center gap-3 text-white">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 backdrop-blur">
                <x-icon name="book" class="h-7 w-7" />
            </div>
            <div class="leading-tight">
                <div class="text-xl font-bold">N1 学習プラットフォーム</div>
                <div class="text-[11px] tracking-widest text-brand-100">ONLINE LEARNING PLATFORM</div>
            </div>
        </a>

        {{-- 見出し --}}
        <div class="mb-8 text-center text-white">
            <h1 class="text-2xl font-bold sm:text-3xl">ログインするアカウントを選択</h1>
            <p class="mt-2 text-sm text-brand-100">ご利用の立場に合わせて、ログイン画面へお進みください。</p>
        </div>

        {{-- 3つのロール --}}
        @php
            $roles = [
                [
                    'route' => 'login',
                    'icon'  => 'user',
                    'title' => '受講生',
                    'sub'   => 'Student',
                    'desc'  => '講義動画・教材・復習テスト・模試を確認できる学習マイページ。',
                    'ring'  => 'hover:ring-brand-400',
                    'badge' => 'bg-brand-50 text-brand-600',
                ],
                [
                    'route' => 'teacher.login',
                    'icon'  => 'academic',
                    'title' => '講師',
                    'sub'   => 'Teacher',
                    'desc'  => '復習テストの問題作成・公開管理を行う講師向けページ。',
                    'ring'  => 'hover:ring-emerald-400',
                    'badge' => 'bg-emerald-50 text-emerald-600',
                ],
                [
                    'route' => 'admin.login',
                    'icon'  => 'cog',
                    'title' => '管理者',
                    'sub'   => 'Administrator',
                    'desc'  => '動画・教材・問題・講師などを管理する管理コンソール。',
                    'ring'  => 'hover:ring-slate-400',
                    'badge' => 'bg-slate-100 text-slate-700',
                ],
            ];
        @endphp

        <div class="grid w-full max-w-4xl gap-5 sm:grid-cols-3">
            @foreach ($roles as $r)
                <a href="{{ route($r['route']) }}"
                   class="group flex flex-col rounded-2xl bg-white p-6 shadow-soft ring-1 ring-white/40 transition hover:-translate-y-1 hover:shadow-xl hover:ring-2 {{ $r['ring'] }}">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $r['badge'] }}">
                        <x-icon name="{{ $r['icon'] }}" class="h-7 w-7" />
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <div class="text-lg font-bold text-slate-900">{{ $r['title'] }}</div>
                            <div class="text-[11px] font-medium uppercase tracking-widest text-slate-400">{{ $r['sub'] }}</div>
                        </div>
                        <x-icon name="arrow-right" class="h-5 w-5 text-slate-300 transition group-hover:translate-x-1 group-hover:text-brand-500" />
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-slate-500">{{ $r['desc'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 group-hover:text-brand-700">
                        <x-icon name="logout" class="h-4 w-4 rotate-180" />
                        ログインへ進む
                    </span>
                </a>
            @endforeach
        </div>

        {{-- 戻る --}}
        <a href="{{ route('landing') }}"
           class="mt-8 inline-flex items-center gap-1.5 text-sm text-brand-100 transition hover:text-white">
            <x-icon name="chevron-left" class="h-4 w-4" />
            トップページに戻る
        </a>
    </div>

    @include('layouts.partials.toast')
</body>
</html>
