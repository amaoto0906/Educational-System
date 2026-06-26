@extends('layouts.base')

@section('title', 'トップ')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-slate-200 bg-gradient-to-b from-brand-50/60 to-white">
        <div class="absolute inset-0 opacity-[0.07]"
             style="background-image:radial-gradient(circle at 15% 20%, #4f46e5 1px, transparent 1px); background-size:26px 26px;"></div>
        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-28">
            <div class="grid items-center gap-6 lg:grid-cols-2">
                <div>
                    <span class="badge bg-brand-50 text-brand-700 ring-1 ring-brand-200">
                        <x-icon name="rocket" class="h-3.5 w-3.5" />
                        資格・就活対策のオンライン学習プラットフォーム
                    </span>
                    <h1 class="mt-5 max-w-3xl text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                        学生が迷わず学べる、<br class="hidden sm:block">わかりやすい学習マイページ
                    </h1>
                    <p class="mt-5 max-w-2xl text-lg text-slate-600">
                        講義動画・教材・復習テスト・模試まで、合格に必要な学習をひとつのマイページで。
                        いつでも、どこでも、自分のペースで進められます。
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ route('login') }}" class="btn-primary">
                            <x-icon name="logout" class="h-5 w-5 rotate-180" />
                            受講生ログイン
                        </a>
                        <a href="{{ route('roadmap') }}" class="btn-secondary">
                            <x-icon name="layers" class="h-5 w-5" />
                            今後の計画を見る
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="card overflow-hidden bg-white p-3"
                         style="border-radius:24px; box-shadow:0 24px 60px -32px rgba(15,23,42,.55);">
                        <x-demo-image
                            file="learning-dashboard.png"
                            alt="受講生マイページの学習進捗ダッシュボード"
                            class="w-full"
                            style="aspect-ratio:4/3; object-fit:cover; border-radius:16px;"
                        />
                    </div>
                    <div class="absolute bottom-4 left-3 rounded-xl bg-white/90 p-3 shadow-soft ring-1 ring-slate-200">
                        <div class="flex items-center gap-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <x-icon name="check" class="h-5 w-5" />
                            </span>
                            <div>
                                <div class="text-sm font-bold text-slate-900">進捗がひと目でわかる</div>
                                <div class="text-xs text-slate-500">動画・教材・テストを一画面に集約</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3つの入口 --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="grid gap-5 sm:grid-cols-3">
            @php
                $entries = [
                    ['route' => 'login', 'icon' => 'user', 'title' => '受講生ログイン', 'desc' => '講義動画・教材・復習テスト・模試IDを確認できるマイページ。', 'tone' => 'brand'],
                    ['route' => 'admin.login', 'icon' => 'cog', 'title' => '管理者ログイン', 'desc' => '動画・教材・問題・講師などを管理する管理コンソール。', 'tone' => 'slate'],
                    ['route' => 'teacher.login', 'icon' => 'academic', 'title' => '講師ログイン', 'desc' => '復習テストの問題作成・公開管理を行う講師向けページ。', 'tone' => 'emerald'],
                ];
                $tones = [
                    'brand' => 'bg-brand-50 text-brand-600',
                    'slate' => 'bg-slate-100 text-slate-700',
                    'emerald' => 'bg-emerald-50 text-emerald-600',
                ];
            @endphp
            @foreach ($entries as $e)
                <a href="{{ route($e['route']) }}" class="group">
                    <x-card class="h-full transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $tones[$e['tone']] }}">
                            <x-icon name="{{ $e['icon'] }}" class="h-6 w-6" />
                        </div>
                        <h3 class="mt-4 flex items-center gap-1 text-lg font-bold text-slate-900">
                            {{ $e['title'] }}
                            <x-icon name="arrow-right" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-brand-500" />
                        </h3>
                        <p class="mt-1.5 text-sm text-slate-500">{{ $e['desc'] }}</p>
                    </x-card>
                </a>
            @endforeach
        </div>
    </section>

    {{-- 特長 --}}
    <section class="border-t border-slate-200 bg-slate-50/70">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-slate-900">学習を支える6つの機能</h2>
                <p class="mt-3 text-slate-600">学習に必要な機能を、ひとつの画面でシンプルに使えます。</p>
            </div>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $features = [
                        ['icon' => 'bolt', 'title' => 'サクサク動作', 'desc' => '軽快な表示で待たされず、学習に集中できます。スマホ・タブレットにも対応。'],
                        ['icon' => 'clipboard', 'title' => '復習テスト', 'desc' => '4択の出題から採点・解説表示まで完結。難易度バッジ付きで弱点を把握。'],
                        ['icon' => 'video', 'title' => '動画 / PDF教材', 'desc' => '講義動画とPDF教材を見やすく整理。受講生は迷わず必要な教材にアクセス。'],
                        ['icon' => 'academic', 'title' => '模試ID管理', 'desc' => '受講生ごとの模試ID・パスワードを安全に表示。受験サイトへの導線も明快。'],
                        ['icon' => 'database', 'title' => 'コンテンツ管理', 'desc' => '企画・動画・教材・問題・講師など各マスタを統一UIで作成・編集・公開切替。'],
                        ['icon' => 'shield', 'title' => '安心の運用', 'desc' => '大量アクセス時も安定。一括登録・通知・監視で運用負荷を軽減します。'],
                    ];
                @endphp
                @foreach ($features as $f)
                    <x-card class="h-full">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                            <x-icon name="{{ $f['icon'] }}" class="h-5 w-5" />
                        </div>
                        <h3 class="mt-4 font-bold text-slate-900">{{ $f['title'] }}</h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-slate-500">{{ $f['desc'] }}</p>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>
@endsection
