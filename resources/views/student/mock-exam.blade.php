@extends('layouts.app')
@section('title', '模試')
@section('content')
@php $exams = $exams ?? []; @endphp

<x-page-header title="模試" description="模試サイトのログイン情報と受験URLです。IDやパスワードはワンクリックでコピーできます。" />

@if (count($exams))
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        @foreach ($exams as $e)
            <x-card
                x-data="{
                    copied: '',
                    copy(value, kind) {
                        navigator.clipboard.writeText(value);
                        this.copied = kind;
                        window.dispatchEvent(new CustomEvent('toast', { detail: { kind: 'success', text: 'コピーしました' } }));
                        setTimeout(() => this.copied = '', 1500);
                    }
                }">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                        <x-icon name="academic" class="h-6 w-6" />
                    </span>
                    <div class="min-w-0">
                        <h3 class="text-base font-semibold text-slate-900">{{ $e['name'] ?? '模試' }}</h3>
                        <p class="text-xs text-slate-500">模試アカウント情報</p>
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs font-medium text-slate-500">模試ID</p>
                        <div class="mt-1 flex items-center justify-between gap-2">
                            <code class="truncate font-mono text-sm font-semibold text-slate-800">{{ $e['mock_id'] ?? '-' }}</code>
                            <button type="button" @click="copy('{{ $e['mock_id'] ?? '' }}', 'id')"
                                class="btn-ghost shrink-0 px-2 py-1 text-xs">
                                <span x-show="copied !== 'id'" class="inline-flex items-center gap-1"><x-icon name="copy" class="h-4 w-4" /> コピー</span>
                                <span x-show="copied === 'id'" x-cloak class="inline-flex items-center gap-1 text-emerald-600"><x-icon name="check" class="h-4 w-4" /> 完了</span>
                            </button>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs font-medium text-slate-500">パスワード</p>
                        <div class="mt-1 flex items-center justify-between gap-2">
                            <code class="truncate font-mono text-sm font-semibold text-slate-800">{{ $e['password'] ?? '-' }}</code>
                            <button type="button" @click="copy('{{ $e['password'] ?? '' }}', 'pw')"
                                class="btn-ghost shrink-0 px-2 py-1 text-xs">
                                <span x-show="copied !== 'pw'" class="inline-flex items-center gap-1"><x-icon name="copy" class="h-4 w-4" /> コピー</span>
                                <span x-show="copied === 'pw'" x-cloak class="inline-flex items-center gap-1 text-emerald-600"><x-icon name="check" class="h-4 w-4" /> 完了</span>
                            </button>
                        </div>
                    </div>
                </div>

                @if (! empty($e['note']))
                    <div class="mt-4 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-sm text-amber-800">
                        <x-icon name="alert" class="mt-0.5 h-4 w-4 shrink-0" />
                        <span>{{ $e['note'] }}</span>
                    </div>
                @endif

                @if (! empty($e['url']))
                    <a href="{{ $e['url'] }}" target="_blank" rel="noopener noreferrer"
                       class="btn-primary mt-4 inline-flex w-full items-center justify-center gap-1.5">
                        受験サイトを開く <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                @endif
            </x-card>
        @endforeach
    </div>
@else
    <x-empty-state icon="academic" title="模試がありません" description="受験可能な模試はまだありません。" />
@endif
@endsection
