<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<title>@yield('title', 'N1 学習プラットフォーム')｜オンライン学習</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

{{-- 事前ビルドした静的 Tailwind CSS (Play CDN を廃止し初回ロードを高速化) --}}
<link rel="stylesheet" href="/css/app.css">

{{-- Alpine.js (自己ホスト) --}}
<script defer src="/js/alpine.min.js"></script>
