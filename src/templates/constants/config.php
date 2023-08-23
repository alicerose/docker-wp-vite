<?php
/**
 * VITE開発環境かどうか
 * @todo 環境変数に置き換える
 */
define("IS_VITE_DEVELOPMENT", $_SERVER['WP_DEBUG'] ?? WP_DEBUG ?? false);