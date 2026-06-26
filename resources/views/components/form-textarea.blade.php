@props(['name', 'label' => null, 'value' => '', 'rows' => 3, 'required' => false])
<div>
    @if ($label)<label for="{{ $name }}" class="label">{{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif</label>@endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @if ($required) required @endif
              {{ $attributes->merge(['class' => 'input']) }}>{{ old($name, $value) }}</textarea>
    @error($name)<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>
