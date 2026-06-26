@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', $meta['label'] ?? '一覧')

@section('content')
    <x-page-header :title="$meta['label'] ?? '一覧'"
                   :breadcrumbs="[['label' => '管理', 'href' => route('admin.dashboard')], ['label' => $meta['label'] ?? '一覧']]">
        <x-slot:actions>
            <a href="{{ route('admin.crud.create', $entity) }}" class="btn-primary">
                <x-icon name="plus" class="h-4 w-4" />
                新規登録
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- 検索 --}}
    <form method="GET" action="{{ route('admin.crud.index', $entity) }}" class="mb-4 flex flex-wrap items-center gap-2">
        <div class="relative max-w-sm flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <x-icon name="search" class="h-4 w-4" />
            </span>
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="キーワードで検索" class="input pl-9">
        </div>
        <button type="submit" class="btn-secondary">検索</button>
        @if (!empty($q))
            <a href="{{ route('admin.crud.index', $entity) }}" class="btn-ghost">クリア</a>
        @endif
    </form>

    @if (empty($rows))
        <x-empty-state :icon="$meta['icon'] ?? 'document'"
                       title="データがありません"
                       :description="!empty($q) ? '「'.$q.'」に一致する'.($meta['singular'] ?? '項目').'は見つかりませんでした。' : '右上の「新規登録」から'.($meta['singular'] ?? '項目').'を追加してください。'">
            <x-slot:action>
                <a href="{{ route('admin.crud.create', $entity) }}" class="btn-primary">
                    <x-icon name="plus" class="h-4 w-4" />
                    新規登録
                </a>
            </x-slot:action>
        </x-empty-state>
    @else
        <x-card pad="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr>
                            @foreach ($meta['columns'] ?? [] as $col)
                                <th class="th">{{ $col['label'] ?? '' }}</th>
                            @endforeach
                            <th class="th text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/60">
                                @foreach ($meta['columns'] ?? [] as $col)
                                    @php $val = $row[$col['key']] ?? ''; @endphp
                                    <td class="td">
                                        @if (!empty($col['badge']))
                                            <x-status-badge :status="$val" />
                                        @elseif (!empty($col['truncate']))
                                            {{ Str::limit((string) $val, $col['truncate']) }}
                                        @else
                                            {{ $val }}
                                        @endif
                                    </td>
                                @endforeach
                                <td class="td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.crud.edit', [$entity, $row['id']]) }}"
                                           class="rounded-lg p-2 text-slate-400 transition hover:bg-brand-50 hover:text-brand-600" title="編集">
                                            <x-icon name="pencil" class="h-4 w-4" />
                                        </a>
                                        @if (!empty($meta['status_field']))
                                            <form method="POST" action="{{ route('admin.crud.toggle', [$entity, $row['id']]) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="rounded-lg p-2 text-slate-400 transition hover:bg-emerald-50 hover:text-emerald-600" title="ステータス変更">
                                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                                </button>
                                            </form>
                                        @endif
                                        <x-confirm-delete :action="route('admin.crud.destroy', [$entity, $row['id']])" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
        <p class="mt-3 text-xs text-slate-400">全 {{ count($rows) }} 件</p>
    @endif
@endsection
