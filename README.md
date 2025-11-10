# 💡 Light Matching Backend

Laravel製のAPIサーバーです。\
照明スタッフ向けマッチングアプリのバックエンドとして、求人情報・応募・ユーザー認証などを管理します。\
フロントエンド（Next.js）からは REST API 経由で通信します。

------------------------------------------------------------------------

# 🚀 環境構成

| 項目 | 内容 |
|------|------|
| フレームワーク | Laravel 10.x |
| PHP | 8.2以上 |
| DB | MySQL / MariaDB |
| 認証 | Laravel Sanctum |
| API仕様 | JSONベース |
| デプロイ | AWS / Vercel (フロント別) |


------------------------------------------------------------------------

## 📦 セットアップ手順

### 1. リポジトリのクローン

``` bash
git clone https://github.com/koruri29/light-matching-backend.git
cd light-matching-backend
```

### 2. 環境変数の設定

`.env.example` をコピーして `.env` を作成します。

``` bash
cp .env.example .env
```


### 3. 依存パッケージのインストール

``` bash
composer install
```

### 4. アプリキーの生成

``` bash
php artisan key:generate
```

### 5. マイグレーション＆シーディング

``` bash
php artisan migrate --seed
```

これにより、求人タグやテスト用ユーザーが登録されます。

### 6. サーバーの起動

``` bash
php artisan serve
```

APIサーバーが `http://localhost:8000` で起動します。

------------------------------------------------------------------------

## 🧩 主なディレクトリ構成

    app/
     ├── Actions/            # ビジネスロジック (UseCase層)
     ├── Http/
     │   ├── Controllers/    # APIエンドポイント
     │   ├── Middleware/     # CORS・認証関連
     │   └── Resources/      # APIレスポンス整形
     ├── Models/             # Eloquentモデル
     ├── Repositories/       # DBアクセス層
     └── Providers/          # サービス登録

    database/
     ├── migrations/         # テーブル定義
     └── seeders/            # 初期データ投入

    routes/
     ├── api.php             # 認証付きAPI
     └── web.php             # 認証不要API

------------------------------------------------------------------------

## 🔐 認証仕様

-   **Laravel Sanctum** を利用したトークンベース認証
-   フロントエンドは `axios` で `withCredentials: true` を指定
-   ログイン後、`access_token` Cookie が発行される

------------------------------------------------------------------------

## 📚 代表的なAPIエンドポイント

| メソッド | パス | 機能 | 認証 |
|----------|------|------|------|
| `POST` | `/login` | ログイン | ❌ |
| `POST` | `/logout` | ログアウト | ✅ |
| `GET` | `/jobs` | 求人一覧（ページネーション対応） | ✅ |
| `GET` | `/jobs/{id}` | 求人詳細（未実装） | ✅ |
| `POST` | `/post` | 応募送信 | ✅ |
| `POST` | `/api/force-logout` | 強制ログアウト | ❌ |

------------------------------------------------------------------------

## 🗃️ モデル関連

| モデル | 概要 | リレーション |
|--------|------|---------------|
| `JobPost` | 求人情報 | `hasMany(JobPostDate)`, `belongsToMany(JobTag)` |
| `JobPostDate` | 求人ごとの日付情報 | `belongsTo(JobPost)` |
| `JobTag` | タグマスタ | `belongsToMany(JobPost)` |
| `User` | 利用者 | `hasMany(Application)` |

------------------------------------------------------------------------

## 🧠 実装のポイント

-   `App\UseCases` 層でビジネスロジックを分離（Controllerは薄く保つ）
-   `App\Repositories` 層でEloquentクエリを管理（再利用性向上）
-   `ResourceCollection` を使用してAPIレスポンスを整形
-   ページネーションには `LengthAwarePaginator` を使用
-   タグは `belongsToMany` により中間テーブル `job_post_tag` で紐付け

------------------------------------------------------------------------

## 🧪 テスト（未実装）

``` bash
php artisan test
```

Featureテスト・Unitテストをそれぞれ `/tests/Feature` と `/tests/Unit`
に配置。

------------------------------------------------------------------------

## ☁️ デプロイメモ（AWS想定）

-   **API**: ECS / EC2 / Lambda など
-   **DB**: RDS (MySQL)
-   **Storage**: S3
-   `.env` で `APP_ENV=production` に変更し、`APP_DEBUG=false` を設定
