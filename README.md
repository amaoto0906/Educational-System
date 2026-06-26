# n1-monolith-demo — 教育系システム Laravel/Livewireモノリス移行デモ

## 1. プロジェクト概要
現行の「Next.js＋Laravel API」の二重構造を、**Laravel 11＋Blade＋Alpine.js＋Tailwind CSS** による軽量モノリス構成へ移行するイメージを、クライアントに提示するための**デモ版**です。受講生・管理者・講師の3ロールに対応し、学習マイページから管理CRUD・運用監視（Queue/Cron/エラー）までを一通り体験できます。

> 画面上部に常時「Laravel 11 / Livewire 3 / Alpine.js / Tailwind CSS モノリス移行デモ」と表示されます。

## 2. デモの目的
- 本番実装前に、**UI・画面遷移・操作感・機能範囲**をクライアントが確認できること。
- 「保守性の向上・負荷対策・障害再発防止」という移行の狙いを、運用画面（Queue/Cron/エラーログ/負荷対策カード）で可視化すること。
- DBを使わずに**すぐ起動**でき、本番ではMySQL/Eloquentへ無理なく差し替えられる構造を示すこと。

## 3. 使用技術
- Laravel 11 / PHP 8.2+
- Blade（コンポーネント構成）＋ Alpine.js（クライアント挙動）
- Tailwind CSS（**Play CDN**：Nodeビルド不要）
- データ：**config/demo_data.php ＋ session**（**DB不使用**）
- Repositoryパターン：`App\Services\DemoRepository`（本番でEloquentへ差し替え）

> Livewire 3 を見据えたコンポーネント構成ですが、デモでは依存を最小化するため Controller＋Blade＋Alpine で同等のUX（モーダル/トースト/ステップ式テスト/疑似保存）を実現しています。

## 4. 起動方法
```bash
composer install
cp .env.example .env      # Windows(PowerShell): copy .env.example .env
php artisan key:generate
php artisan serve          # → http://localhost:8000
```
- `.env` は既定で `SESSION_DRIVER=file` / `CACHE_STORE=file` / `QUEUE_CONNECTION=sync`。**MySQL不要・DB接続は発生しません。**
- `storage/` と `bootstrap/cache/` に書き込み権限が必要です。

## 5. デモアカウント（パスワードは全て `password`）
| ロール | URL | メール |
|---|---|---|
| 受講生 | `/login` | `student@example.com` |
| 管理者 | `/admin/login` | `admin@example.com` |
| 講師 | `/teacher/login` | `teacher@example.com` |

ログイン画面では、パスワード表示切替・全角→半角自動変換・前後空白除去・誤ドメイン警告（gmai.com 等）・Rate Limiter風ステータス・デモ自動入力を実装しています。

## 6. 実装画面一覧（全34ルート）
- 公開：`/`（トップ）、`/roadmap`、`/login`、`/register`、`/admin/login`、`/teacher/login`
- 受講生：`/student/dashboard`、`/videos`、`/materials`、`/mock-exam`、`/review-tests`、`/review-tests/{id}`、`/review-tests/{id}/result`
- 管理者：`/admin/dashboard`、企画`/admin/projects`、動画`/admin/videos`、資料`/admin/materials`、問題セット`/admin/test_sets`、問題`/admin/questions`、講師`/admin/teachers`、担当者`/admin/staff`、試験マスタ`/admin/exam_master`、アドレスミス`/admin/email_mistakes`（各 一覧/作成/編集/削除/ステータス変更）、`/admin/basic-settings`、`/admin/bulk-register`、`/admin/queue-monitor`、`/admin/cron-monitor`、`/admin/error-logs`
- 講師：`/teacher/dashboard`、`/teacher/questions`（一覧/作成/編集/削除）

※ 管理CRUDのURLは内部キー（`test_sets`/`exam_master`/`email_mistakes`）をそのままスラッグに使用しています。

## 7. モックデータの場所
- 初期データ：**`config/demo_data.php`**（部品＝企画/動画/資料/問題/講師/担当者/試験/アドレスミス/模試/お知らせ/履歴/復習テスト/Queue/Cron/エラーログ、全て日本語）
- 永続化・CRUD・認証・テスト結果：**`app/Services/DemoRepository.php`**（session）
- 管理CRUDのフィールド定義：**`app/Services/CrudMeta.php`**

## 8. 本番開発時に必要な差し替え箇所
| デモ | 本番 |
|---|---|
| `config/demo_data.php` + session | MySQL 8.0 テーブル + Eloquent モデル |
| `DemoRepository`（session CRUD） | Eloquent ベースの Repository 実装（インターフェースは流用可） |
| `DemoAuthController` の簡易認証 | Laravel 認証（Fortify/Breeze）＋ `auth` ミドルウェア |
| `EnsureRole` ミドルウェア | Policy/Gate ＋ ロール管理 |
| 一括登録の疑似進捗 | 実 Queue（Redis等）＋ Job ＋ bulk insert/transaction |
| Queue/Cron/エラーログのモック | Horizon/スケジューラ（`withoutOverlapping`）/ ログ基盤・通知 |
| Tailwind Play CDN | Vite ビルド（`@tailwind` ＋ purge） |

## 9. クライアント提示時の説明文（例）
> 本デモは、現行のNext.js＋Laravel APIの二重構造を、Laravel 11のモノリスへ移行した場合の画面・操作感・機能範囲をご確認いただくものです。データベースを使わずに動作しますが、CRUD・ログイン・復習テスト・一括登録・運用監視など主要機能はすべて実際に動作します。本番では、ここで採用したRepository構造をそのままMySQL＋Eloquentへ置き換え、認証・Queue・Cron・Rate Limiterを実インフラに接続します。500人規模の一斉ログインを想定したN+1回避・非同期化・多重起動防止といった負荷対策方針も、管理ダッシュボードで可視化しています。

---
© 2026 N1 学習プラットフォーム — Demo build.
