@extends('layouts.app')

@section('title', '基本設定')

@section('content')
    <x-page-header title="基本設定"
                   description="管理者情報・通知先・サイト全体の設定を管理します。"
                   :breadcrumbs="[['label' => '管理', 'href' => route('admin.dashboard')], ['label' => '基本設定']]">
    </x-page-header>

    <form method="POST" action="{{ route('admin.basic-settings.update') }}">
        @csrf
        @method('PUT')

        <x-card>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-form-input name="admin_name" label="管理者名" :value="$settings['admin_name'] ?? ''" :required="true" />
                <x-form-input name="login_id" label="ログインID" :value="$settings['login_id'] ?? ''" :required="true" />
                <x-form-input name="notify_email" label="通知メールアドレス" type="email" :value="$settings['notify_email'] ?? ''" hint="エラー通知・運用連絡の宛先です。" />
                <x-form-input name="site_name" label="サイト名" :value="$settings['site_name'] ?? ''" />
            </div>

            {{-- メンテナンス表示トグル --}}
            <div class="mt-6 border-t border-slate-100 pt-5">
                <label class="label">メンテナンス表示</label>
                <div class="mt-1 flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50/60 p-4"
                     x-data="{ on: {{ !empty($settings['maintenance']) ? 'true' : 'false' }} }">
                    <div class="min-w-0 pr-4">
                        <p class="text-sm font-medium text-slate-800">メンテナンスモード</p>
                        <p class="mt-0.5 text-xs text-slate-500">有効にすると受講生・講師向け画面にメンテナンス表示を出します。</p>
                    </div>
                    {{-- 未チェック時も false が送信されるよう hidden を先に置く（checkbox が ON のときは value=1 が後勝ち） --}}
                    <input type="hidden" name="maintenance" value="0">
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" name="maintenance" value="1" class="peer sr-only"
                               x-model="on" @checked(!empty($settings['maintenance']))>
                        <span :class="on ? 'bg-brand-600' : 'bg-slate-300'"
                              class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition">
                            <span :class="on ? 'translate-x-5' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition"></span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-100 pt-5">
                <button type="submit" class="btn-primary">
                    <x-icon name="check" class="h-4 w-4" />
                    設定を保存
                </button>
            </div>
        </x-card>
    </form>
@endsection
