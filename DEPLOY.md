# 公開デプロイ手順（GitHub → クラウド → 公開URL）

このプロジェクトは **DB不要・Docker対応** なので、GitHubへ push すれば各種PaaSがLinux上で
`composer install` まで自動実行し、**公開URL（独自ドメイン形式）** を発行できます。
（Windowsローカルで起きていた zip ロック問題は、Linuxのクラウド側では発生しません。）

---

## ステップ1：GitHub へ push

1. https://github.com/new で空のリポジトリを作成（例：`n1-monolith-demo`）。READMEや.gitignoreは**追加しない**。
2. このフォルダで以下を実行（`<あなた>` は GitHubユーザー名）：

```bash
git remote add origin https://github.com/<あなた>/n1-monolith-demo.git
git push -u origin main
```

> 既に初期コミット済みです（`git log` で確認可）。push のみでOK。

---

## ステップ2：公開URLを発行（どちらか選択）

### ▶ 案A：Railway（推奨・常時起動・最も簡単）
1. https://railway.app にGitHubでサインイン。
2. **New Project → Deploy from GitHub repo →** 当リポジトリを選択。
3. Railway が `Dockerfile` を自動検出してビルド・起動します。
4. **Settings → Networking → Generate Domain** で `https://xxxx.up.railway.app` を発行。
5. そのURLをクライアントへ送付。
- 環境変数の設定は不要（Dockerfile内で `APP_KEY` 生成・`PORT` 対応済み）。
- 無料トライアルクレジットあり。常時起動でスリープしません。

### ▶ 案B：Render（完全無料・カード不要）
1. https://render.com にGitHubでサインイン。
2. **New → Web Service →** 当リポジトリを選択。
3. **Runtime: Docker** を選択（`render.yaml` があるので **Blueprint** からでも可）。Plan: **Free**。
4. Create → 自動ビルド後、`https://xxxx.onrender.com` が発行されます。
- 完全無料。ただし**15分間アクセスが無いとスリープ**し、次アクセスの初回のみ起動に30〜60秒かかります（デモ用途は問題なし）。

### ▶ 案C：Fly.io（無料枠・`*.fly.dev`）
```bash
# fly CLI 導入後
fly launch --no-deploy   # Dockerfileを検出（DBは不要なのでスキップ）
fly deploy
fly open
```

---

## デプロイ後の確認（クライアント共有前チェック）
- トップ `/` が表示される
- `/login` で `student@example.com` / `password` → 受講生ダッシュボード
- `/admin/login` で `admin@example.com` / `password` → 管理者（CRUD・各モニター）
- `/teacher/login` で `teacher@example.com` / `password` → 講師
- 復習テスト受験→採点、資料DLトースト、一括登録の疑似進捗、CRUDの登録/編集/削除が動作

## クライアントへの共有メッセージ例
> 教育系システムのLaravel/Livewireモノリス移行デモを以下のURLで公開しました。
> URL: https://xxxx.up.railway.app
> ・受講生 student@example.com / password
> ・管理者 admin@example.com / password
> ・講師　 teacher@example.com / password
> DB不要のデモ構成ですが、ログイン・CRUD・復習テスト・一括登録・運用監視など主要機能はすべて動作します。

---

## 補足：独自ドメイン（任意）
Railway/Render とも、発行URLに加えて **Custom Domain** を各サービスのSettingsから追加できます
（お客様提示用に `demo.example.com` などを割当可能）。
