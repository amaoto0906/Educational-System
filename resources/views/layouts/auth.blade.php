<!DOCTYPE html>
<html lang="ja">
<head>
    @include('layouts.partials.head')
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">
    {{-- 左ビジュアル --}}
    <div class="relative hidden flex-1 overflow-hidden bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-900 lg:block">
        <div class="absolute inset-0 opacity-20"
             style="background-image:radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size:28px 28px;"></div>
        <div class="relative flex h-full flex-col justify-center px-16 text-white">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 backdrop-blur">
                    <x-icon name="book" class="h-7 w-7" />
                </div>
                <div>
                    <div class="text-xl font-bold">N1 学習プラットフォーム</div>
                    <div class="text-xs tracking-widest text-brand-100">ONLINE LEARNING PLATFORM</div>
                </div>
            </div>
            <h2 class="max-w-md text-3xl font-bold leading-snug">学生が迷わず学べる、<br>軽量・高速・堅牢なマイページ。</h2>
            <p class="mt-4 max-w-md text-brand-100">動画講義から復習テスト・模試まで。学習に必要なすべてを、ひとつのマイページで。いつでも、どこでも、自分のペースで。</p>
            <div class="mt-8 max-w-md overflow-hidden rounded-2xl bg-white/10 p-3 ring-1 ring-white"
                 style="box-shadow:0 24px 70px -34px rgba(0,0,0,.7);">
                <x-demo-image
                    file="secure-login.png"
                    alt="ログイン保護とデモアカウント入力を備えた画面"
                    class="w-full"
                    style="aspect-ratio:4/3; object-fit:cover; border-radius:14px;"
                />
            </div>
            <div class="mt-10 flex flex-wrap gap-2">
                @foreach (['動画講義','復習テスト','模試対策','進捗管理'] as $t)
                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium backdrop-blur">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 右フォーム --}}
    <div class="flex w-full items-center justify-center px-4 py-10 lg:w-[480px] lg:px-12">
        <div class="w-full max-w-sm">
            @yield('content')
        </div>
    </div>
</div>

@include('layouts.partials.toast')
</body>
</html>
