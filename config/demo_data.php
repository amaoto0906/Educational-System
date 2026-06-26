<?php

/**
 * デモ用モックデータ (DB不使用)。
 * DemoRepository が初回アクセス時にこの内容をセッションへ展開し、以降はセッションで CRUD する。
 * 本番では各 key を MySQL テーブル + Eloquent に差し替える。
 */

return [

    // ===== ログインアカウント =====
    'accounts' => [
        [
            'id' => 1, 'role' => 'student', 'name' => '山田 太郎',
            'email' => 'student@example.com', 'password' => 'password',
            'course' => '公務員 総合コース', 'progress' => 62,
            'mock_id' => 'MOCK-2026-0001', 'mock_pw' => 'Np7t-Xk29',
        ],
        [
            'id' => 2, 'role' => 'admin', 'name' => '管理者 花子',
            'email' => 'admin@example.com', 'password' => 'password',
        ],
        [
            'id' => 3, 'role' => 'teacher', 'name' => '佐藤 講師',
            'email' => 'teacher@example.com', 'password' => 'password',
            'subject' => '数的処理',
        ],
    ],

    // ===== 企画管理 =====
    'projects' => [
        ['id' => 1, 'name' => '2026 公務員 春期総合', 'course' => '公務員 総合コース', 'status' => '公開中', 'videos' => 24, 'materials' => 18, 'tests' => 6, 'updated_at' => '2026-06-20'],
        ['id' => 2, 'name' => 'SPI 対策パック', 'course' => '就活 SPIコース', 'status' => '公開中', 'videos' => 16, 'materials' => 12, 'tests' => 4, 'updated_at' => '2026-06-18'],
        ['id' => 3, 'name' => '面接対策 集中講座', 'course' => '就活 面接コース', 'status' => '下書き', 'videos' => 8, 'materials' => 5, 'tests' => 2, 'updated_at' => '2026-06-15'],
        ['id' => 4, 'name' => '数的処理 弱点克服', 'course' => '公務員 数的コース', 'status' => '公開中', 'videos' => 20, 'materials' => 9, 'tests' => 5, 'updated_at' => '2026-06-12'],
        ['id' => 5, 'name' => '時事・一般常識', 'course' => '教養コース', 'status' => '非公開', 'videos' => 10, 'materials' => 14, 'tests' => 3, 'updated_at' => '2026-05-30'],
    ],

    // ===== 動画管理 =====
    'videos' => [
        ['id' => 1, 'title' => '数的処理①：速さと比', 'vimeo_url' => 'https://vimeo.com/000000001', 'teacher' => '佐藤 講師', 'status' => '公開中', 'duration' => '32:10', 'sort' => 1, 'watched' => true],
        ['id' => 2, 'title' => '判断推理：対応関係', 'vimeo_url' => 'https://vimeo.com/000000002', 'teacher' => '鈴木 講師', 'status' => '公開中', 'duration' => '28:45', 'sort' => 2, 'watched' => true],
        ['id' => 3, 'title' => '文章理解：要旨把握', 'vimeo_url' => 'https://vimeo.com/000000003', 'teacher' => '高橋 講師', 'status' => '公開中', 'duration' => '24:30', 'sort' => 3, 'watched' => false],
        ['id' => 4, 'title' => '時事対策：2026年の動向', 'vimeo_url' => 'https://vimeo.com/000000004', 'teacher' => '田中 講師', 'status' => '公開中', 'duration' => '41:05', 'sort' => 4, 'watched' => false],
        ['id' => 5, 'title' => 'SPI 非言語：仕事算', 'vimeo_url' => 'https://vimeo.com/000000005', 'teacher' => '佐藤 講師', 'status' => '公開中', 'duration' => '19:50', 'sort' => 5, 'watched' => false],
        ['id' => 6, 'title' => '面接：頻出質問と回答例', 'vimeo_url' => 'https://vimeo.com/000000006', 'teacher' => '高橋 講師', 'status' => '公開中', 'duration' => '36:20', 'sort' => 6, 'watched' => false],
        ['id' => 7, 'title' => '数的処理②：場合の数', 'vimeo_url' => 'https://vimeo.com/000000007', 'teacher' => '佐藤 講師', 'status' => '下書き', 'duration' => '30:00', 'sort' => 7, 'watched' => false],
        ['id' => 8, 'title' => '資料解釈：グラフ読解', 'vimeo_url' => 'https://vimeo.com/000000008', 'teacher' => '鈴木 講師', 'status' => '公開中', 'duration' => '22:15', 'sort' => 8, 'watched' => false],
    ],

    // ===== PDF資料管理 =====
    'materials' => [
        ['id' => 1, 'title' => '数的処理 重要公式集', 'category' => '数的処理', 'filename' => 'suuteki_koushiki.pdf', 'size' => '2.4 MB', 'status' => '公開中', 'sort' => 1, 'updated_at' => '2026-06-19'],
        ['id' => 2, 'title' => '判断推理 解法パターン', 'category' => '判断推理', 'filename' => 'handan_pattern.pdf', 'size' => '3.1 MB', 'status' => '公開中', 'sort' => 2, 'updated_at' => '2026-06-17'],
        ['id' => 3, 'title' => '文章理解 演習問題', 'category' => '文章理解', 'filename' => 'bunshou_enshu.pdf', 'size' => '1.8 MB', 'status' => '公開中', 'sort' => 3, 'updated_at' => '2026-06-16'],
        ['id' => 4, 'title' => '時事キーワード 2026', 'category' => '時事', 'filename' => 'jiji_2026.pdf', 'size' => '4.2 MB', 'status' => '公開中', 'sort' => 4, 'updated_at' => '2026-06-14'],
        ['id' => 5, 'title' => 'SPI 模擬問題セット', 'category' => 'SPI', 'filename' => 'spi_mock.pdf', 'size' => '2.9 MB', 'status' => '公開中', 'sort' => 5, 'updated_at' => '2026-06-11'],
        ['id' => 6, 'title' => '面接 自己分析シート', 'category' => '面接', 'filename' => 'mensetsu_sheet.pdf', 'size' => '0.9 MB', 'status' => '公開中', 'sort' => 6, 'updated_at' => '2026-06-10'],
        ['id' => 7, 'title' => '一般常識 まとめ', 'category' => '教養', 'filename' => 'ippan_matome.pdf', 'size' => '3.6 MB', 'status' => '下書き', 'sort' => 7, 'updated_at' => '2026-06-05'],
        ['id' => 8, 'title' => '小論文 書き方ガイド', 'category' => '論文', 'filename' => 'shouronbun_guide.pdf', 'size' => '1.5 MB', 'status' => '公開中', 'sort' => 8, 'updated_at' => '2026-06-02'],
    ],

    // ===== 復習問題セット管理 =====
    'test_sets' => [
        ['id' => 1, 'name' => '数的処理 基礎チェック', 'course' => '公務員 数的コース', 'questions' => 5, 'status' => '公開中', 'updated_at' => '2026-06-18'],
        ['id' => 2, 'name' => '判断推理 確認テスト', 'course' => '公務員 総合コース', 'questions' => 5, 'status' => '公開中', 'updated_at' => '2026-06-15'],
        ['id' => 3, 'name' => '時事・一般常識 小テスト', 'course' => '教養コース', 'questions' => 5, 'status' => '下書き', 'updated_at' => '2026-06-10'],
    ],

    // ===== 問題管理 (フラット) =====
    'questions' => [
        ['id' => 1, 'set' => '数的処理 基礎チェック', 'body' => '時速60kmで2時間進むと何km進むか。', 'a' => '90km', 'b' => '100km', 'c' => '120km', 'd' => '150km', 'correct' => 'C', 'explanation' => '60×2=120km。', 'difficulty' => '易', 'status' => '公開中'],
        ['id' => 2, 'set' => '数的処理 基礎チェック', 'body' => '原価1000円の品に2割の利益を見込んだ定価は。', 'a' => '1100円', 'b' => '1200円', 'c' => '1250円', 'd' => '1300円', 'correct' => 'B', 'explanation' => '1000×1.2=1200円。', 'difficulty' => '易', 'status' => '公開中'],
        ['id' => 3, 'set' => '数的処理 基礎チェック', 'body' => '3人で6日かかる仕事を2人で行うと何日。', 'a' => '7日', 'b' => '8日', 'c' => '9日', 'd' => '10日', 'correct' => 'C', 'explanation' => '仕事量18人日 ÷2人=9日。', 'difficulty' => '中', 'status' => '公開中'],
        ['id' => 4, 'set' => '判断推理 確認テスト', 'body' => 'A,B,C の順位で「AはBより上」「CはAより上」。1位は。', 'a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => '不明', 'correct' => 'C', 'explanation' => 'C>A>B。', 'difficulty' => '中', 'status' => '公開中'],
        ['id' => 5, 'set' => '時事・一般常識 小テスト', 'body' => '日本の国会は何院制か。', 'a' => '一院制', 'b' => '二院制', 'c' => '三院制', 'd' => '無院制', 'correct' => 'B', 'explanation' => '衆議院と参議院の二院制。', 'difficulty' => '易', 'status' => '公開中'],
        ['id' => 6, 'set' => '判断推理 確認テスト', 'body' => '集合：30人中、犬好き18・猫好き15・両方8。どちらも好きでないのは。', 'a' => '3人', 'b' => '5人', 'c' => '7人', 'd' => '8人', 'correct' => 'B', 'explanation' => '18+15-8=25、30-25=5人。', 'difficulty' => '中', 'status' => '下書き'],
    ],

    // ===== 講師管理 =====
    'teachers' => [
        ['id' => 1, 'name' => '佐藤 講師', 'email' => 'sato@example.com', 'subject' => '数的処理', 'questions' => 42, 'status' => '稼働中'],
        ['id' => 2, 'name' => '鈴木 講師', 'email' => 'suzuki@example.com', 'subject' => '判断推理', 'questions' => 35, 'status' => '稼働中'],
        ['id' => 3, 'name' => '高橋 講師', 'email' => 'takahashi@example.com', 'subject' => '文章理解・面接', 'questions' => 28, 'status' => '稼働中'],
        ['id' => 4, 'name' => '田中 講師', 'email' => 'tanaka@example.com', 'subject' => '時事', 'questions' => 17, 'status' => '休止中'],
    ],

    // ===== 担当者管理 =====
    'staff' => [
        ['id' => 1, 'name' => '管理者 花子', 'email' => 'admin@example.com', 'permission' => '管理者', 'status' => '有効'],
        ['id' => 2, 'name' => '運用 次郎', 'email' => 'ops@example.com', 'permission' => '運用担当', 'status' => '有効'],
        ['id' => 3, 'name' => '閲覧 三郎', 'email' => 'viewer@example.com', 'permission' => '閲覧のみ', 'status' => '無効'],
    ],

    // ===== 試験マスタ管理 =====
    'exam_master' => [
        ['id' => 1, 'name' => '第1回 全国模試', 'url' => 'https://exam.example.com/n1-001', 'description' => '出題範囲：数的・判断・文章理解', 'status' => '公開中'],
        ['id' => 2, 'name' => '第2回 全国模試', 'url' => 'https://exam.example.com/n1-002', 'description' => '出題範囲：教養全般', 'status' => '公開中'],
        ['id' => 3, 'name' => 'SPI 模試', 'url' => 'https://exam.example.com/spi-001', 'description' => '言語・非言語・性格', 'status' => '下書き'],
    ],

    // ===== アドレスミス管理 =====
    'email_mistakes' => [
        ['id' => 1, 'wrong' => 'gmai.com', 'correct' => 'gmail.com', 'message' => 'gmail.com の誤りではありませんか？'],
        ['id' => 2, 'wrong' => 'yaho.co.jp', 'correct' => 'yahoo.co.jp', 'message' => 'yahoo.co.jp の誤りではありませんか？'],
        ['id' => 3, 'wrong' => 'hotmial.com', 'correct' => 'hotmail.com', 'message' => 'hotmail.com の誤りではありませんか？'],
        ['id' => 4, 'wrong' => 'outlok.com', 'correct' => 'outlook.com', 'message' => 'outlook.com の誤りではありませんか？'],
        ['id' => 5, 'wrong' => 'icloud.con', 'correct' => 'icloud.com', 'message' => 'icloud.com の誤りではありませんか？'],
    ],

    // ===== 基本情報管理 (単一レコード) =====
    'basic_settings' => [
        'admin_name' => '管理者 花子',
        'login_id' => 'admin@example.com',
        'notify_email' => 'notify@example.com',
        'site_name' => 'N1 学習プラットフォーム',
        'maintenance' => false,
    ],

    // ===== 模試ID/PW (受講生向け) =====
    'mock_exams' => [
        ['id' => 1, 'name' => '第1回 全国模試', 'mock_id' => 'MOCK-2026-0001', 'password' => 'Np7t-Xk29', 'url' => 'https://exam.example.com/n1-001', 'note' => '受験期間：6/25〜7/10。開始後120分。'],
        ['id' => 2, 'name' => '第2回 全国模試', 'mock_id' => 'MOCK-2026-0002', 'password' => 'Qz3v-Lm84', 'url' => 'https://exam.example.com/n1-002', 'note' => '受験期間：7/15〜7/31。開始後120分。'],
        ['id' => 3, 'name' => 'SPI 模試', 'mock_id' => 'SPI-2026-0007', 'password' => 'Rb9s-Tt61', 'url' => 'https://exam.example.com/spi-001', 'note' => '言語35分・非言語40分。'],
    ],

    // ===== お知らせ =====
    'notices' => [
        ['id' => 1, 'date' => '2026-06-24', 'title' => '第2回 全国模試の申込を開始しました', 'tag' => '模試'],
        ['id' => 2, 'date' => '2026-06-20', 'title' => '数的処理の新規動画を6本追加しました', 'tag' => '動画'],
        ['id' => 3, 'date' => '2026-06-15', 'title' => 'メンテナンス：6/28 深夜3:00〜4:00', 'tag' => '運用'],
        ['id' => 4, 'date' => '2026-06-10', 'title' => '面接対策資料を更新しました', 'tag' => '資料'],
    ],

    // ===== 最近の学習履歴 (受講生) =====
    'learning_history' => [
        ['id' => 1, 'date' => '2026-06-24', 'action' => '動画視聴', 'detail' => '数的処理①：速さと比', 'result' => '完了'],
        ['id' => 2, 'date' => '2026-06-23', 'action' => '復習テスト', 'detail' => '数的処理 基礎チェック', 'result' => '80%'],
        ['id' => 3, 'date' => '2026-06-22', 'action' => '資料DL', 'detail' => '判断推理 解法パターン', 'result' => '—'],
        ['id' => 4, 'date' => '2026-06-21', 'action' => '動画視聴', 'detail' => '判断推理：対応関係', 'result' => '完了'],
        ['id' => 5, 'date' => '2026-06-20', 'action' => '復習テスト', 'detail' => '判断推理 確認テスト', 'result' => '60%'],
    ],

    // ===== 復習テスト (受講生の受験フロー用：問題埋め込み) =====
    'review_tests' => [
        [
            'id' => 1, 'name' => '数的処理 基礎チェック', 'course' => '公務員 数的コース', 'status' => '公開中', 'completed' => false,
            'questions' => [
                ['q' => '時速60kmで2時間進むと何km進むか。', 'choices' => ['90km', '100km', '120km', '150km'], 'answer' => 2, 'explanation' => '60×2=120km。', 'difficulty' => '易'],
                ['q' => '原価1000円に2割の利益を見込んだ定価は。', 'choices' => ['1100円', '1200円', '1250円', '1300円'], 'answer' => 1, 'explanation' => '1000×1.2=1200円。', 'difficulty' => '易'],
                ['q' => '3人で6日かかる仕事を2人で行うと何日。', 'choices' => ['7日', '8日', '9日', '10日'], 'answer' => 2, 'explanation' => '18人日÷2=9日。', 'difficulty' => '中'],
                ['q' => '5%食塩水200gに含まれる食塩は。', 'choices' => ['5g', '8g', '10g', '12g'], 'answer' => 2, 'explanation' => '200×0.05=10g。', 'difficulty' => '中'],
                ['q' => '連続する3整数の和が48。最大の数は。', 'choices' => ['15', '16', '17', '18'], 'answer' => 2, 'explanation' => '15+16+17=48、最大17。', 'difficulty' => '中'],
            ],
        ],
        [
            'id' => 2, 'name' => '判断推理 確認テスト', 'course' => '公務員 総合コース', 'status' => '公開中', 'completed' => false,
            'questions' => [
                ['q' => 'A>B、C>A のとき1位は。', 'choices' => ['A', 'B', 'C', '不明'], 'answer' => 2, 'explanation' => 'C>A>B。', 'difficulty' => '中'],
                ['q' => '30人中 犬18・猫15・両方8。どちらも好きでないのは。', 'choices' => ['3人', '5人', '7人', '8人'], 'answer' => 1, 'explanation' => '25人が好き、30-25=5。', 'difficulty' => '中'],
                ['q' => '4人が円卓。Aの正面がCのとき、Bの正面は。', 'choices' => ['A', 'C', 'D', '不明'], 'answer' => 2, 'explanation' => '残るBとDが正面。', 'difficulty' => '中'],
                ['q' => '「全ての猫は動物」が真。対偶は。', 'choices' => ['動物でないなら猫でない', '猫でないなら動物でない', '動物なら猫', '猫なら動物でない'], 'answer' => 0, 'explanation' => '対偶＝¬動物→¬猫。', 'difficulty' => '難'],
                ['q' => '暗号 1=A,2=B…で 3-1-20 は。', 'choices' => ['CAT', 'DOG', 'BAT', 'CAR'], 'answer' => 0, 'explanation' => '3=C,1=A,20=T → CAT。', 'difficulty' => '易'],
            ],
        ],
        [
            'id' => 3, 'name' => '時事・一般常識 小テスト', 'course' => '教養コース', 'status' => '公開中', 'completed' => false,
            'questions' => [
                ['q' => '日本の国会は何院制か。', 'choices' => ['一院制', '二院制', '三院制', '無院制'], 'answer' => 1, 'explanation' => '衆議院・参議院の二院制。', 'difficulty' => '易'],
                ['q' => '日本の通貨単位は。', 'choices' => ['ウォン', '円', '元', 'ドル'], 'answer' => 1, 'explanation' => '日本円(JPY)。', 'difficulty' => '易'],
                ['q' => '三権分立の三権でないものは。', 'choices' => ['立法', '行政', '司法', '報道'], 'answer' => 3, 'explanation' => '報道は含まれない。', 'difficulty' => '易'],
                ['q' => '国際連合の本部があるのは。', 'choices' => ['ジュネーブ', 'ニューヨーク', 'パリ', '東京'], 'answer' => 1, 'explanation' => '本部はニューヨーク。', 'difficulty' => '中'],
                ['q' => '日本の最高法規は。', 'choices' => ['民法', '刑法', '日本国憲法', '商法'], 'answer' => 2, 'explanation' => '憲法が最高法規。', 'difficulty' => '易'],
            ],
        ],
    ],

    // ===== Queueモニター (モック) =====
    'queue_jobs' => [
        ['id' => 1, 'type' => 'メール送信', 'name' => 'SendMockExamMail', 'status' => '成功', 'reason' => '', 'at' => '2026-06-25 02:10'],
        ['id' => 2, 'type' => '一括登録', 'name' => 'BulkRegisterStudents', 'status' => '実行中', 'reason' => '', 'at' => '2026-06-25 09:25'],
        ['id' => 3, 'type' => 'メール送信', 'name' => 'SendNoticeMail', 'status' => '未処理', 'reason' => '', 'at' => '2026-06-25 09:28'],
        ['id' => 4, 'type' => '集計', 'name' => 'AggregateProgress', 'status' => '失敗', 'reason' => 'タイムアウト (60s 超過)', 'at' => '2026-06-25 03:02'],
        ['id' => 5, 'type' => 'メール送信', 'name' => 'SendReminderMail', 'status' => '成功', 'reason' => '', 'at' => '2026-06-24 18:00'],
        ['id' => 6, 'type' => '一括登録', 'name' => 'BulkRegisterStudents', 'status' => '失敗', 'reason' => '重複メールアドレス検出 (rollback 済)', 'at' => '2026-06-24 15:40'],
    ],

    // ===== Cronモニター (モック) =====
    'cron_batches' => [
        ['id' => 1, 'name' => '進捗集計バッチ', 'freq' => '毎時 0分', 'last' => '2026-06-25 09:00', 'next' => '2026-06-25 10:00', 'overlap' => true, 'status' => '正常'],
        ['id' => 2, 'name' => '模試結果取込', 'freq' => '毎日 3:00', 'last' => '2026-06-25 03:00', 'next' => '2026-06-26 03:00', 'overlap' => true, 'status' => '正常'],
        ['id' => 3, 'name' => '重い集計(夜間)', 'freq' => '毎日 3:00', 'last' => '2026-06-25 03:05', 'next' => '2026-06-26 03:05', 'overlap' => true, 'status' => '正常'],
        ['id' => 4, 'name' => 'リマインドメール', 'freq' => '毎日 18:00', 'last' => '2026-06-24 18:00', 'next' => '2026-06-25 18:00', 'overlap' => false, 'status' => '正常'],
        ['id' => 5, 'name' => '一時ファイル削除', 'freq' => '毎週 日 4:00', 'last' => '2026-06-22 04:00', 'next' => '2026-06-29 04:00', 'overlap' => true, 'status' => '警告'],
    ],

    // ===== エラーログ (モック) =====
    'error_logs' => [
        ['id' => 1, 'at' => '2026-06-25 03:02', 'type' => 'Queue', 'screen' => '進捗集計', 'message' => 'Job timeout: AggregateProgress', 'status' => '対応中'],
        ['id' => 2, 'at' => '2026-06-24 15:40', 'type' => 'Validation', 'screen' => '一括登録', 'message' => '重複メールアドレス 3件 (rollback)', 'status' => '解決済'],
        ['id' => 3, 'at' => '2026-06-24 11:12', 'type' => 'Auth', 'screen' => 'ログイン', 'message' => 'Rate limit 到達 (IP: 203.0.113.5)', 'status' => '解決済'],
        ['id' => 4, 'at' => '2026-06-23 22:48', 'type' => 'Notice', 'screen' => '動画視聴', 'message' => 'Vimeo API 応答遅延 (リトライ成功)', 'status' => '解決済'],
        ['id' => 5, 'at' => '2026-06-23 09:05', 'type' => 'Exception', 'screen' => '資料DL', 'message' => 'ファイル未検出 (フォールバック表示)', 'status' => '対応中'],
    ],
];
