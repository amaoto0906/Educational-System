@extends('layouts.auth')

@section('title', '講師ログイン')

@section('content')
    @php $mistakes = \App\Services\DemoRepository::all('email_mistakes'); @endphp

    <div x-data="loginForm(@js($mistakes))">
        <x-card>
            <div class="mb-6">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <x-icon name="academic" class="h-6 w-6" />
                </div>
                <h1 class="text-2xl font-bold text-slate-900">講師ログイン</h1>
                <p class="mt-1 text-sm text-slate-500">問題作成・出題管理を行う講師向けのページです。</p>
            </div>

            @if (session('error'))
                <div class="mb-4 flex items-start gap-2 rounded-xl bg-red-50 p-3 text-sm text-red-700 ring-1 ring-red-200">
                    <x-icon name="x-circle" class="mt-0.5 h-5 w-5 shrink-0" />
                    <span>{!! session('error') !!}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.login.post') }}" @submit="onSubmit">
                @csrf

                <div class="mb-4">
                    <label for="email" class="label">メールアドレス</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <x-icon name="mail" class="h-5 w-5" />
                        </span>
                        <input type="text" id="email" name="email" inputmode="email" autocomplete="username"
                               x-ref="email" x-model="email" @input="onEmailInput"
                               class="input pl-10" placeholder="teacher@example.com" required>
                    </div>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                        <x-icon name="check" class="h-3.5 w-3.5 text-emerald-500" />
                        全角英数字は自動で半角に変換され、前後の空白は削除されます。
                    </p>
                    <template x-if="typo">
                        <div class="mt-2 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-sm text-amber-800 ring-1 ring-amber-200">
                            <x-icon name="alert" class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" />
                            <span x-text="typo ? typo.message : ''"></span>
                        </div>
                    </template>
                </div>

                <div class="mb-4">
                    <label for="password" class="label">パスワード</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <x-icon name="lock" class="h-5 w-5" />
                        </span>
                        <input :type="showPw ? 'text' : 'password'" id="password" name="password"
                               x-ref="password" autocomplete="current-password"
                               class="input px-10" placeholder="パスワード" required>
                        <button type="button" @click="showPw = !showPw"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                                :aria-label="showPw ? 'パスワードを隠す' : 'パスワードを表示'">
                            <x-icon name="eye" class="h-5 w-5" x-show="!showPw" />
                            <x-icon name="eye-off" class="h-5 w-5" x-show="showPw" />
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex items-center justify-between rounded-xl bg-slate-50 p-3 text-xs ring-1 ring-slate-200">
                    <span class="flex items-center gap-1.5 text-slate-500">
                        <x-icon name="bolt" class="h-4 w-4 text-brand-500" />
                        5秒間に15回まで試行可能
                    </span>
                    <span class="badge"
                          :class="remaining > 5 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                : (remaining > 0 ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200'
                                : 'bg-red-50 text-red-700 ring-1 ring-red-200')">
                        残り <span x-text="remaining"></span> 回
                    </span>
                </div>

                <button type="submit" class="btn-primary w-full justify-center" :disabled="remaining <= 0">
                    <x-icon name="academic" class="h-5 w-5" />
                    <span x-text="remaining > 0 ? '講師ログイン' : '試行上限に達しました'"></span>
                </button>
            </form>

            <div class="mt-6 rounded-xl border border-dashed border-emerald-200 bg-emerald-50/50 p-4">
                <div class="flex items-center justify-between">
                    <div class="text-xs font-semibold text-emerald-700">デモアカウント</div>
                    <button type="button" @click="autofill" class="btn-ghost px-2 py-1 text-xs text-brand-600">
                        <x-icon name="copy" class="h-4 w-4" />
                        自動入力
                    </button>
                </div>
                <dl class="mt-2 space-y-1 text-xs text-slate-600">
                    <div class="flex justify-between"><dt>メール</dt><dd class="font-mono">teacher@example.com</dd></div>
                    <div class="flex justify-between"><dt>パスワード</dt><dd class="font-mono">password</dd></div>
                </dl>
            </div>
        </x-card>

        <div class="mt-6 flex items-center justify-center gap-4 text-center text-sm text-slate-400">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 hover:text-slate-600">
                <x-icon name="user" class="h-4 w-4" /> 受講生ログイン
            </a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1 hover:text-slate-600">
                <x-icon name="shield" class="h-4 w-4" /> 管理者ログイン
            </a>
        </div>
    </div>

    <script>
        function loginForm(mistakes) {
            return {
                email: '',
                showPw: false,
                typo: null,
                mistakes: mistakes || [],
                remaining: 15,
                _resetTimer: null,
                _demoEmail: 'teacher@example.com',

                normalize(value) {
                    return value
                        .replace(/[Ａ-Ｚａ-ｚ０-９＠．]/g, c => String.fromCharCode(c.charCodeAt(0) - 0xFEE0))
                        .replace(/^\s+|\s+$/g, '');
                },
                onEmailInput() {
                    const fixed = this.normalize(this.$refs.email.value);
                    if (fixed !== this.$refs.email.value) {
                        this.$refs.email.value = fixed;
                    }
                    this.email = fixed;
                    this.detectTypo();
                },
                detectTypo() {
                    const at = this.email.indexOf('@');
                    this.typo = null;
                    if (at < 0) return;
                    const domain = this.email.slice(at + 1).toLowerCase();
                    this.typo = this.mistakes.find(m => (m.wrong || '').toLowerCase() === domain) || null;
                },
                autofill() {
                    this.$refs.email.value = this._demoEmail;
                    this.email = this._demoEmail;
                    this.$refs.password.value = 'password';
                    this.detectTypo();
                    window.dispatchEvent(new CustomEvent('toast', { detail: { kind: 'success', text: 'デモアカウントを入力しました。' } }));
                },
                onSubmit(e) {
                    if (this.remaining <= 0) {
                        e.preventDefault();
                        return;
                    }
                    this.remaining = Math.max(0, this.remaining - 1);
                    clearTimeout(this._resetTimer);
                    this._resetTimer = setTimeout(() => { this.remaining = 15; }, 5000);
                },
            };
        }
    </script>
@endsection
