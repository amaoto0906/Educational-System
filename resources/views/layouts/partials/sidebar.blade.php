@php
    use App\Services\DemoRepository;
    $user = DemoRepository::currentUser();
    $role = $user['role'] ?? 'student';
    $entity = request()->route('entity');

    $crud = fn ($e, $label, $icon) => [
        'label' => $label, 'icon' => $icon,
        'href' => route('admin.crud.index', $e),
        'active' => request()->routeIs('admin.crud.*') && $entity === $e,
    ];
    $link = fn ($routeName, $label, $icon) => [
        'label' => $label, 'icon' => $icon, 'href' => route($routeName),
        'active' => request()->routeIs($routeName),
    ];

    if ($role === 'admin') {
        $groups = [
            ['title' => '概要', 'items' => [$link('admin.dashboard', 'ダッシュボード', 'dashboard')]],
            ['title' => 'コンテンツ', 'items' => [
                $crud('projects', '企画管理', 'folder'),
                $crud('videos', '動画管理', 'video'),
                $crud('materials', 'PDF資料管理', 'document'),
                $crud('test_sets', '復習問題セット', 'clipboard'),
                $crud('questions', '問題管理', 'help'),
            ]],
            ['title' => '体制', 'items' => [
                $crud('teachers', '講師管理', 'user'),
                $crud('staff', '担当者管理', 'users'),
            ]],
            ['title' => '試験', 'items' => [
                $crud('exam_master', '試験マスタ管理', 'academic'),
                $crud('email_mistakes', 'アドレスミス管理', 'mail'),
            ]],
            ['title' => '運用', 'items' => [
                $link('admin.bulk-register', '一括登録', 'layers'),
                $link('admin.queue-monitor', 'Queueモニター', 'database'),
                $link('admin.cron-monitor', 'Cronモニター', 'clock'),
                $link('admin.error-logs', 'エラーログ', 'alert'),
                $link('admin.basic-settings', '基本情報管理', 'cog'),
            ]],
        ];
    } elseif ($role === 'teacher') {
        $groups = [
            ['title' => 'メニュー', 'items' => [
                $link('teacher.dashboard', 'ダッシュボード', 'dashboard'),
                $link('teacher.questions', '担当問題', 'help'),
            ]],
        ];
    } else {
        $groups = [
            ['title' => 'マイページ', 'items' => [
                $link('student.dashboard', 'ダッシュボード', 'dashboard'),
                $link('student.videos', '動画教材', 'video'),
                $link('student.materials', '資料', 'document'),
                $link('student.mock-exam', '模試ID/PW', 'academic'),
                $link('student.review-tests', '復習テスト', 'clipboard'),
            ]],
        ];
    }
    $roleLabel = ['admin' => '管理者', 'teacher' => '講師', 'student' => '受講生'][$role] ?? '受講生';
@endphp

<div class="flex h-16 items-center gap-2.5 border-b border-slate-200 px-5">
    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white">
        <x-icon name="book" class="h-5 w-5" />
    </div>
    <div class="leading-tight">
        <div class="text-sm font-bold text-slate-900">N1 学習PF</div>
        <div class="text-[10px] font-medium text-brand-600">{{ $roleLabel }}コンソール</div>
    </div>
</div>

<nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
    @foreach ($groups as $group)
        <div>
            <div class="px-3 pb-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-400">{{ $group['title'] }}</div>
            <div class="space-y-1">
                @foreach ($group['items'] as $item)
                    <a href="{{ $item['href'] }}" class="sidebar-link {{ $item['active'] ? 'sidebar-link-active' : '' }}">
                        <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>

<div class="border-t border-slate-200 p-3">
    <a href="{{ route('roadmap') }}" class="sidebar-link">
        <x-icon name="rocket" class="h-5 w-5 shrink-0" />
        <span>ロードマップ</span>
    </a>
    <div class="mt-2 px-3 text-[10px] leading-relaxed text-slate-400">
        N1 学習プラットフォーム<br>デモ環境
    </div>
</div>
