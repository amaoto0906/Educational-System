<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function portal()
    {
        return view('auth.portal');
    }

    public function roadmap()
    {
        $phases = [
            ['no' => 'Phase 1', 'title' => '学習マイページの提供', 'desc' => '動画講義・教材・復習テスト・模試をひとつのマイページで提供。学生が迷わず学習に集中できる環境を整えます。', 'status' => '進行中'],
            ['no' => 'Phase 2', 'title' => '運用・サポートの強化', 'desc' => '大量アクセス時も安定して使えるよう運用を強化し、通知・監視で安心できる学習基盤を整えます。', 'status' => '予定'],
            ['no' => 'Phase 3', 'title' => '共通アカウント（SSO）', 'desc' => 'ひとつのアカウントで関連サービスにログインできる共通認証を提供し、利用をよりスムーズにします。', 'status' => '予定'],
            ['no' => 'Phase 4', 'title' => '提携サービス連携', 'desc' => '模試・教材など外部サービスと学習データを連携し、学習をひとつにまとめます。', 'status' => '予定'],
            ['no' => 'Phase 5', 'title' => '学習分析・進捗レポート', 'desc' => '学習ログを蓄積し、弱点分析や個別最適な進捗レポートを提供します。', 'status' => '構想'],
        ];

        return view('roadmap', compact('phases'));
    }
}
