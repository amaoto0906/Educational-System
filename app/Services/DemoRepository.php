<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

/**
 * デモ用リポジトリ (DB不使用)。
 * 初回アクセス時に config/demo_data.php をセッションへ展開し、以降は session() 上で CRUD する。
 * 本番では各メソッドを Eloquent モデル / MySQL に差し替える (Repositoryパターン)。
 */
class DemoRepository
{
    /** セッションCRUD対象エンティティ */
    public const ENTITIES = [
        'projects', 'videos', 'materials', 'test_sets', 'questions',
        'teachers', 'staff', 'exam_master', 'email_mistakes', 'mock_exams',
        'notices', 'learning_history', 'review_tests', 'queue_jobs',
        'cron_batches', 'error_logs',
    ];

    // ============ 汎用 CRUD ============

    public static function all(string $key): array
    {
        $skey = 'demo.'.$key;
        if (! Session::has($skey)) {
            Session::put($skey, config('demo_data.'.$key, []));
        }
        return Session::get($skey, []);
    }

    public static function find(string $key, int|string $id): ?array
    {
        foreach (self::all($key) as $row) {
            if ((string) ($row['id'] ?? '') === (string) $id) {
                return $row;
            }
        }
        return null;
    }

    public static function nextId(string $key): int
    {
        $max = 0;
        foreach (self::all($key) as $row) {
            $max = max($max, (int) ($row['id'] ?? 0));
        }
        return $max + 1;
    }

    public static function create(string $key, array $data): array
    {
        $rows = self::all($key);
        $data['id'] = self::nextId($key);
        $rows[] = $data;
        Session::put('demo.'.$key, $rows);
        return $data;
    }

    public static function update(string $key, int|string $id, array $data): void
    {
        $rows = self::all($key);
        foreach ($rows as &$row) {
            if ((string) ($row['id'] ?? '') === (string) $id) {
                $row = array_merge($row, $data);
            }
        }
        unset($row);
        Session::put('demo.'.$key, $rows);
    }

    public static function delete(string $key, int|string $id): void
    {
        Session::put('demo.'.$key, array_values(array_filter(
            self::all($key),
            fn ($r) => (string) ($r['id'] ?? '') !== (string) $id
        )));
    }

    /** ステータスを与えられた候補の次の値へ循環 */
    public static function cycleStatus(string $key, int|string $id, array $values, string $field = 'status'): void
    {
        $row = self::find($key, $id);
        if (! $row) {
            return;
        }
        $cur = $row[$field] ?? $values[0];
        $idx = array_search($cur, $values, true);
        $next = $values[($idx === false ? 0 : $idx + 1) % count($values)];
        self::update($key, $id, [$field => $next]);
    }

    /** 簡易検索 (指定フィールドの部分一致) */
    public static function search(string $key, ?string $q, array $fields): array
    {
        $rows = self::all($key);
        $q = trim((string) $q);
        if ($q === '') {
            return $rows;
        }
        $ql = mb_strtolower($q);
        return array_values(array_filter($rows, function ($r) use ($fields, $ql) {
            foreach ($fields as $f) {
                if (isset($r[$f]) && str_contains(mb_strtolower((string) $r[$f]), $ql)) {
                    return true;
                }
            }
            return false;
        }));
    }

    // ============ 基本情報 (単一レコード) ============

    public static function settings(): array
    {
        if (! Session::has('demo.basic_settings')) {
            Session::put('demo.basic_settings', config('demo_data.basic_settings', []));
        }
        return Session::get('demo.basic_settings', []);
    }

    public static function updateSettings(array $data): void
    {
        Session::put('demo.basic_settings', array_merge(self::settings(), $data));
    }

    // ============ 認証 ============

    public static function currentUser(): ?array
    {
        return Session::get('demo.user');
    }

    public static function attempt(string $email, string $password, ?string $role = null): ?array
    {
        $email = mb_strtolower(trim($email));
        foreach (config('demo_data.accounts', []) as $a) {
            if (mb_strtolower($a['email']) === $email
                && $a['password'] === $password
                && ($role === null || $a['role'] === $role)) {
                Session::put('demo.user', $a);
                return $a;
            }
        }
        return null;
    }

    public static function logout(): void
    {
        Session::forget('demo.user');
    }

    /** 全角英数字→半角・前後空白除去 */
    public static function normalizeEmail(string $raw): string
    {
        $s = mb_convert_kana($raw, 'as');
        $s = str_replace(['＠', '．'], ['@', '.'], $s);
        return trim($s);
    }

    /** 誤ドメイン検出 (gmai.com 等)。該当すれば候補メッセージを返す */
    public static function detectEmailTypo(string $email): ?array
    {
        $at = strpos($email, '@');
        if ($at === false) {
            return null;
        }
        $domain = mb_strtolower(substr($email, $at + 1));
        foreach (self::all('email_mistakes') as $m) {
            if (mb_strtolower($m['wrong']) === $domain) {
                return $m;
            }
        }
        return null;
    }

    // ============ ダッシュボード統計 ============

    public static function studentStats(): array
    {
        $user = self::currentUser() ?? config('demo_data.accounts.0');
        $videos = self::all('videos');
        $publishedVideos = count(array_filter($videos, fn ($v) => ($v['status'] ?? '') === '公開中'));
        $materials = count(array_filter(self::all('materials'), fn ($m) => ($m['status'] ?? '') === '公開中'));
        $tests = self::all('review_tests');
        $incomplete = count(array_filter($tests, fn ($t) => empty($t['completed'])));

        return [
            'progress' => $user['progress'] ?? 62,
            'videos' => $publishedVideos,
            'materials' => $materials,
            'tests_incomplete' => $incomplete,
            'mock_id' => $user['mock_id'] ?? 'MOCK-2026-0001',
            'mock_pw' => $user['mock_pw'] ?? 'Np7t-Xk29',
            'course' => $user['course'] ?? '公務員 総合コース',
        ];
    }

    public static function adminStats(): array
    {
        $queue = self::all('queue_jobs');
        $errors = self::all('error_logs');
        return [
            'students' => 1248,
            'logins_today' => 327,
            'videos' => count(self::all('videos')),
            'materials' => count(self::all('materials')),
            'questions' => count(self::all('questions')),
            'queue_pending' => count(array_filter($queue, fn ($j) => ($j['status'] ?? '') === '未処理')),
            'cron_last' => '2026-06-25 09:00',
            'errors' => count(array_filter($errors, fn ($e) => ($e['status'] ?? '') === '対応中')),
        ];
    }

    public static function teacherStats(): array
    {
        $user = self::currentUser();
        $name = $user['name'] ?? '佐藤 講師';
        $mine = array_filter(self::all('questions'), fn ($q) => true); // デモでは全問を担当扱い
        return [
            'name' => $name,
            'questions' => count($mine),
            'published' => count(array_filter($mine, fn ($q) => ($q['status'] ?? '') === '公開中')),
            'drafts' => count(array_filter($mine, fn ($q) => ($q['status'] ?? '') !== '公開中')),
        ];
    }

    // ============ 復習テスト結果 (セッション保持) ============

    public static function saveTestResult(int $testId, int $score, int $total): void
    {
        $results = Session::get('demo.test_results', []);
        $results[$testId] = ['score' => $score, 'total' => $total, 'at' => now()->format('Y-m-d H:i')];
        Session::put('demo.test_results', $results);
        // 完了フラグ
        self::update('review_tests', $testId, ['completed' => true]);
    }

    public static function testResult(int $testId): ?array
    {
        return Session::get('demo.test_results', [])[$testId] ?? null;
    }

    // ============ 初期化 ============

    public static function reset(): void
    {
        foreach (array_merge(self::ENTITIES, ['basic_settings', 'test_results']) as $key) {
            Session::forget('demo.'.$key);
        }
    }
}
