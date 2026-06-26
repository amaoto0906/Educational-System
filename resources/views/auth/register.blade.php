@extends('layouts.auth')

@section('title', '新規登録')

@section('content')
    <div x-data="{ showPw: false }">
        <x-card>
            <div class="mb-6">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                    <x-icon name="plus" class="h-6 w-6" />
                </div>
                <h1 class="text-2xl font-bold text-slate-900">新規登録</h1>
                <p class="mt-1 text-sm text-slate-500">受講生アカウントを作成します。</p>
            </div>

            <div class="mb-4 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-xs text-amber-800 ring-1 ring-amber-200">
                <x-icon name="alert" class="mt-0.5 h-4 w-4 shrink-0 text-amber-500" />
                <span>本画面はデモです。送信しても実際の登録は行われません。</span>
            </div>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="space-y-4">
                    <x-form-input name="name" label="氏名" placeholder="山田 太郎" :required="true" />
                    <x-form-input name="email" label="メールアドレス" type="email" placeholder="student@example.com" :required="true" />

                    <div>
                        <label for="password" class="label">パスワード<span class="text-red-500"> *</span></label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <x-icon name="lock" class="h-5 w-5" />
                            </span>
                            <input :type="showPw ? 'text' : 'password'" id="password" name="password"
                                   autocomplete="new-password" class="input px-10" placeholder="パスワード" required>
                            <button type="button" @click="showPw = !showPw"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                                    :aria-label="showPw ? 'パスワードを隠す' : 'パスワードを表示'">
                                <x-icon name="eye" class="h-5 w-5" x-show="!showPw" />
                                <x-icon name="eye-off" class="h-5 w-5" x-show="showPw" />
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary mt-6 w-full justify-center">
                    <x-icon name="check" class="h-5 w-5" />
                    登録する
                </button>
            </form>
        </x-card>

        <p class="mt-6 text-center text-sm text-slate-500">
            すでにアカウントをお持ちの方は
            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700">ログイン</a>
        </p>
    </div>
@endsection
