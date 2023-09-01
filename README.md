# Wordpressテンプレート（Vite)

## 概要

* WordPress開発用Docker
* TypeScript, Scss ready

### Webpack版との差異

* バンドル環境をWebpackからViteへ刷新
* localhost:3000でHMRが効くように
* mutagen廃止

## 対象環境

* Docker Desktop
* Node.js `v18.x`
* PHP `8.x`
    * 一部名前付き引数で関数を追加しているため

## Docker構成

| ホスト                   | コンテナ       | 詳細・備考                                                              |
|:----------------------|:-----------|:-------------------------------------------------------------------|
| http://localhost:8888 | Apache     | PHP 8.1                                                            |
| http://localhost:3306 | MariaDB    | Volume化                                                            |
| http://localhost:8081 | PhpMyAdmin |                                                                    |
| http://localhost:8025 | MailHog    | WordPressから配信されたメールをインターセプトする<br>永続化されていないのでコンテナを落とすと受信済みデータは消去される |

## ディレクトリ構成

| ディレクトリ    | サブディレクトリ    | 用途             | 備考                         |
|:----------|:------------|:---------------|:---------------------------|
| `.data`   |             | 永続化用マウントデータ    | `.gitignore`済み             |
| `.docker` |             | Docker用構成ファイル郡 |                            |
| `bin`     |             | シェルスクリプト郡      | 要Envファイル設定                 |
| `dist`    |             | ビルド済みデータ       | `.gitignore済み`             |
| `src`     | `assets`    | 静的ファイル配置用      |                            |
| `src`     | `scss`      | スタイルシート郡       | Scss                       |
| `src`     | `templates` | テンプレートファイル     | Docker上へはこのディレクトリをマウントしている |
| `src`     | `ts`        | スクリプトファイル      | TypeScript                 |

## npmスクリプト

| コマンド            | 用途                      | 備考 |
|:----------------|:------------------------|:---|
| `dev`           | 開発環境起動                  |    |
| `build`         | ビルドデータ生成                |    |
| `wp:initialize` | WordPressの初期設定バッチ実行     |
| `wp:update`     | WordPressのプラグイン等導入バッチ実行 |    |

## 開発フロー

* （初回のみ）`npm i`
* （初回のみ）`husky install`
* （初回のみ）`husky add .husky/pre-commit "npx lint-staged"`
* `docker compose up -d`
* （初回のみ）`npm run wp:initialize`
* プラグインの導入等を都度`npm run wp:update`で実施
* `npm run dev`
* `http://xxx.xxx.xxx.xxx:3000`へ
  * ブラウザで上記ページが自動で開きます
  * 起動時に端末のプライベートIPが入ります

### Convert WebP

* `src/assets/images`配下の画像をwebpに変換する
    * 当該ディレクトリが存在しない場合は処理中断する
* オリジナルのファイル名.webpと命名したファイルを生成する
* `cwebp`が必要
    * https://developers.google.com/speed/webp

### Deploy

* ビルド後のデータを指定環境に対してrsyncで同期する
* sshが行えない環境に対しては、Archiverでzipファイルを生成したものをアップロード

### TODO

* 各所でハードコーディングしている`my-theme`の撲滅
* テーマファイル用の汎用関数郡実装
* 重複マウントしている箇所をコンテナ内シンボリックするように変更

## リリースノート

https://github.com/alicerose/docker-wp-vite/releases
