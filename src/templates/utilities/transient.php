<?php

/**
 * TransientCacheの取得
 * @param string $key
 * @return false|mixed
 */
function getTransient(string $key) {
    if(IS_LOGGED_IN) {
        debugLog('[TRANSIENT] User logged in, no use transient.');
        return false;
    }
    $data = get_transient($key);

    if(!$data) {
        debugLog("[TRANSIENT] No transient data for ${key} found.");
        return false;
    }

    debugLog("[TRANSIENT] Transient data for ${key} found.");
    return $data;
}

/**
 * TransientCacheを設定する
 * @param string $key Transientキー
 * @param string|array|object $data Transientに残すデータ
 * @return void
 */
function setTransient(string $key, $data) {
    debugLog("[TRANSIENT] set transient data for ${key}");
    set_transient($key, $data, TRANSIENT_CACHE_EXPIRATION);
}
