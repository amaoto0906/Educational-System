@props(['title' => '', 'description' => null, 'breadcrumbs' => []])
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div>
        @if (count($breadcrumbs))
            <nav class="mb-1 flex items-center gap-1 text-xs text-slate-400">
                @foreach ($breadcrumbs as $i => $bc)
                    @if (! empty($bc['href']))
                        <a href="{{ $bc['href'] }}" class="hover:text-brand-600">{{ $bc['label'] }}</a>
                    @else
                        <span class="text-slate-500">{{ $bc['label'] }}</span>
                    @endif
                    @if ($i < count($breadcrumbs) - 1)<span>/</span>@endif
                @endforeach
            </nav>
        @endif
        <h2 class="text-lg font-bold text-slate-900 sm:text-xl">{{ $title }}</h2>
        @if ($description)<p class="mt-0.5 text-sm text-slate-500">{{ $description }}</p>@endif
    </div>
    @isset($actions)<div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>@endisset
</div>
