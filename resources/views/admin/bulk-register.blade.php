@extends('layouts.app')
@section('title', '受講生一括登録')
@section('content')

<x-page-header title="受講生一括登録"
    description="CSV を取り込み、1,500 件の登録処理を Queue に投入します（N+1 を避ける bulk insert・トランザクション・rollback で安全に処理）。"
    :breadcrumbs="[['label'=>'管理','href'=>route('admin.dashboard')],['label'=>'受講生一括登録']]" />

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    {{-- メイン: アップロード + 疑似進捗 --}}
    <div class="space-y-6 lg:col-span-2"
        x-data="{
            running: false,
            done: false,
            percent: 0,
            total: 1500,
            timer: null,
            processed() { return Math.min(this.total, Math.round(this.total * this.percent / 100)); },
            start() {
                if (this.running) return;
                this.running = true;
                this.done = false;
                this.percent = 0;
                this.timer = setInterval(() => {
                    this.percent += Math.random() * 6 + 2;
                    if (this.percent >= 100) {
                        this.percent = 100;
                        clearInterval(this.timer);
                        this.running = false;
                        this.done = true;
                        window.dispatchEvent(new CustomEvent('toast', { detail: { kind: 'success', text: '1,500人の登録ジョブをキューに投入しました' } }));
                    }
                }, 120);
            }
        }">

        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="users" class="h-5 w-5 text-brand-600" />
                <h3 class="text-base font-semibold text-slate-900">CSV アップロード</h3>
            </div>
            <p class="mt-1 text-xs text-slate-500">受講生情報を記載した CSV を選択してください。（デモのため実解析は行いません）</p>

            {{-- サーバ送信でも flash toast が出る --}}
            <form method="POST" action="{{ route('admin.bulk-register.run') }}" class="mt-4">
                @csrf
                <label for="csv"
                    class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center transition hover:border-brand-300 hover:bg-brand-50/40">
                    <span class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                        <x-icon name="download" class="h-6 w-6" />
                    </span>
                    <span class="text-sm font-semibold text-slate-700">ここに CSV をドラッグ＆ドロップ</span>
                    <span class="mt-1 text-xs text-slate-400">または クリックしてファイルを選択（.csv）</span>
                    <input id="csv" name="csv" type="file" accept=".csv" class="hidden"
                        x-on:change="$el.nextElementSibling && ($el.parentElement.querySelector('[data-filename]').textContent = $el.files[0]?.name || '')">
                    <span data-filename class="mt-3 text-xs font-medium text-brand-600"></span>
                </label>

                <div class="mt-5 flex flex-wrap items-center gap-3">
                    <button type="button" @click="start()" :disabled="running"
                        class="btn-primary inline-flex items-center gap-1.5 disabled:cursor-not-allowed disabled:opacity-60">
                        <x-icon name="rocket" class="h-4 w-4" />
                        <span x-show="!running">1,500人の登録を Queue に投入</span>
                        <span x-show="running" x-cloak>投入処理中…</span>
                    </button>
                    <button type="submit" class="btn-secondary inline-flex items-center gap-1.5">
                        <x-icon name="bolt" class="h-4 w-4" /> サーバ送信で投入
                    </button>
                </div>
            </form>
        </x-card>

        {{-- 疑似進捗 --}}
        <x-card x-show="running || done" x-cloak>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="layers" class="h-5 w-5 text-brand-600" />
                    <h3 class="text-base font-semibold text-slate-900">キュー処理状況</h3>
                </div>
                <span class="badge bg-blue-50 text-blue-700 ring-1 ring-blue-200" x-show="running" x-cloak>実行中</span>
                <span class="badge bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200" x-show="done && !running" x-cloak>成功</span>
            </div>

            <div class="mt-4">
                {{-- Alpine 制御の進捗バー(コンポーネントは静的のため自前で描画) --}}
                <div class="flex items-center gap-2">
                    <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-brand-600 transition-all duration-150" :style="`width: ${percent}%`"></div>
                    </div>
                    <span class="w-12 text-right text-xs font-medium text-slate-500" x-text="Math.round(percent) + '%'"></span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">総件数</p>
                    <p class="mt-1 text-lg font-bold text-slate-900" x-text="total.toLocaleString()"></p>
                </div>
                <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-3">
                    <p class="text-xs text-blue-600">処理中 / 完了</p>
                    <p class="mt-1 text-lg font-bold text-blue-700" x-text="processed().toLocaleString()"></p>
                </div>
                <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-3">
                    <p class="text-xs text-emerald-600">残り</p>
                    <p class="mt-1 text-lg font-bold text-emerald-700" x-text="(total - processed()).toLocaleString()"></p>
                </div>
            </div>

            <p class="mt-4 text-xs text-slate-400" x-show="running" x-cloak>
                同期処理ではなく、ジョブをキューに投入しワーカーが順次処理します（画面はブロックされません）。
            </p>
            <p class="mt-4 text-xs text-emerald-600" x-show="done && !running" x-cloak>
                1,500人の登録ジョブをキューに投入しました。処理完了後に通知メールが送信されます。
            </p>
        </x-card>
    </div>

    {{-- 技術説明カード3枚 --}}
    <div class="space-y-4">
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="database" class="h-5 w-5 text-brand-600" />
                <h3 class="text-sm font-semibold text-slate-900">bulk insert</h3>
            </div>
            <p class="mt-2 text-sm text-slate-600">
                1 件ずつ INSERT すると 1,500 回のクエリ（N+1）になります。<code class="rounded bg-slate-100 px-1 text-xs">insert()</code> でまとめて挿入し、クエリ回数を最小化します。
            </p>
        </x-card>
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="shield" class="h-5 w-5 text-emerald-600" />
                <h3 class="text-sm font-semibold text-slate-900">transaction</h3>
            </div>
            <p class="mt-2 text-sm text-slate-600">
                一括登録を <code class="rounded bg-slate-100 px-1 text-xs">DB::transaction()</code> で包み、全件成功か全件失敗かを保証します（中途半端な状態を作らない）。
            </p>
        </x-card>
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="alert" class="h-5 w-5 text-amber-600" />
                <h3 class="text-sm font-semibold text-slate-900">rollback</h3>
            </div>
            <p class="mt-2 text-sm text-slate-600">
                途中で例外が発生した場合は自動で <code class="rounded bg-slate-100 px-1 text-xs">rollBack()</code> し、登録済みデータを巻き戻します。データ不整合を防ぎます。
            </p>
        </x-card>
    </div>
</div>
@endsection
