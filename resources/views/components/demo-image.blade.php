@props([
    'file',
    'alt' => '',
    'loading' => 'eager',
])

@php
    $path = public_path('assets/demo/' . $file);
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mime = match ($extension) {
        'webp' => 'image/webp',
        'jpg', 'jpeg' => 'image/jpeg',
        default => 'image/png',
    };
    $src = is_file($path)
        ? 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path))
        : asset('assets/demo/' . $file);
@endphp

<img
    src="{{ $src }}"
    alt="{{ $alt }}"
    loading="{{ $loading }}"
    decoding="async"
    {{ $attributes }}
>
