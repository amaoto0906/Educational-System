@extends('layouts.app')
@section('title', ($test['name'] ?? '復習テスト') . ' の結果')
@section('content')
@php
    $test = $test ?? [];
    $result = $result ?? [];
    $answers = $answers ?? [];
    $questions = $test['questions'] ?? [];

    $score = (int) ($result['score'] ?? 0);
    $totalQ = (int) ($result['total'] ?? count($questions));
    $pct = $totalQ > 0 ? (int) round(($score / $totalQ) * 100) : 0;

    if ($pct >= 80) {
        $tone = 'emerald';
        $headline = '素晴らしい！';
        $message = 'よく理解できています。この調子で学習を進めましょう。';
        $ring = 'text-emerald-600';
        $bg = 'bg-emerald-50';
    } elseif ($pct >= 60) {
        $tone = 'amber';
        $headline = 'もう一歩！';
        $message = '基礎は押さえられています。間違えた問題を見直しましょう。';
        $ring = 'text-amber-600';
        $bg = 'bg-amber-50';
    } else {
        $tone = 'red';
        $headline = '復習しましょう';
        $message = '解説を読んで、もう一度チャレンジしてみましょう。';
        $ring = 'text-red-600';
        $bg = 'bg-red-50';
    }
@endphp

<x-page-header :title="($test['name'] ?? '復習テスト') . ' の結果'"
    :description="$test['course'] ?? ''"
    :breadcrumbs="[['label' => '復習テスト', 'href' => route('student.review-tests')], ['label' => '結果']]" />

<div class="mx-auto max-w-3xl space-y-6">
    {{-- スコアサマリー --}}
    <x-card>
        <div class="flex flex-col items-center gap-4 text-center sm:flex-row sm:text-left">
            <div class="flex h-28 w-28 shrink-0 flex-col items-center justify-center rounded-full {{ $bg }}">
                <span class="text-3xl font-bold {{ $ring }}">{{ $pct }}%</span>
                <span class="text-xs font-medium text-slate-500">正答率</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-lg font-bold text-slate-900">{{ $headline }}</p>
                <p class="mt-1 text-sm text-slate-600">{{ $message }}</p>
                <div class="mt-3 flex flex-wrap items-center justify-center gap-4 sm:justify-start">
                    <span class="text-sm text-slate-600">
                        スコア <span class="text-xl font-bold text-slate-900">{{ $score }}</span> / {{ $totalQ }} 問正解
                    </span>
                    @if (! empty($result['at']))
                        <span class="text-xs text-slate-400">受験日時: {{ $result['at'] }}</span>
                    @endif
                </div>
                <div class="mt-3">
                    <x-progress-bar :value="$pct" :tone="$tone" :showLabel="true" />
                </div>
            </div>
        </div>
    </x-card>

    {{-- 設問ごとの正誤 --}}
    <div class="space-y-4">
        @foreach ($questions as $i => $q)
            @php
                $correct = (int) ($q['answer'] ?? -1);
                $chosen = array_key_exists($i, $answers) && $answers[$i] !== '' && $answers[$i] !== null
                    ? (int) $answers[$i] : null;
                $isCorrect = $chosen !== null && $chosen === $correct;
                $choices = $q['choices'] ?? [];
                $labels = ['A', 'B', 'C', 'D'];
            @endphp
            <x-card pad="false" class="overflow-hidden">
                <div class="flex items-start gap-3 border-b border-slate-100 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $isCorrect ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                        <x-icon :name="$isCorrect ? 'check-circle' : 'x-circle'" class="h-5 w-5" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-400">第 {{ $i + 1 }} 問</span>
                            @if ($isCorrect)
                                <span class="badge bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">正解</span>
                            @else
                                <span class="badge bg-red-50 text-red-700 ring-1 ring-red-200">不正解</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $q['q'] ?? '' }}</p>
                    </div>
                </div>

                <div class="space-y-2 px-5 py-4">
                    @foreach ($choices as $ci => $choice)
                        @php
                            $isAnswer = $ci === $correct;
                            $isChosen = $chosen !== null && $ci === $chosen;
                            if ($isAnswer) {
                                $rowCls = 'border-emerald-300 bg-emerald-50';
                            } elseif ($isChosen) {
                                $rowCls = 'border-red-300 bg-red-50';
                            } else {
                                $rowCls = 'border-slate-200 bg-white';
                            }
                        @endphp
                        <div class="flex items-center gap-3 rounded-xl border {{ $rowCls }} p-3">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-bold
                                {{ $isAnswer ? 'border-emerald-500 bg-emerald-500 text-white' : ($isChosen ? 'border-red-500 bg-red-500 text-white' : 'border-slate-300 text-slate-400') }}">
                                {{ $labels[$ci] ?? ($ci + 1) }}
                            </span>
                            <span class="flex-1 text-sm text-slate-800">{{ $choice }}</span>
                            @if ($isAnswer)
                                <span class="text-xs font-medium text-emerald-700">正解</span>
                            @elseif ($isChosen)
                                <span class="text-xs font-medium text-red-700">あなたの回答</span>
                            @endif
                        </div>
                    @endforeach

                    @if ($chosen === null)
                        <p class="text-xs font-medium text-amber-600">※ この問題は未回答でした。</p>
                    @endif

                    @if (! empty($q['explanation']))
                        <div class="mt-3 rounded-xl bg-slate-50 p-3">
                            <p class="flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                <x-icon name="book" class="h-4 w-4 text-slate-400" /> 解説
                            </p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $q['explanation'] }}</p>
                        </div>
                    @endif
                </div>
            </x-card>
        @endforeach
    </div>

    {{-- アクション --}}
    <div class="flex flex-col gap-3 sm:flex-row">
        <a href="{{ route('student.review-test-show', $test['id']) }}"
           class="btn-primary inline-flex flex-1 items-center justify-center gap-1.5">
            <x-icon name="bolt" class="h-4 w-4" /> もう一度受験する
        </a>
        <a href="{{ route('student.review-tests') }}"
           class="btn-secondary inline-flex flex-1 items-center justify-center gap-1.5">
            <x-icon name="chevron-left" class="h-4 w-4" /> 一覧へ戻る
        </a>
    </div>
</div>
@endsection
