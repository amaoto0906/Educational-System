@extends('layouts.app')
@section('title', '講師ダッシュボード')
@section('content')
@php
    use Illuminate\Support\Str;
    $stats = $stats ?? [];
    $questions = $questions ?? [];
    $name = $stats['name'] ?? '講師';
@endphp

<x-page-header :title="$name . ' さん、こんにちは'"
    description="担当している問題の状況です。問題の作成・編集ができます。" />

{{-- KPI --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-stat-card label="担当問題数" :value="(int) ($stats['questions'] ?? 0)" unit="問" icon="help" tone="brand" hint="あなたが担当する問題" />
    <x-stat-card label="公開中" :value="(int) ($stats['published'] ?? 0)" unit="問" icon="check-circle" tone="emerald" hint="受講生に公開中" />
    <x-stat-card label="下書き" :value="(int) ($stats['drafts'] ?? 0)" unit="問" icon="pencil" tone="amber" hint="未公開の下書き" />
</div>

<x-card pad="false" class="mt-6">
    <div class="flex items-center justify-between px-5 py-4 sm:px-6">
        <div class="flex items-center gap-2">
            <x-icon name="clipboard" class="h-5 w-5 text-slate-500" />
            <h3 class="text-base font-semibold text-slate-900">担当問題（最近 5 件）</h3>
        </div>
        <a href="{{ route('teacher.questions.create') }}" class="btn-primary inline-flex items-center gap-1.5">
            <x-icon name="plus" class="h-4 w-4" /> 問題を作成
        </a>
    </div>

    @if (count($questions))
        <ul class="divide-y divide-slate-100">
            @foreach ($questions as $q)
                <li class="flex items-start gap-4 px-5 py-4 sm:px-6">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-800">{{ Str::limit($q['body'] ?? '', 60) }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <x-status-badge :status="$q['difficulty'] ?? ''" />
                            <x-status-badge :status="$q['status'] ?? ''" />
                            @if (! empty($q['set']))
                                <span class="text-xs text-slate-400">{{ $q['set'] }}</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('teacher.questions.edit', $q['id']) }}"
                       class="btn-ghost inline-flex shrink-0 items-center gap-1.5 px-3 py-1.5 text-xs">
                        <x-icon name="pencil" class="h-4 w-4" /> 編集
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="border-t border-slate-100 px-5 py-3 text-right sm:px-6">
            <a href="{{ route('teacher.questions') }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 hover:text-brand-700">
                すべての担当問題を見る <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    @else
        <div class="px-5 pb-5 sm:px-6">
            <x-empty-state icon="clipboard" title="担当している問題はありません" description="「問題を作成」から最初の問題を登録しましょう。">
                <x-slot:action>
                    <a href="{{ route('teacher.questions.create') }}" class="btn-primary inline-flex items-center gap-1.5">
                        <x-icon name="plus" class="h-4 w-4" /> 問題を作成
                    </a>
                </x-slot:action>
            </x-empty-state>
        </div>
    @endif
</x-card>
@endsection
