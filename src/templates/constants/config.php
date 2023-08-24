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