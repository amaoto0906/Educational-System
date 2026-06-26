@extends('layouts.app')
@section('title', 'キューモニター')
@section('content')
@php
    $jobs = $jobs ?? [];
    $countPending = collect($jobs)->where('status', '未処理')->count();
    $countRunning = collect($jobs)->where('status', '実行中')->count();
    $countSuccess = collect($jobs)->where('status', '成功')->count();
    $countFailed  = collect($jobs)->where('status', '失敗')->count();
@endphp

<x-page-header title="キューモニター"
    description="メール送信ジョブや一括登録ジョブなど、非同期処理（Queue）の状況を監視します。"
    :breadcrumbs="[['label'=>'管理','href'=>route('admin.dashboard')],['label'=>'キューモニター']]" />

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-stat-card label="未処理" :value="$countPending" unit="件" icon="clock" tone="amber" hint="ワーカー待ちのジョブ" />
    <x-stat-card label="実行中" :value="$countRunning" unit="件" icon="bolt" tone="blue" hint="現在処理中のジョブ" />
    <x-stat-card label="成功" :value="$countSuccess" unit="件" icon="check-circle" tone="emerald" hint="正常に完了" />
    <x-stat-card label="失敗" :value="$countFailed" unit="件" icon="x-circle" tone="red" hint="再実行が必要" />
</div>

<x-card pad="false" class="mt-6">
    <div class="flex items-center gap-2 px-5 py-4 sm:px-6">
        <x-icon name="layers" class="h-5 w-5 text-slate-500" />
        <h3 class="text-base font-semibold text-slate-900">ジョブ一覧</h3>
    </div>

    @if (count($jobs))
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="th">種別</th>
                        <th class="th">ジョブ名</th>
                        <th class="th">ステータス</th>
                        <th class="th">失敗理由</th>
                        <th class="th whitespace-nowrap">日時</th>
                        <th class="th text-right">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="td">
                                <span class="inline-flex items-center gap-1.5 text-slate-700">
                                    <x-icon :name="(($job['type'] ?? '') === 'メール送信') ? 'mail' : 'users'" class="h-4 w-4 text-slate-400" />
                                    {{ $job['type'] ?? '—' }}
                                </span>
                            </td>
                            <td class="td font-medium text-slate-800">{{ $job['name'] ?? '—' }}</td>
                            <td class="td"><x-status-badge :status="$job['status'] ?? ''" /></td>
                            <td class="td text-slate-600">
                                {{ ($job['reason'] ?? '') !== '' ? $job['reason'] : '—' }}
                            </td>
                            <td class="td whitespace-nowrap text-slate-500">{{ $job['at'] ?? '—' }}</td>
                            <td class="td text-right">
                                @if (($job['status'] ?? '') === '失敗')
                                    <form method="POST" action="{{ route('admin.queue-monitor.retry', $job['id']) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-secondary inline-flex items-center gap-1.5 px-3 py-1.5 text-xs">
                                            <x-icon name="bolt" class="h-4 w-4" /> リトライ
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-5 pb-5 sm:px-6">
            <x-empty-state icon="layers" title="ジョブはありません" description="投入されたジョブがここに表示されます。" />
        </div>
    @endif
</x-card>

<p class="mt-4 text-xs text-slate-400">
    メール送信ジョブ・一括登録ジョブは非同期（Queue）で処理されます。失敗したジョブはリトライボタンから再投入できます。
</p>
@endsection
