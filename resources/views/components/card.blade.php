@props(['pad' => true])
<div {{ $attributes->merge(['class' => 'card '.($pad ? 'p-5 sm:p-6' : '')]) }}>
    {{ $slot }}
</div>
