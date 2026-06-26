@extends('layouts.app')
@section('title', $row ? '問題を編集' : '問題を作成')
@section('content')
@php
    $row = $row ?? null;
@endphp

<x-page-header :title="$row ? '問題を編集' : '問題を作成'"
    description="4 択問題の内容を入力します。"
    :breadcrumbs="[['label'=>'担当問題','href'=>route('teacher.questions')],['label'=>$row ? '編集' : '作成']]" />

<form method="POST" action="{{ $row ? route('teacher.questions.update', $row['id']) : route('teacher.questions.store') }}">
    @csrf
    @if ($row)@method('PUT')@endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            {{-- 問題内容 --}}
            <x-card>
                <h3 class="mb-4 text-base font-semibold text-slate-900">問題内容</h3>
                <div class="space-y-4">
                    <x-form-input name="set" label="対象セット" :value="$row['set'] ?? ''" placeholder="例: 基礎セット01" />
                    <x-form-textarea name="body" label="問題文" :value="$row['body'] ?? ''" :rows="4" :required="true" />
                </div>
            </x-card>

            {{-- 選択肢 --}}
            <x-card>
                <h3 class="mb-4 text-base font-semibold text-slate-900">選択肢</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-form-input name="a" label="選択肢 A" :value="$row['a'] ?? ''" />
                    <x-form-input name="b" label="選択肢 B" :value="$row['b'] ?? ''" />
                    <x-form-input name="c" label="選択肢 C" :value="$row['c'] ?? ''" />
                    <x-form-input name="d" label="選択肢 D" :value="$row['d'] ?? ''" />
                </div>
                <div class="mt-4">
                    <x-form-textarea name="explanation" label="解説" :value="$row['explanation'] ?? ''" :rows="3" />
                </div>
            </x-card>
        </div>

        {{-- 設定 --}}
        <div class="space-y-6">
            <x-card>
                <h3 class="mb-4 text-base font-semibold text-slate-900">設定</h3>
                <div class="space-y-4">
                    <x-form-select name="correct" label="正解" :options="['A','B','C','D']" :value="$row['correct'] ?? 'A'" :required="true" />
                    <x-form-select name="difficulty" label="難易度" :options="['易','中','難']" :value="$row['difficulty'] ?? '中'" :required="true" />
                    <x-form-select name="status" label="状態" :options="['公開中','下書き']" :value="$row['status'] ?? '下書き'" :required="true" />
                </div>
            </x-card>

            <div class="flex flex-col gap-2">
                <button type="submit" class="btn-primary inline-flex items-center justify-center gap-1.5">
                    <x-icon name="check" class="h-4 w-4" /> 保存する
                </button>
                <a href="{{ route('teacher.questions') }}" class="btn-secondary inline-flex items-center justify-center gap-1.5">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
