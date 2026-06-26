<?php

namespace App\Http\Middleware;

use App\Services\DemoRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * デモ用ロールアクセス制御。セッションのログインユーザーのロールを検証する。
 * 使い方: ->middleware('role:admin') / ('role:student') / ('role:teacher')
 * (実DB/Laravel Auth は使用しない)
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = DemoRepository::currentUser();

        if (! $user) {
            // 各ロールのログイン画面へ誘導
            $loginRoute = match ($role) {
                'admin' => 'admin.login',
                'teacher' => 'teacher.login',
                default => 'login',
            };
            return redirect()->route($loginRoute);
        }

        if ($user['role'] !== $role) {
            // ロール不一致 → 自分のダッシュボードへ
            $home = match ($user['role']) {
                'admin' => 'admin.dashboard',
                'teacher' => 'teacher.dashboard',
                default => 'student.dashboard',
            };
            return redirect()->route($home);
        }

        return $next($request);
    }
}
