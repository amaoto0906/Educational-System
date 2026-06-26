@extends('layouts.app')
@section('title', '担当問題')
@section('content')
@php
    use Illuminate\Support\Str;
    $questions = $questions ?? [];
    $q = $q ?? '';
@endphp

<x-page-header title="担当問題" description="あなたが担当する問題の一覧です。検索・編集・削除ができます。">
    <x-slot:actions>
        <a href="{{ route('teacher.questions.create') }}" class="btn-primary inline-flex items-center gap-1.5">
            <x-icon name="plus" class="h-4 w-4" /> 問題を作成
        </a>
    </x-slot:actions>
</x-page-header>

<x-card class="mb-6" pad="false">
    <form method="GET" action="{{ route('teacher.questions') }}" class="flex flex-wrap items-center gap-3 p-4">
        <div class="relative min-w-0 flex-1">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <x-icon name="search" class="h-4 w-4" />
            </span>
            <input type="text" name="q" value="{{ $q }}" placeholder="問題文・セットで検索"
                   class="input pl-9">
        </div>
        <button type="submit" class="btn-primary inline-flex items-center gap-1.5">
            <x-icon name="search" class="h-4 w-4" /> 検索
        </button>
        @if ($q !== '')
            <a href="{{ route('teacher.questions') }}" class="btn-ghost">クリア</a>
        @endif
    </form>
</x-card>

@if (count($questions))
    <x-card pad="false">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="th">問題文</th>
                        <th class="th">セット</th>
                        <th class="th">正解</th>
                        <th class="th">難易度</th>
                        <th class="th">状態</th>
                        <th class="th text-right">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($questions as $q2)
                        <tr>
                            <td class="td font-medium text-slate-800">{{ Str::limit($q2['body'] ?? '', 40) }}</td>
                            <td class="td text-slate-600">{{ $q2['set'] ?? '—' }}</td>
                            <td class="td"><x-status-badge :status="$q2['correct'] ?? ''" /></td>
                            <td class="td"><x-status-badge :status="$q2['difficulty'] ?? ''" /></td>
                            <td class="td"><x-status-badge :status="$q2['status'] ?? ''" /></td>
                            <td class="td">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('teacher.questions.edit', $q2['id']) }}"
                                       class="rounded-lg p-2 text-slate-400 transition hover:bg-brand-50 hover:text-brand-600" title="編集">
                                        <x-icon name="pencil" class="h-4 w-4" />
                                    </a>
                                    <x-confirm-delete :action="route('teacher.questions.destroy', $q2['id'])" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
@else
    <x-empty-state icon="help"
        title="{{ $q !== '' ? '該当する問題が見つかりません' : '担当している問題はありません' }}"
        description="{{ $q !== '' ? '検索条件を変えてお試しください。' : '「問題を作成」から最初の問題を登録しましょう。' }}">
        <x-slot:action>
            <a href="{{ route('teacher.questions.create') }}" class="btn-primary inline-flex items-center gap-1.5">
                <x-icon name="plus" class="h-4 w-4" /> 問題を作成
            </a>
        </x-slot:action>
    </x-empty-state>
@endif
@endsection
