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

    foreach($messages as $message) {
        $type = gettype($message);

        if($type === "string" || $type === "integer") {
            error_log($message);
        }

        if($type === "array" || $type === "object") {
            error_log(json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
    }
}
