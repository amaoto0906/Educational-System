@extends('layouts.app')
@section('title', 'エラーログ')
@section('content')
@php
    $logs = $logs ?? [];
@endphp

<x-page-header title="エラーログ"
    description="アプリケーションで発生した例外・警告を記録します。サイレントエラーを残しません。"
    :breadcrumbs="[['label'=>'管理','href'=>route('admin.dashboard')],['label'=>'エラーログ']]" />

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <x-card pad="false">
            <div class="flex items-center gap-2 px-5 py-4 sm:px-6">
                <x-icon name="alert" class="h-5 w-5 text-slate-500" />
                <h3 class="text-base font-semibold text-slate-900">ログ一覧</h3>
            </div>

            @if (count($logs))
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="th whitespace-nowrap">発生日時</th>
                                <th class="th">種別</th>
                                <th class="th">画面</th>
                                <th class="th">メッセージ</th>
                                <th class="th">対応状況</th>
                                <th class="th text-right">詳細</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="td whitespace-nowrap text-slate-500">{{ $log['at'] ?? '—' }}</td>
                                    <td class="td font-medium text-slate-800">{{ $log['type'] ?? '—' }}</td>
                                    <td class="td text-slate-600">{{ $log['screen'] ?? '—' }}</td>
                                    <td class="td max-w-xs truncate text-slate-600">{{ $log['message'] ?? '—' }}</td>
                                    <td class="td"><x-status-badge :status="$log['status'] ?? ''" /></td>
                                    <td class="td text-right">
                                        <x-modal trigger="詳細" title="エラー詳細">
                                            <dl class="space-y-3 text-sm">
                                                <div>
                                                    <dt class="text-xs font-medium text-slate-500">発生日時</dt>
                                                    <dd class="mt-0.5 text-slate-800">{{ $log['at'] ?? '—' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-xs font-medium text-slate-500">種別</dt>
                                                    <dd class="mt-0.5 text-slate-800">{{ $log['type'] ?? '—' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-xs font-medium text-slate-500">画面</dt>
                                                    <dd class="mt-0.5 text-slate-800">{{ $log['screen'] ?? '—' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-xs font-medium text-slate-500">メッセージ</dt>
                                                    <dd class="mt-0.5 rounded-lg bg-slate-50 p-3 font-mono text-xs text-slate-700">{{ $log['message'] ?? '—' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-xs font-medium text-slate-500">対応状況</dt>
                                                    <dd class="mt-0.5"><x-status-badge :status="$log['status'] ?? ''" /></dd>
                                                </div>
                                            </dl>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 pb-5 sm:px-6">
                    <x-empty-state icon="check-circle" title="エラーはありません" description="記録されたエラーがここに表示されます。" />
                </div>
            @endif
        </x-card>
    </div>

    {{-- 方針カード --}}
    <div>
        <x-card>
            <div class="flex items-center gap-2">
                <x-icon name="shield" class="h-5 w-5 text-emerald-600" />
                <h3 class="text-base font-semibold text-slate-900">サイレントエラーを防ぐ方針</h3>
            </div>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                    例外は必ずログに記録し、運用担当へ通知する。
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                    エラーを 200 OK で握りつぶさない（適切なステータスを返す）。
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                    入力は FormRequest で検証し、不正値を早期に弾く。
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                    DB 処理の失敗は rollback してデータ不整合を防ぐ。
                </li>
                <li class="flex items-start gap-2">
                    <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" />
                    try/catch で例外を捕捉しても、再スローまたはログを残す。
                </li>
            </ul>
        </x-card>
    </div>
</div>
@endsection
