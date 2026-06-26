@extends('layouts.app')
@section('title', 'ダッシュボード')
@section('content')
@php
    $stats = $stats ?? [];
    $notices = $notices ?? [];
    $history = $history ?? [];
    $tests = $tests ?? [];
    $progress = (int) ($stats['progress'] ?? 0);
    $course = $stats['course'] ?? '受講コース';
    $u = \App\Services\DemoRepository::currentUser();
    $userName = $u['name'] ?? '受講生';

    // 次にやるべき学習: 未完了の復習テスト先頭
    $nextTest = collect($tests)->first(fn ($t) => empty($t['completed'] ?? false));
@endphp

<x-page-header :title="$userName . ' さん、おかえりなさい'"
    :description="$course . ' の学習状況です。今日も一歩ずつ進めましょう。'" />

{{-- 統計カード群 --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="card p-5">
        <div class="flex items-start justify-between">
            <span class="text-sm font-medium text-slate-500">学習進捗</span>
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                <x-icon name="chart" class="h-5 w-5" />
            </span>
        </div>
        <div class="mt-3 flex items-baseline gap-1">
            <span class="text-3xl font-bold text-slate-900">{{ $progress }}</span>
            <span class="text-sm text-slate-500">%</span>
        </div>
        <x-progress-bar :value="$progress" tone="brand" :showLabel="false" class="mt-3" />
    </div>

    <x-stat-card label="視聴可能な動画" :value="(int) ($stats['videos'] ?? 0)" unit="本"
        icon="video" tone="blue" hint="講義動画を視聴できます" />
    <x-stat-card label="ダウンロード可能な資料" :value="(int) ($stats['materials'] ?? 0)" unit="件"
        icon="document" tone="emerald" hint="教材PDFをダウンロード" />
    <x-stat-card label="復習テスト未完了" :value="(int) ($stats['tests_incomplete'] ?? 0)" unit="件"
        icon="clipboard" tone="amber" hint="未受験のテストがあります" />
</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        {{-- 次にやるべき学習 --}}
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="bolt" class="h-5 w-5 text-brand-600" />
                <h3 class="text-base font-semibold text-slate-900">次にやるべき学習</h3>
            </div>
            @if ($nextTest)
                <div class="mt-4 flex flex-col gap-4 rounded-xl border border-brand-100 bg-brand-50/50 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-brand-600">復習テスト</p>
                        <p class="mt-1 truncate text-base font-semibold text-slate-900">{{ $nextTest['name'] ?? '復習テスト' }}</p>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $nextTest['course'] ?? '' }} ・ 全 {{ count($nextTest['questions'] ?? []) }} 問
                        </p>
                    </div>
                    <a href="{{ route('student.review-test-show', $nextTest['id']) }}"
                       class="btn-primary inline-flex shrink-0 items-center gap-1.5">
                        受験する <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
            @else
                <div class="mt-4 flex flex-col gap-4 rounded-xl border border-emerald-100 bg-emerald-50/50 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-emerald-600">おつかれさまです</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">復習テストはすべて完了しています</p>
                        <p class="mt-1 text-sm text-slate-500">次は講義動画で学習を進めましょう。</p>
                    </div>
                    <a href="{{ route('student.videos') }}"
                       class="btn-primary inline-flex shrink-0 items-center gap-1.5">
                        動画を見る <x-icon name="play" class="h-4 w-4" />
                    </a>
                </div>
            @endif
        </x-card>

        {{-- お知らせ --}}
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="bell" class="h-5 w-5 text-amber-500" />
                <h3 class="text-base font-semibold text-slate-900">お知らせ</h3>
            </div>
            @if (count($notices))
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach ($notices as $n)
                        <li class="flex items-start gap-3 py-3">
                            <span class="mt-0.5 shrink-0 text-xs font-medium text-slate-400">{{ $n['date'] ?? '' }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-800">{{ $n['title'] ?? '' }}</p>
                            </div>
                            @if (! empty($n['tag']))
                                <span class="badge shrink-0 bg-brand-50 text-brand-700 ring-1 ring-brand-200">{{ $n['tag'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="mt-4">
                    <x-empty-state icon="bell" title="お知らせはありません" description="新しいお知らせが届くとここに表示されます。" />
                </div>
            @endif
        </x-card>

        {{-- 最近の学習履歴 --}}
        <x-card pad="false">
            <div class="flex items-center gap-2 px-5 py-4 sm:px-6">
                <x-icon name="clock" class="h-5 w-5 text-slate-500" />
                <h3 class="text-base font-semibold text-slate-900">最近の学習履歴</h3>
            </div>
            @if (count($history))
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="th">日付</th>
                                <th class="th">操作</th>
                                <th class="th">内容</th>
                                <th class="th">結果</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($history as $h)
                                <tr>
                                    <td class="td whitespace-nowrap text-slate-500">{{ $h['date'] ?? '' }}</td>
                                    <td class="td font-medium text-slate-800">{{ $h['action'] ?? '' }}</td>
                                    <td class="td text-slate-600">{{ $h['detail'] ?? '' }}</td>
                                    <td class="td text-slate-600">{{ $h['result'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 pb-5 sm:px-6">
                    <x-empty-state icon="clock" title="学習履歴はまだありません" description="学習を開始すると履歴が記録されます。" />
                </div>
            @endif
        </x-card>
    </div>

    {{-- 模試ID/PW カード --}}
    <div class="space-y-6">
        <x-card
            x-data="{
                copied: '',
                copy(value, kind) {
                    navigator.clipboard.writeText(value);
                    this.copied = kind;
                    window.dispatchEvent(new CustomEvent('toast', { detail: { kind: 'success', text: 'コピーしました' } }));
                    setTimeout(() => this.copied = '', 1500);
                }
            }">
            <div class="flex items-center gap-2">
                <x-icon name="academic" class="h-5 w-5 text-brand-600" />
                <h3 class="text-base font-semibold text-slate-900">模試アカウント</h3>
            </div>
            <p class="mt-1 text-xs text-slate-500">模試サイトへのログイン情報です。</p>

            <div class="mt-4 space-y-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <p class="text-xs font-medium text-slate-500">模試ID</p>
                    <div class="mt-1 flex items-center justify-between gap-2">
                        <code class="truncate font-mono text-sm font-semibold text-slate-800">{{ $stats['mock_id'] ?? '-' }}</code>
                        <button type="button"
                            @click="copy('{{ $stats['mock_id'] ?? '' }}', 'id')"
                            class="btn-ghost shrink-0 px-2 py-1 text-xs">
                            <span x-show="copied !== 'id'" class="inline-flex items-center gap-1"><x-icon name="copy" class="h-4 w-4" /> コピー</span>
                            <span x-show="copied === 'id'" x-cloak class="inline-flex items-center gap-1 text-emerald-600"><x-icon name="check" class="h-4 w-4" /> 完了</span>
                        </button>
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <p class="text-xs font-medium text-slate-500">パスワード</p>
                    <div class="mt-1 flex items-center justify-between gap-2">
                        <code class="truncate font-mono text-sm font-semibold text-slate-800">{{ $stats['mock_pw'] ?? '-' }}</code>
                        <button type="button"
                            @click="copy('{{ $stats['mock_pw'] ?? '' }}', 'pw')"
                            class="btn-ghost shrink-0 px-2 py-1 text-xs">
                            <span x-show="copied !== 'pw'" class="inline-flex items-center gap-1"><x-icon name="copy" class="h-4 w-4" /> コピー</span>
                            <span x-show="copied === 'pw'" x-cloak class="inline-flex items-center gap-1 text-emerald-600"><x-icon name="check" class="h-4 w-4" /> 完了</span>
                        </button>
                    </div>
                </div>
            </div>
            <a href="{{ route('student.mock-exam') }}" class="btn-secondary mt-4 inline-flex w-full items-center justify-center gap-1.5">
                模試一覧へ <x-icon name="chevron-right" class="h-4 w-4" />
            </a>
        </x-card>

        <x-card>
            <h3 class="text-base font-semibold text-slate-900">クイックリンク</h3>
            <div class="mt-3 space-y-1">
                <a href="{{ route('student.videos') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    <x-icon name="video" class="h-5 w-5 text-slate-400" /> 講義動画
                </a>
                <a href="{{ route('student.materials') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    <x-icon name="document" class="h-5 w-5 text-slate-400" /> 教材資料
                </a>
                <a href="{{ route('student.review-tests') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    <x-icon name="clipboard" class="h-5 w-5 text-slate-400" /> 復習テスト
                </a>
                <a href="{{ route('student.mock-exam') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    <x-icon name="academic" class="h-5 w-5 text-slate-400" /> 模試
                </a>
            </div>
        </x-card>
    </div>
</div>
@endsection
