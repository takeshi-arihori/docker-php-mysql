# PHP + PHP-FPM × Nginx × MySQL 開発環境

このリポジトリは、Docker Compose を使用して PHP + PHP-FPM × Nginx × MySQL の開発環境を構築するためのモデルです。複数のプロジェクトで再利用可能な設定を提供します。

## 開発環境

- **Web サーバ**: Nginx 1.25.0
- **データベース**: MySQL 8.0
- **言語**: PHP 8.1

## 参考

- [参考記事](https://qiita.com/shikuno_dev/items/f236c8280bb745dd6fb4)

## プロジェクト構成

```
.
├── docker/
│ ├── mysql/
│ │ └── my.cnf
│ ├── nginx/
│ │ └── default.conf
│ └── php/
│ ├── Dockerfile
│ └── php.ini
├── src/
│ ├── Interfaces/
│ │ └── Engine.php
│ ├── Engines/
│ │ ├── GasolineEngine.php
│ │ └── ElectricEngine.php
│ └── Cars/
│ ├── Car.php
│ ├── GasCar.php
│ └── ElectricCar.php
├── docker-compose.yml
└── .env
```

## セットアップ手順

### 1. リポジトリをクローン

```bash
git clone https://github.com/yourusername/yourrepository.git
cd yourrepository
```

### 2. 環境変数を設定

.env ファイルを作成し、以下の内容を追加します。

```
MYSQL_ROOT_PASSWORD=password
MYSQL_DATABASE=php-docker-db
MYSQL_USER=user
MYSQL_PASSWORD=password
PROJECT_NAME=my_project

```

### 3. Docker コンテナをビルドして起動

```
docker-compose up --build
```

### 4. phpMyAdmin にアクセス

ブラウザで http://localhost:8080 にアクセスし、以下の情報でログインします。

```
サーバ: mysql
ユーザ名: root
パスワード: .envファイルで設定したMYSQL_ROOT_PASSWORDの値（例: password）
```

## Docker 内での DB 操作

### MySQL コンテナに入る

```
docker-compose exec mysql /bin/bash
```

### MySQL にログイン

```
mysql -u root -p
```

### 注意事項

- 各プロジェクトで使用する際は、.env ファイルの内容をプロジェクトに合わせて変更してください。
- Docker Compose ファイルで定義されたボリューム名やネットワーク名もプロジェクトごとにユニークにしてください。
