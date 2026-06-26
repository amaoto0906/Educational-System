@props(['value' => 0, 'tone' => 'brand', 'showLabel' => false])
@php
    $v = max(0, min(100, (int) $value));
    $tones = ['brand' => 'bg-brand-600', 'emerald' => 'bg-emerald-500', 'amber' => 'bg-amber-500', 'red' => 'bg-red-500'];
    $c = $tones[$tone] ?? $tones['brand'];
@endphp
<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
        <div class="h-full rounded-full {{ $c }} transition-all duration-500" style="width: {{ $v }}%"></div>
    </div>
    @if ($showLabel)<span class="w-10 text-right text-xs font-medium text-slate-500">{{ $v }}%</span>@endif
</div>
