<?php

namespace App\Services;

/**
 * 管理CRUD画面のメタ定義。
 * 各エンティティのラベル・フィールド・一覧列・ステータス候補・検索対象を集約し、
 * 汎用 index/form ビューを駆動する (DRYな管理画面)。
 */
class CrudMeta
{
    public static function all(): array
    {
        $pub = ['公開中', '下書き', '非公開'];

        return [
            'projects' => [
                'label' => '企画管理', 'icon' => 'folder', 'singular' => '企画',
                'status_field' => 'status', 'status_values' => $pub,
                'search' => ['name', 'course'],
                'columns' => [
                    ['key' => 'name', 'label' => '企画名'],
                    ['key' => 'course', 'label' => '対象講座'],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                    ['key' => 'videos', 'label' => '動画数'],
                    ['key' => 'materials', 'label' => '資料数'],
                    ['key' => 'tests', 'label' => 'テスト数'],
                    ['key' => 'updated_at', 'label' => '更新日'],
                ],
                'fields' => [
                    ['name' => 'name', 'label' => '企画名', 'type' => 'text', 'required' => true],
                    ['name' => 'course', 'label' => '対象講座', 'type' => 'text', 'required' => true],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => $pub],
                    ['name' => 'videos', 'label' => '動画数', 'type' => 'number'],
                    ['name' => 'materials', 'label' => '資料数', 'type' => 'number'],
                    ['name' => 'tests', 'label' => '復習テスト数', 'type' => 'number'],
                ],
            ],
            'videos' => [
                'label' => '動画管理', 'icon' => 'video', 'singular' => '動画',
                'status_field' => 'status', 'status_values' => $pub,
                'search' => ['title', 'teacher'],
                'columns' => [
                    ['key' => 'title', 'label' => 'タイトル'],
                    ['key' => 'teacher', 'label' => '講師名'],
                    ['key' => 'duration', 'label' => '時間'],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                    ['key' => 'sort', 'label' => '並び順'],
                ],
                'fields' => [
                    ['name' => 'title', 'label' => 'タイトル', 'type' => 'text', 'required' => true],
                    ['name' => 'vimeo_url', 'label' => 'Vimeo URL', 'type' => 'text'],
                    ['name' => 'teacher', 'label' => '講師名', 'type' => 'text'],
                    ['name' => 'duration', 'label' => '視聴時間 (例 32:10)', 'type' => 'text'],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => $pub],
                    ['name' => 'sort', 'label' => '並び順', 'type' => 'number'],
                ],
            ],
            'materials' => [
                'label' => 'PDF資料管理', 'icon' => 'document', 'singular' => '資料',
                'status_field' => 'status', 'status_values' => $pub,
                'search' => ['title', 'category'],
                'columns' => [
                    ['key' => 'title', 'label' => 'タイトル'],
                    ['key' => 'category', 'label' => 'カテゴリ'],
                    ['key' => 'filename', 'label' => 'ファイル名'],
                    ['key' => 'size', 'label' => 'サイズ'],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                    ['key' => 'sort', 'label' => '並び順'],
                ],
                'fields' => [
                    ['name' => 'title', 'label' => 'タイトル', 'type' => 'text', 'required' => true],
                    ['name' => 'category', 'label' => 'カテゴリ', 'type' => 'text'],
                    ['name' => 'filename', 'label' => 'ファイル名', 'type' => 'text'],
                    ['name' => 'size', 'label' => 'ファイルサイズ (例 2.4 MB)', 'type' => 'text'],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => $pub],
                    ['name' => 'sort', 'label' => '並び順', 'type' => 'number'],
                ],
            ],
            'test_sets' => [
                'label' => '復習問題セット管理', 'icon' => 'clipboard', 'singular' => 'セット',
                'status_field' => 'status', 'status_values' => $pub,
                'search' => ['name', 'course'],
                'columns' => [
                    ['key' => 'name', 'label' => 'セット名'],
                    ['key' => 'course', 'label' => '対象講座'],
                    ['key' => 'questions', 'label' => '問題数'],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                    ['key' => 'updated_at', 'label' => '更新日'],
                ],
                'fields' => [
                    ['name' => 'name', 'label' => 'セット名', 'type' => 'text', 'required' => true],
                    ['name' => 'course', 'label' => '対象講座', 'type' => 'text'],
                    ['name' => 'questions', 'label' => '問題数', 'type' => 'number'],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => $pub],
                ],
            ],
            'questions' => [
                'label' => '問題管理', 'icon' => 'help', 'singular' => '問題',
                'status_field' => 'status', 'status_values' => ['公開中', '下書き'],
                'search' => ['body', 'set'],
                'columns' => [
                    ['key' => 'body', 'label' => '問題文', 'truncate' => 40],
                    ['key' => 'set', 'label' => 'セット'],
                    ['key' => 'correct', 'label' => '正解'],
                    ['key' => 'difficulty', 'label' => '難易度', 'badge' => true],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                ],
                'fields' => [
                    ['name' => 'set', 'label' => '対象セット', 'type' => 'text'],
                    ['name' => 'body', 'label' => '問題文', 'type' => 'textarea', 'required' => true],
                    ['name' => 'a', 'label' => '選択肢A', 'type' => 'text'],
                    ['name' => 'b', 'label' => '選択肢B', 'type' => 'text'],
                    ['name' => 'c', 'label' => '選択肢C', 'type' => 'text'],
                    ['name' => 'd', 'label' => '選択肢D', 'type' => 'text'],
                    ['name' => 'correct', 'label' => '正解', 'type' => 'select', 'options' => ['A', 'B', 'C', 'D']],
                    ['name' => 'explanation', 'label' => '解説', 'type' => 'textarea'],
                    ['name' => 'difficulty', 'label' => '難易度', 'type' => 'select', 'options' => ['易', '中', '難']],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => ['公開中', '下書き']],
                ],
            ],
            'teachers' => [
                'label' => '講師管理', 'icon' => 'user', 'singular' => '講師',
                'status_field' => 'status', 'status_values' => ['稼働中', '休止中'],
                'search' => ['name', 'email', 'subject'],
                'columns' => [
                    ['key' => 'name', 'label' => '講師名'],
                    ['key' => 'email', 'label' => 'メール'],
                    ['key' => 'subject', 'label' => '担当科目'],
                    ['key' => 'questions', 'label' => '作成問題数'],
                    ['key' => 'status', 'label' => 'ステータス', 'badge' => true],
                ],
                'fields' => [
                    ['name' => 'name', 'label' => '講師名', 'type' => 'text', 'required' => true],
                    ['name' => 'email', 'label' => 'メール', 'type' => 'text'],
                    ['name' => 'subject', 'label' => '担当科目', 'type' => 'text'],
                    ['name' => 'questions', 'label' => '作成問題数', 'type' => 'number'],
                    ['name' => 'status', 'label' => 'ステータス', 'type' => 'select', 'options' => ['稼働中', '休止中']],
                ],
            ],
            'staff' => [
                'label' => '担当者管理', 'icon' => 'users', 'singular' => '担当者',
                'status_field' => 'status', 'status_values' => ['有効', '無効'],
                'search' => ['name', 'email'],
                'columns' => [
                    ['key' => 'name', 'label' => '担当者名'],
                    ['key' => 'email', 'label' => 'メール'],
                    ['key' => 'permission', 'label' => '権限', 'badge' => true],
                    ['key' => 'status', 'label' => 'ステータス', 'badge' => true],
                ],
                'fields' => [
                    ['name' => 'name', 'label' => '担当者名', 'type' => 'text', 'required' => true],
                    ['name' => 'email', 'label' => 'メール', 'type' => 'text'],
                    ['name' => 'permission', 'label' => '権限', 'type' => 'select', 'options' => ['管理者', '運用担当', '閲覧のみ']],
                    ['name' => 'status', 'label' => 'ステータス', 'type' => 'select', 'options' => ['有効', '無効']],
                ],
            ],
            'exam_master' => [
                'label' => '試験マスタ管理', 'icon' => 'academic', 'singular' => '試験',
                'status_field' => 'status', 'status_values' => $pub,
                'search' => ['name'],
                'columns' => [
                    ['key' => 'name', 'label' => '試験名'],
                    ['key' => 'url', 'label' => '受験URL'],
                    ['key' => 'status', 'label' => '公開状態', 'badge' => true],
                ],
                'fields' => [
                    ['name' => 'name', 'label' => '試験名', 'type' => 'text', 'required' => true],
                    ['name' => 'url', 'label' => '受験URL', 'type' => 'text'],
                    ['name' => 'description', 'label' => '表示説明文', 'type' => 'textarea'],
                    ['name' => 'status', 'label' => '公開状態', 'type' => 'select', 'options' => $pub],
                ],
            ],
            'email_mistakes' => [
                'label' => 'アドレスミス管理', 'icon' => 'mail', 'singular' => '誤ドメイン',
                'status_field' => null, 'status_values' => [],
                'search' => ['wrong', 'correct'],
                'columns' => [
                    ['key' => 'wrong', 'label' => '誤ドメイン'],
                    ['key' => 'correct', 'label' => '正しい候補'],
                    ['key' => 'message', 'label' => '表示メッセージ'],
                ],
                'fields' => [
                    ['name' => 'wrong', 'label' => '誤ドメイン', 'type' => 'text', 'required' => true],
                    ['name' => 'correct', 'label' => '正しい候補', 'type' => 'text', 'required' => true],
                    ['name' => 'message', 'label' => '表示メッセージ', 'type' => 'text'],
                ],
            ],
        ];
    }

    public static function get(string $entity): ?array
    {
        return self::all()[$entity] ?? null;
    }
}
