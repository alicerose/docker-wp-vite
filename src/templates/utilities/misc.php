<?php
/**
 * GitのハッシュIDを返す
 * @param int $length
 * @return array|false|string|string[]
 */
function getGitHash(int $length = -1) {
    $versionPath = THEME_PATH . '/.version';
    if(!file_exists($versionPath)) {
        return false;
    }

    $data = fopen($versionPath, 'rb');
    $version = str_replace("\n", '', fgets($data));
    fclose($data);

    if($length !== -1) {
        return mb_strimwidth($version, 0, $length);
    }

    return $version;
}

/**
 * 開発環境でのみエラーログを出力する
 * @param ...$messages
 * @return false|void
 */
function debugLog(...$messages) {

    if(!WP_DEBUG) {
        return false;
    }

    $arr = [];

    foreach($messages as $i => $message) {
        $type = gettype($message);

        if($type === "string" || $type === "integer") {
            $arr[] = $message;
        }

        if($type === "array" || $type === "object") {
            $arr[] = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    error_log('[DEBUG] ' . implode(", ", $arr));
}
