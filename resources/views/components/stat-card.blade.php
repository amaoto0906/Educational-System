@props(['label' => '', 'value' => '', 'unit' => null, 'icon' => 'dot', 'tone' => 'brand', 'hint' => null])
@php
    $tones = [
        'brand' => 'bg-brand-50 text-brand-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'slate' => 'bg-slate-100 text-slate-600',
    ];
    $t = $tones[$tone] ?? $tones['brand'];
@endphp
<div class="card p-5">
    <div class="flex items-start justify-between">
        <span class="text-sm font-medium text-slate-500">{{ $label }}</span>
        <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $t }}">
            <x-icon :name="$icon" class="h-5 w-5" />
        </span>
    </div>
    <div class="mt-3 flex items-baseline gap-1">
        <span class="text-2xl font-bold text-slate-900">{{ $value }}</span>
        @if ($unit)<span class="text-sm text-slate-500">{{ $unit }}</span>@endif
    </div>
    @if ($hint)<p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>@endif
</div>
