@props(['status' => ''])
@php
    $map = [
        '公開中' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '下書き' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        '非公開' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        '稼働中' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '休止中' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        '有効' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '無効' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        '易' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '中' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        '難' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        '管理者' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
        '運用担当' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        '閲覧のみ' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        '成功' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '失敗' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        '実行中' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        '未処理' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        '正常' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        '警告' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        '対応中' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        '解決済' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        'A' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
        'B' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
        'C' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
        'D' => 'bg-brand-50 text-brand-700 ring-1 ring-brand-200',
    ];
    $cls = $map[$status] ?? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200';
@endphp
<span class="badge {{ $cls }}">{{ $status }}</span>
