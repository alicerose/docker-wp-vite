<?php
/**
 * VITE開発環境かどうか
 */
define("IS_VITE_DEVELOPMENT", $_SERVER['WP_DEBUG'] ?? WP_DEBUG ?? false);

/**
 * ブロックエディタを使用するか
 * 使わない場合は専用スタイルが不要になるため削除される
 */
const USE_BLOCK_EDITOR = true;

/**
 * 管理画面でGitのバージョン表示をするか
 */
const SHOW_GIT_HASH = true;

/**
 * 管理画面下部の固定表示テキスト
 * @memo なにか表示するときは文字列を渡す
 */
const ADMIN_FOOTER_TEXT = "Footer";
