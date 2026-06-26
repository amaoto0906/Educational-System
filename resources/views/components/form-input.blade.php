@props(['name', 'label' => null, 'value' => '', 'type' => 'text', 'placeholder' => '', 'required' => false, 'hint' => null])
<div>
    @if ($label)<label for="{{ $name }}" class="label">{{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif</label>@endif
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
           placeholder="{{ $placeholder }}" @if ($required) required @endif
           {{ $attributes->merge(['class' => 'input']) }}>
    @if ($hint)<p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>
