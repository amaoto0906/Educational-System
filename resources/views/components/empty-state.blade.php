@props(['icon' => 'document', 'title' => 'データがありません', 'description' => null])
<div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
        <x-icon :name="$icon" class="h-6 w-6" />
    </div>
    <h3 class="text-sm font-semibold text-slate-700">{{ $title }}</h3>
    @if ($description)<p class="mt-1 max-w-sm text-sm text-slate-400">{{ $description }}</p>@endif
    @isset($action)<div class="mt-4">{{ $action }}</div>@endisset
</div>
