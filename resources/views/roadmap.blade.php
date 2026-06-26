@extends('layouts.base')

@section('title', 'ロードマップ')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        {{-- 概要 --}}
        <div class="mb-10">
            <span class="badge bg-brand-50 text-brand-700 ring-1 ring-brand-200">
                <x-icon name="layers" class="h-3.5 w-3.5" />
                プロダクトロードマップ
            </span>
            <h1 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">サービスの今後の計画</h1>
            <p class="mt-4 leading-relaxed text-slate-600">
                学習体験の向上を軸に、機能を段階的に拡充していきます。
                まずは使いやすさと安定運用を高め、共通アカウント・提携サービス連携・学習分析の強化へと発展させます。
            </p>
        </div>

        @php
            $phaseTone = [
                '進行中' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
                '予定'   => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                '構想'   => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
            ];
            $dotTone = [
                '進行中' => 'bg-brand-500',
                '予定'   => 'bg-blue-400',
                '構想'   => 'bg-slate-300',
            ];
        @endphp

        {{-- タイムライン --}}
        @if (empty($phases))
            <x-empty-state icon="layers" title="ロードマップは準備中です" description="公開可能な計画が登録されるとここに表示されます。" />
        @else
            <ol class="relative space-y-6 border-l-2 border-slate-200 pl-8">
                @foreach ($phases as $phase)
                    @php $status = $phase['status'] ?? '構想'; @endphp
                    <li class="relative">
                        <span class="absolute -left-[39px] top-1 flex h-5 w-5 items-center justify-center rounded-full ring-4 ring-white {{ $dotTone[$status] ?? 'bg-slate-300' }}">
                            <span class="h-2 w-2 rounded-full bg-white"></span>
                        </span>
                        <x-card>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold tracking-wider text-brand-600">{{ $phase['no'] ?? '' }}</span>
                                    <h2 class="text-lg font-bold text-slate-900">{{ $phase['title'] ?? '' }}</h2>
                                </div>
                                <span class="badge {{ $phaseTone[$status] ?? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">{{ $status }}</span>
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $phase['desc'] ?? '' }}</p>
                        </x-card>
                    </li>
                @endforeach
            </ol>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('login') }}" class="btn-primary">
                <x-icon name="logout" class="h-5 w-5 rotate-180" />
                デモを始める
            </a>
        </div>
    </section>
@endsection
