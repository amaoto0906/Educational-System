@extends('layouts.app')
@section('title', 'バッチ（Cron）モニター')
@section('content')
@php
    $batches = $batches ?? [];
@endphp

<x-page-header title="バッチ（Cron）モニター"
    description="定期実行バッチのスケジュールと最終実行状況を監視します。"
    :breadcrumbs="[['label'=>'管理','href'=>route('admin.dashboard')],['label'=>'バッチモニター']]" />

<x-card class="mb-6 border-brand-100 bg-brand-50/50">
    <div class="flex items-start gap-3">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
            <x-icon name="clock" class="h-5 w-5" />
        </span>
        <div>
            <h3 class="text-sm font-semibold text-slate-900">運用方針</h3>
            <p class="mt-1 text-sm text-slate-600">
                重い処理は深夜 3:00 に実行します（<code class="rounded bg-white px-1 text-xs">withoutOverlapping</code> で多重起動を防止し、前回処理が長引いても二重実行されません）。
            </p>
        </div>
    </div>
</x-card>

<x-card pad="false">
    <div class="flex items-center gap-2 px-5 py-4 sm:px-6">
        <x-icon name="cog" class="h-5 w-5 text-slate-500" />
        <h3 class="text-base font-semibold text-slate-900">バッチ一覧</h3>
    </div>

    @if (count($batches))
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="th">バッチ名</th>
                        <th class="th">実行頻度</th>
                        <th class="th whitespace-nowrap">最終実行</th>
                        <th class="th whitespace-nowrap">次回予定</th>
                        <th class="th">withoutOverlapping</th>
                        <th class="th">ステータス</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($batches as $b)
                        <tr>
                            <td class="td font-medium text-slate-800">{{ $b['name'] ?? '—' }}</td>
                            <td class="td text-slate-600">{{ $b['freq'] ?? '—' }}</td>
                            <td class="td whitespace-nowrap text-slate-500">{{ $b['last'] ?? '—' }}</td>
                            <td class="td whitespace-nowrap text-slate-500">{{ $b['next'] ?? '—' }}</td>
                            <td class="td">
                                <x-status-badge :status="($b['overlap'] ?? false) ? '有効' : '無効'" />
                            </td>
                            <td class="td"><x-status-badge :status="$b['status'] ?? ''" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-5 pb-5 sm:px-6">
            <x-empty-state icon="cog" title="バッチはありません" description="登録された定期バッチがここに表示されます。" />
        </div>
    @endif
</x-card>
@endsection
