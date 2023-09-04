#!/usr/bin/env bash

echo "[WP-CLI] Exec update commands."

if wp core is-installed; then

  # プラグインの追加
  echo "[WP-CLI] Add plugins."
  wp plugin install \
    advanced-custom-fields \
    all-in-one-wp-migration \
    wp-multibyte-patch \
    debug-bar \
    debug-bar-rewrite-rules \
    show-current-template \
    transients-manager \
    user-switching \
    --activate

  # 翻訳データ更新
  echo "[WP-CLI] Update translations."
  wp language plugin update --all
else
  echo "[WP-CLI] No wordpress installed."
fi
