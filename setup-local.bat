@echo off
chcp 65001 >nul
cd /d "%~dp0"

REM --- php が PATH に無ければ winget の既定パスを補完 ---
where php >nul 2>nul
if errorlevel 1 (
  set "PATH=%PATH%;%LOCALAPPDATA%\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
)

echo ============================================================
echo  N1 教育モノリスDemo  ローカルセットアップ
echo  (git方式で依存取得 = Windows の zip ロックを回避)
echo ============================================================
echo.

echo [1/4] composer install (source/git method) ...
call composer install --no-dev --prefer-install=source --no-interaction
if errorlevel 1 (
  echo.
  echo composer install に失敗しました。下記を確認してください:
  echo  - composer / php が PATH に通っているか
  echo  - もう一度このバッチを実行すると、キャッシュ済み分は高速に進みます
  pause
  exit /b 1
)

echo.
echo [2/4] .env を用意 ...
if not exist ".env" copy ".env.example" ".env" >nul

echo [3/4] アプリキー生成 ...
call php artisan key:generate --force

echo.
echo [4/4] サーバー起動: http://localhost:8000
echo  (停止するには Ctrl+C)
echo.
call php artisan serve
pause
