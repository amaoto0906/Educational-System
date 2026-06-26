@extends('layouts.app')
@section('title', '復習テスト')
@section('content')
@php $tests = $tests ?? []; @endphp

<x-page-header title="復習テスト" description="学習内容の理解度を確認できる復習テストです。何度でも受験できます。" />

@if (count($tests))
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($tests as $t)
            @php
                $completed = ! empty($t['completed']);
                $result = $t['result'] ?? null;
                $qCount = count($t['questions'] ?? []);
                $status = $t['status'] ?? ($completed ? '解決済' : '未処理');
                $pct = ($result && ! empty($result['total']))
                    ? (int) round(($result['score'] / $result['total']) * 100)
                    : null;
            @endphp
            <x-card class="flex flex-col">
                <div class="flex items-start justify-between gap-2">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                        <x-icon name="clipboard" class="h-6 w-6" />
                    </span>
                    <x-status-badge :status="$status" />
                </div>

                <h3 class="mt-4 text-base font-semibold text-slate-900">{{ $t['name'] ?? '復習テスト' }}</h3>
                <p class="mt-1 text-sm text-slate-500">{{ $t['course'] ?? '' }}</p>

                <div class="mt-3 flex items-center gap-4 text-sm text-slate-600">
                    <span class="inline-flex items-center gap-1"><x-icon name="help" class="h-4 w-4 text-slate-400" /> 全 {{ $qCount }} 問</span>
                </div>

                @if ($result && $pct !== null)
                    <div class="mt-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">前回の結果</span>
                            <span class="font-semibold text-slate-800">{{ $pct }}%（{{ $result['score'] ?? 0 }}/{{ $result['total'] ?? 0 }}）</span>
                        </div>
                        @if (! empty($result['at']))
                            <p class="mt-1 text-xs text-slate-400">{{ $result['at'] }}</p>
                        @endif
                    </div>
                @endif

                <div class="mt-auto pt-4">
                    <a href="{{ route('student.review-test-show', $t['id']) }}"
                       class="btn-primary inline-flex w-full items-center justify-center gap-1.5">
                        @if ($completed)
                            <x-icon name="bolt" class="h-4 w-4" /> 再受験する
                        @else
                            <x-icon name="play" class="h-4 w-4" /> 受験する
                        @endif
                    </a>
                </div>
            </x-card>
        @endforeach
    </div>
@else
    <x-empty-state icon="clipboard" title="復習テストがありません" description="受験可能なテストはまだありません。" />
@endif
@endsection
