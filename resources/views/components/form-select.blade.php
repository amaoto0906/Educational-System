@props(['name', 'label' => null, 'options' => [], 'value' => '', 'required' => false])
<div>
    @if ($label)<label for="{{ $name }}" class="label">{{ $label }}@if ($required)<span class="text-red-500"> *</span>@endif</label>@endif
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'input']) }}>
        @foreach ($options as $opt)
            <option value="{{ $opt }}" @selected(old($name, $value) === $opt)>{{ $opt }}</option>
        @endforeach
    </select>
    @error($name)<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>
