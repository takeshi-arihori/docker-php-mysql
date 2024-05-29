# PHP アプリケーションと MySQL、phpMyAdmin の Docker Compose 設定

このリポジトリには、PHP アプリケーションと MySQL データベース、およびデータベース管理のための phpMyAdmin を設定する Docker Compose の構成が含まれています。

## 前提条件

以下のソフトウェアがマシンにインストールされていることを確認してください：

- Docker

## プロジェクト構成

```
.
├── app
│ ├── src
│ │ └── index.php
│ └── Dockerfile
├── mysql
│ └── initdb.d
│ └── init.sql
├── compose.yml
└── README.md
```

## サービス

Docker Compose の構成は以下のサービスをセットアップします：

1. **php-app**: PHP アプリケーションコンテナ。
2. **php-db**: MySQL データベースコンテナ。
3. **phpmyadmin**: データベース管理用の phpMyAdmin コンテナ。

## PHP と MySQL の設定

### app/Dockerfile

この Dockerfile は PHP 環境をセットアップし、MySQL 接続のための必要なパッケージをインストールします。

```Dockerfile
# PHP 8.2 と Apache をベースにした公式 Docker イメージを使用。
FROM php:8.2-apache

# パッケージリストを更新し、MySQL 用の PDO 拡張モジュールをインストール。
RUN apt update \
    && docker-php-ext-install pdo_mysql

# src ディレクトリの内容をコンテナ内の/var/www/html/にコピー。
COPY src/ /var/www/html/
```

### app/src/index.php

この PHP スクリプトは MySQL データベースに接続し、ユーザーレコードを取得します。

```
<?php

// データベース接続
// ホストはコンテナ名を記載する
$dsn = 'mysql:dbname=test_db;host=run-php-db;';
$user = 'test';
$password = 'test';

try {
    $pdo = new PDO($dsn, $user, $password);
    $sth = $pdo->query("SELECT * FROM users WHERE id = 1");
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    var_dump($user);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    exit;
}

```

### mysql/initdb.d/init.sql

この SQL スクリプトは、MySQL データベースを初期化し、users テーブルを作成し、サンプルレコードを挿入します。

```
CREATE TABLE test_db.users (
    id          INT             NOT NULL,
    first_name  VARCHAR(20)     NOT NULL,
    age         INT,
    PRIMARY KEY (id)
);

INSERT INTO `users` VALUES (1, 'Takeshi Arihori', 37);
```

### 使用方法

1. コンテナのビルドと起動
   コンテナをビルドし、起動するには、以下のコマンドを実行します：

```
docker compose up -d
```

2. ブラウザでアクセス
   ブラウザで `http://localhost:8080` にアクセスし、PHP アプリケーションが MySQL データベースからユーザーレコードを取得していることを確認します。
