# ===== N1 教育モノリスDemo : 汎用 Dockerfile =====
# Render / Railway / Fly.io / Koyeb など Docker 対応PaaSでそのまま動作。
# DB不要 (session=file)。$PORT でListen。
FROM php:8.3-cli

# 必要拡張 (mbstring=日本語処理 / zip=composer)
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev libonig-dev \
    && docker-php-ext-install zip mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# 依存インストール (本番用) + アプリkey生成
# lock が古い場合に備え install 失敗時は update でフォールバック
RUN (composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    || composer update --no-dev --optimize-autoloader --no-interaction --no-progress) \
    && cp -n .env.example .env \
    && php artisan key:generate --force \
    && chmod -R 777 storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PORT=8000
EXPOSE 8000

# プロキシ配下のHTTPSで動くようキャッシュをクリアして起動
CMD php artisan config:clear && php artisan view:clear && php artisan serve --host=0.0.0.0 --port=${PORT}
