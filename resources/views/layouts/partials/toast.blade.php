{{-- フラッシュメッセージ (toast / error) を Alpine で表示 --}}
<div
    x-data="{
        items: [],
        push(kind, text) {
            if (!text) return;
            const id = Date.now() + Math.random();
            this.items.push({ id, kind, text });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) { this.items = this.items.filter(i => i.id !== id); }
    }"
    x-init="
        @if (session('toast')) push('success', @js(session('toast'))); @endif
        @if (session('error')) push('error', @js(session('error'))); @endif
        window.addEventListener('toast', e => push(e.detail.kind || 'success', e.detail.text));
    "
    class="pointer-events-none fixed bottom-4 right-4 z-[70] flex w-full max-w-sm flex-col gap-2"
>
    <template x-for="i in items" :key="i.id">
        <div
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto flex items-start gap-3 rounded-xl border bg-white p-4 shadow-soft"
            :class="i.kind === 'error' ? 'border-red-200' : 'border-emerald-200'"
        >
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full"
                 :class="i.kind === 'error' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600'">
                <span x-text="i.kind === 'error' ? '!' : '✓'" class="text-sm font-bold"></span>
            </div>
            <p class="flex-1 text-sm text-slate-700" x-text="i.text"></p>
            <button @click="remove(i.id)" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
    </template>
</div>
