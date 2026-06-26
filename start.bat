@echo off
chcp 65001 >nul
cd /d "%~dp0"

REM php が PATH に無ければ winget の既定パスを補完
where php >nul 2>nul
if errorlevel 1 set "PATH=%PATH%;%LOCALAPPDATA%\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"

echo ============================================================
echo  N1 学習プラットフォーム  ローカル起動
echo  URL: http://localhost:8000   (停止: Ctrl+C)
echo ============================================================
echo.
php artisan view:clear
php artisan serve --host=127.0.0.1 --port=8000
pause
