@extends('layouts.app')
@section('title', '教材資料')
@section('content')
@php $materials = $materials ?? []; @endphp

<x-page-header title="教材資料" description="講義で使用する資料をダウンロードできます。" />

@if (count($materials))
    <x-card pad="false">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="th">資料名</th>
                        <th class="th">カテゴリ</th>
                        <th class="th">サイズ</th>
                        <th class="th">更新日</th>
                        <th class="th text-right">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($materials as $m)
                        <tr class="hover:bg-slate-50">
                            <td class="td">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                        <x-icon name="document" class="h-5 w-5" />
                                    </span>
                                    <span class="font-medium text-slate-800">{{ $m['title'] ?? '無題' }}</span>
                                </div>
                            </td>
                            <td class="td">
                                @if (! empty($m['category']))
                                    <span class="badge bg-slate-100 text-slate-600 ring-1 ring-slate-200">{{ $m['category'] }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="td whitespace-nowrap text-slate-600">{{ $m['size'] ?? '-' }}</td>
                            <td class="td whitespace-nowrap text-slate-500">{{ $m['updated_at'] ?? '-' }}</td>
                            <td class="td text-right">
                                <button type="button"
                                    x-data
                                    @click="window.dispatchEvent(new CustomEvent('toast', { detail: { kind: 'success', text: 'ダウンロードを開始しました' } }))"
                                    class="btn-secondary inline-flex items-center gap-1.5 px-3 py-1.5 text-xs">
                                    <x-icon name="download" class="h-4 w-4" /> ダウンロード
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
@else
    <x-empty-state icon="folder" title="資料がありません" description="ダウンロードできる教材はまだありません。" />
@endif
@endsection
