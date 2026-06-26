@extends('layouts.app')
@section('title', ($test['name'] ?? '復習テスト') . ' を受験')
@section('content')
@php
    $test = $test ?? [];
    $questions = $test['questions'] ?? [];
@endphp

<x-page-header :title="$test['name'] ?? '復習テスト'"
    :description="($test['course'] ?? '') . ' ・ 全 ' . count($questions) . ' 問'"
    :breadcrumbs="[['label' => '復習テスト', 'href' => route('student.review-tests')], ['label' => $test['name'] ?? '受験']]" />

@if (count($questions))
    <div x-data="reviewTest(@js($questions))" class="mx-auto max-w-2xl">
        {{-- 進捗バー --}}
        <div class="mb-4">
            <div class="mb-1.5 flex items-center justify-between text-sm">
                <span class="font-medium text-slate-700">問題 <span x-text="index + 1"></span> / <span x-text="total"></span></span>
                <span class="text-slate-500"><span x-text="answeredCount"></span> 問 回答済み</span>
            </div>
            <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-brand-600 transition-all duration-500"
                     :style="`width: ${((index + 1) / total) * 100}%`"></div>
            </div>
        </div>

        {{-- 問題カード --}}
        <template x-for="(q, qi) in questions" :key="qi">
            <div x-show="index === qi" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="card p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <span class="badge bg-brand-50 text-brand-700 ring-1 ring-brand-200">第 <span x-text="qi + 1"></span> 問</span>
                    <span class="badge bg-slate-100 text-slate-600 ring-1 ring-slate-200" x-text="'難易度: ' + (q.difficulty || '中')"></span>
                </div>

                <h3 class="mt-4 text-base font-semibold leading-relaxed text-slate-900" x-text="q.q"></h3>

                <div class="mt-5 space-y-3">
                    <template x-for="(choice, ci) in q.choices" :key="ci">
                        <button type="button"
                            @click="answers[qi] = ci"
                            :class="answers[qi] === ci
                                ? 'border-brand-500 bg-brand-50 ring-1 ring-brand-300'
                                : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50'"
                            class="flex w-full items-center gap-3 rounded-xl border p-3.5 text-left transition">
                            <span :class="answers[qi] === ci ? 'border-brand-500 bg-brand-500 text-white' : 'border-slate-300 text-slate-400'"
                                  class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-bold"
                                  x-text="['A','B','C','D'][ci]"></span>
                            <span class="text-sm text-slate-800" x-text="choice"></span>
                        </button>
                    </template>
                </div>

                {{-- 未回答警告(最終問題) --}}
                <div x-show="isLast && unansweredCount > 0" x-cloak
                     class="mt-5 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-sm text-amber-800">
                    <x-icon name="alert" class="mt-0.5 h-4 w-4 shrink-0" />
                    <span>未回答の問題が <span class="font-semibold" x-text="unansweredCount"></span> 問あります。このまま採点することもできます。</span>
                </div>

                {{-- ナビゲーション --}}
                <div class="mt-6 flex items-center justify-between gap-3">
                    <button type="button" @click="prev()" :disabled="index === 0"
                        class="btn-secondary inline-flex items-center gap-1.5 disabled:cursor-not-allowed disabled:opacity-40">
                        <x-icon name="chevron-left" class="h-4 w-4" /> 前へ
                    </button>

                    <template x-if="! isLast">
                        <button type="button" @click="next()" class="btn-primary inline-flex items-center gap-1.5">
                            次へ <x-icon name="chevron-right" class="h-4 w-4" />
                        </button>
                    </template>
                    <template x-if="isLast">
                        <button type="button" @click="submit()" class="btn-primary inline-flex items-center gap-1.5">
                            <x-icon name="check-circle" class="h-4 w-4" /> 採点する
                        </button>
                    </template>
                </div>
            </div>
        </template>

        {{-- 問題ナビ(ドット) --}}
        <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
            <template x-for="(q, qi) in questions" :key="'nav' + qi">
                <button type="button" @click="index = qi"
                    :class="qi === index
                        ? 'border-brand-500 bg-brand-600 text-white'
                        : (answers[qi] !== null ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-white text-slate-500')"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border text-sm font-medium transition"
                    x-text="qi + 1"></button>
            </template>
        </div>

        {{-- 隠しフォーム: 採点時に answers を hidden で生成して submit --}}
        <form x-ref="form" method="POST" action="{{ route('student.review-test-submit', $test['id']) }}" class="hidden">
            @csrf
            <template x-for="(a, ai) in answers" :key="'h' + ai">
                <input type="hidden" name="answers[]" :value="a === null ? '' : a">
            </template>
        </form>
    </div>

    <script>
        function reviewTest(questions) {
            return {
                questions: questions,
                total: questions.length,
                index: 0,
                answers: questions.map(() => null),
                get isLast() { return this.index === this.total - 1; },
                get answeredCount() { return this.answers.filter(a => a !== null).length; },
                get unansweredCount() { return this.answers.filter(a => a === null).length; },
                next() { if (this.index < this.total - 1) this.index++; },
                prev() { if (this.index > 0) this.index--; },
                submit() {
                    if (this.unansweredCount > 0) {
                        if (! confirm('未回答の問題が ' + this.unansweredCount + ' 問あります。このまま採点しますか?')) return;
                    }
                    this.$nextTick(() => this.$refs.form.submit());
                }
            };
        }
    </script>
@else
    <x-empty-state icon="clipboard" title="問題がありません" description="このテストには問題が登録されていません。">
        <x-slot:action>
            <a href="{{ route('student.review-tests') }}" class="btn-secondary">一覧へ戻る</a>
        </x-slot:action>
    </x-empty-state>
@endif
@endsection
