# ![RealWorld Example App](logo.png)

> ### [RealWorld](https://github.com/gothinkster/realworld)の仕様・APIに準拠したLaravelベースのリポジトリです。

詳細については[RealWorld](https://github.com/gothinkster/realworld)のリポジトリを確認してください。

## 実行方法

仮想環境としてDockerを利用しています。インストールは[公式ページ](https://docs.docker.com/install/)から出来ます。

### TL;DR 実行コマンド

```sh
git clone git@github.com:choco14t/laravel-realworld.git
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
make migrate
```

このリポジトリをクローンします。

```sh
git clone git@github.com:choco14t/laravel-realworld.git
```

クローンしたディレクトリに移動し、composerで依存ライブラリのインストールをします。<br>

```sh
composer install
```

envファイルを利用するので.env.exampleからコピーします。

```sh
cp .env.example .env
```

アプリケーションキーの生成をします。

```sh
php artisan key:generate
```

JWT認証用のキーを生成します。

```sh
php artisan jwt:secret
```

データベースのマイグレーションを実行します。<br>
Makefileを作成しているのでmakeコマンドから実行できます。

```sh
make migrate
```

## データベースシーディング

シーディングファイルを用意しているのでコマンド実行することで初期データの作成が出来ます。

```sh
make seed
```

シーディングする際はデータベースの初期化を推奨します。

```sh
make db-refresh
```

## テスト

テストの実行に.env.testingファイルを利用します。<br>
あらかじめ作成した.envからコピーして実行してください。

```sh
cp .env .env.testing
make test
```
