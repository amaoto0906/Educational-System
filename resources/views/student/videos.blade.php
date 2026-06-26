@extends('layouts.app')
@section('title', '講義動画')
@section('content')
@php
    $videos = $videos ?? [];
    $thumbTones = [
        'bg-brand-100 text-brand-500',
        'bg-blue-100 text-blue-500',
        'bg-emerald-100 text-emerald-500',
        'bg-amber-100 text-amber-500',
        'bg-slate-200 text-slate-500',
        'bg-red-100 text-red-500',
    ];
@endphp

<x-page-header title="講義動画" description="Vimeo で配信中の講義動画です。視聴済みの動画にはバッジが表示されます。" />

@if (count($videos))
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($videos as $i => $v)
            @php $tone = $thumbTones[$i % count($thumbTones)]; @endphp
            <x-card pad="false" class="flex flex-col overflow-hidden">
                {{-- サムネイル --}}
                <div class="relative flex aspect-video items-center justify-center {{ $tone }}">
                    <x-icon name="play" class="h-12 w-12 opacity-80" />
                    @if (! empty($v['watched']))
                        <span class="badge absolute left-3 top-3 bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            <x-icon name="check-circle" class="mr-1 h-3.5 w-3.5" /> 視聴済み
                        </span>
                    @endif
                    @if (! empty($v['duration']))
                        <span class="absolute bottom-3 right-3 rounded-md bg-slate-900/70 px-2 py-0.5 text-xs font-medium text-white">
                            {{ $v['duration'] }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-1 flex-col p-5">
                    <h3 class="text-base font-semibold text-slate-900">{{ $v['title'] ?? '無題の動画' }}</h3>
                    <div class="mt-2 flex items-center gap-3 text-sm text-slate-500">
                        <span class="inline-flex items-center gap-1"><x-icon name="user" class="h-4 w-4" /> {{ $v['teacher'] ?? '講師' }}</span>
                        <span class="inline-flex items-center gap-1"><x-icon name="clock" class="h-4 w-4" /> {{ $v['duration'] ?? '-' }}</span>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        {{-- 詳細モーダル --}}
                        <x-modal trigger="視聴する" :title="$v['title'] ?? '講義動画'">
                            <div class="relative flex aspect-video items-center justify-center rounded-xl {{ $tone }}">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/70">
                                        <x-icon name="play" class="h-8 w-8" />
                                    </span>
                                    <span class="text-sm font-medium">プレーヤーを読み込みました(デモ)</span>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                <h4 class="text-base font-semibold text-slate-900">{{ $v['title'] ?? '講義動画' }}</h4>
                                <div class="flex items-center gap-3 text-sm text-slate-500">
                                    <span class="inline-flex items-center gap-1"><x-icon name="user" class="h-4 w-4" /> {{ $v['teacher'] ?? '講師' }}</span>
                                    <span class="inline-flex items-center gap-1"><x-icon name="clock" class="h-4 w-4" /> {{ $v['duration'] ?? '-' }}</span>
                                </div>
                                <p class="text-sm text-slate-600">
                                    本デモでは実際の動画は再生されません。Vimeo に埋め込まれた講義をこの位置で視聴できます。
                                    外部リンクから Vimeo を直接開くこともできます。
                                </p>
                                @if (! empty($v['vimeo_url']))
                                    <a href="{{ $v['vimeo_url'] }}" target="_blank" rel="noopener noreferrer"
                                       class="btn-primary mt-2 inline-flex items-center gap-1.5">
                                        Vimeo で開く <x-icon name="arrow-right" class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        </x-modal>

                        @if (! empty($v['vimeo_url']))
                            <a href="{{ $v['vimeo_url'] }}" target="_blank" rel="noopener noreferrer"
                               class="btn-ghost inline-flex items-center gap-1.5 px-3 py-1.5 text-xs">
                                <x-icon name="video" class="h-4 w-4" /> Vimeo
                            </a>
                        @endif
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>
@else
    <x-empty-state icon="video" title="動画がありません" description="配信中の講義動画はまだありません。" />
@endif
@endsection
