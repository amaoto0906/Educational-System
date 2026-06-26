@extends('layouts.app')

@section('title', '管理ダッシュボード')
@section('subtitle', '受講生・コンテンツ・運用をまとめて管理')

@section('content')
    <x-page-header title="管理ダッシュボード"
                   description="500人規模の一斉ログインを想定した負荷対策込みの運用管理画面です。">
    </x-page-header>

    {{-- KPI --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <x-stat-card label="登録受講生数" :value="$stats['students'] ?? 0" unit="人" icon="users" tone="brand" />
        <x-stat-card label="本日ログイン数" :value="$stats['logins_today'] ?? 0" unit="人" icon="user" tone="blue" />
        <x-stat-card label="動画教材数" :value="$stats['videos'] ?? 0" unit="本" icon="video" tone="emerald" />
        <x-stat-card label="PDF資料数" :value="$stats['materials'] ?? 0" unit="件" icon="document" tone="slate" />
        <x-stat-card label="復習問題数" :value="$stats['questions'] ?? 0" unit="問" icon="help" tone="brand" />
        <x-stat-card label="Queue未処理" :value="$stats['queue_pending'] ?? 0" unit="件" icon="layers" tone="amber" hint="非同期ジョブの滞留数" />
        <x-stat-card label="Cron最終実行" :value="$stats['cron_last'] ?? '—'" icon="clock" tone="slate" hint="定期バッチの直近実行時刻" />
        <x-stat-card label="エラー件数" :value="$stats['errors'] ?? 0" unit="件" icon="alert" tone="red" hint="直近24時間の例外ログ" />
    </div>

    {{-- 負荷対策セクション --}}
    <section class="mt-8">
        <div class="mb-3 flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                <x-icon name="bolt" class="h-5 w-5" />
            </span>
            <h3 class="text-base font-bold text-slate-900">500人一斉ログイン想定の負荷対策</h3>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $measures = [
                    ['title' => 'N+1対策済', 'desc' => 'Eager Loading (with) とクエリ集約で一覧表示の発行クエリを最小化。受講生・教材を一括ロード。'],
                    ['title' => 'Queue化済', 'desc' => '一斉メール送信や一括登録は Job をキュー投入し非同期処理。リクエストを即時返却。'],
                    ['title' => 'Rate Limiter済', 'desc' => 'ログイン・APIに throttle ミドルウェアを適用し、過剰アクセスとブルートフォースを抑止。'],
                    ['title' => 'Cron多重起動防止済', 'desc' => 'スケジュールタスクに withoutOverlapping を設定し、バッチの重複実行を防止。'],
                ];
            @endphp
            @foreach ($measures as $m)
                <x-card>
                    <div class="flex items-start gap-3">
                        <span class="mt-0.5 shrink-0 text-emerald-500">
                            <x-icon name="check-circle" class="h-6 w-6" />
                        </span>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-slate-900">{{ $m['title'] }}</h4>
                            <p class="mt-1 text-xs leading-relaxed text-slate-500">{{ $m['desc'] }}</p>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- 運用画面クイックリンク --}}
    <section class="mt-8">
        <h3 class="mb-3 text-base font-bold text-slate-900">運用モニタリング</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $ops = [
                    ['href' => route('admin.bulk-register'), 'icon' => 'users', 'title' => '受講生一括登録', 'desc' => 'CSVからQueueで一括登録', 'tone' => 'bg-brand-50 text-brand-600'],
                    ['href' => route('admin.queue-monitor'), 'icon' => 'layers', 'title' => 'Queueモニター', 'desc' => '非同期ジョブの状態確認・再実行', 'tone' => 'bg-amber-50 text-amber-600'],
                    ['href' => route('admin.cron-monitor'), 'icon' => 'clock', 'title' => 'Cronモニター', 'desc' => '定期バッチの実行状況', 'tone' => 'bg-blue-50 text-blue-600'],
                    ['href' => route('admin.error-logs'), 'icon' => 'alert', 'title' => 'エラーログ', 'desc' => '例外・警告の一覧', 'tone' => 'bg-red-50 text-red-600'],
                ];
            @endphp
            @foreach ($ops as $op)
                <a href="{{ $op['href'] }}" class="card p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $op['tone'] }}">
                            <x-icon :name="$op['icon']" class="h-5 w-5" />
                        </span>
                        <x-icon name="arrow-right" class="h-4 w-4 text-slate-300" />
                    </div>
                    <h4 class="mt-3 font-semibold text-slate-900">{{ $op['title'] }}</h4>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $op['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- 主要管理導線 --}}
    <section class="mt-8">
        <h3 class="mb-3 text-base font-bold text-slate-900">主要コンテンツ管理</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $admins = [
                    ['entity' => 'projects', 'icon' => 'folder', 'title' => '企画管理', 'desc' => '講座企画の作成・公開'],
                    ['entity' => 'videos', 'icon' => 'video', 'title' => '動画管理', 'desc' => '動画教材の登録・並び替え'],
                    ['entity' => 'materials', 'icon' => 'document', 'title' => 'PDF資料管理', 'desc' => '資料ファイルの管理'],
                    ['entity' => 'questions', 'icon' => 'help', 'title' => '問題管理', 'desc' => '復習問題の作成・公開'],
                ];
            @endphp
            @foreach ($admins as $a)
                <a href="{{ route('admin.crud.index', $a['entity']) }}" class="card p-5 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            <x-icon :name="$a['icon']" class="h-5 w-5" />
                        </span>
                        <x-icon name="chevron-right" class="h-4 w-4 text-slate-300" />
                    </div>
                    <h4 class="mt-3 font-semibold text-slate-900">{{ $a['title'] }}</h4>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $a['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endsection
