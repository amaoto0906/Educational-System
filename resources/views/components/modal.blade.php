@props(['trigger' => '詳細', 'title' => '詳細'])
{{-- Alpine 開閉モーダル。$slot に本文を渡す --}}
<div x-data="{ open: false }" class="inline">
    <button type="button" @click="open = true" class="btn-secondary px-3 py-1.5 text-xs">{{ $trigger }}</button>
    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/40" @click="open = false"></div>
            <div x-show="open" x-transition class="card relative z-10 w-full max-w-lg p-0">
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                    <button @click="open = false" class="text-slate-400 hover:text-slate-600"><x-icon name="x" class="h-5 w-5" /></button>
                </div>
                <div class="max-h-[70vh] overflow-y-auto px-5 py-4">{{ $slot }}</div>
            </div>
        </div>
    </template>
</div>
