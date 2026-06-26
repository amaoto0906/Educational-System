<?php

namespace App\Http\Controllers;

use App\Services\DemoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class DemoAuthController extends Controller
{
    // ===== 画面表示 =====
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showTeacherLogin()
    {
        return view('auth.teacher-login');
    }

    // ===== ログイン処理 =====
    public function login(Request $request)
    {
        return $this->doLogin($request, 'student', 'student.dashboard');
    }

    public function adminLogin(Request $request)
    {
        return $this->doLogin($request, 'admin', 'admin.dashboard');
    }

    public function teacherLogin(Request $request)
    {
        return $this->doLogin($request, 'teacher', 'teacher.dashboard');
    }

    private function doLogin(Request $request, string $role, string $redirect)
    {
        $email = DemoRepository::normalizeEmail((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        // Rate Limiter: 5秒間に15回まで
        $key = 'login:'.$role.':'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 15)) {
            $secs = RateLimiter::availableIn($key);
            return back()->with('error', "429: 試行回数が上限に達しました。{$secs}秒後に再試行してください。")->withInput();
        }
        RateLimiter::hit($key, 5);

        $user = DemoRepository::attempt($email, $password, $role);
        if (! $user) {
            // 別ロールで一致するか確認して誘導メッセージを出す
            $other = DemoRepository::attempt($email, $password, null);
            if ($other) {
                $map = ['admin' => ['管理者', '/admin/login'], 'teacher' => ['講師', '/teacher/login'], 'student' => ['受講生', '/login']];
                [$label, $url] = $map[$other['role']] ?? ['他のロール', '/login'];
                return back()->with('error', "このアカウントは{$label}用です。<a href=\"{$url}\" class=\"underline font-semibold\">{$label}ログインページ</a>をご利用ください。")->withInput();
            }
            return back()->with('error', 'メールアドレスまたはパスワードが正しくありません。')->withInput();
        }

        RateLimiter::clear($key);
        return redirect()->route($redirect)->with('toast', 'ようこそ、'.$user['name'].' さん');
    }

    public function register(Request $request)
    {
        // デモ: 実登録は行わず受付完了のみ
        return redirect()->route('login')->with('toast', '（デモ）登録を受け付けました。デモアカウントでログインしてください。');
    }

    public function logout(Request $request)
    {
        DemoRepository::logout();
        return redirect()->route('login')->with('toast', 'ログアウトしました。');
    }
}
