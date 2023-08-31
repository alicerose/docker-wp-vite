<?php

$configs = [
    "port" => 3333,
    "entry" => [
        "front" => "/main.js",
        "admin" => "/admin.js"
    ],
];

$path = THEME_PATH . '/.hostip';
if(file_exists($path)) {
    $file = file_get_contents($path);
    $configs["host"] = "http://" . $file . ":" . $configs["port"];
} else {
    $configs["host"] = null;
}
define("VITE_CONFIG", $configs);

function insertFrontModuleHook(): void
{
    echo '<script type="module" crossorigin src="' . VITE_CONFIG["host"] . VITE_CONFIG["entry"]["front"] . '"></script>';
}

function insertAdminModuleHook() {
    echo '<script type="module" crossorigin src="' . VITE_CONFIG["host"] . VITE_CONFIG["entry"]["admin"] . '"></script>';
}

function loadViteAssets(): void
{
    // vite環境の場合
    if(defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT) {

        // フロント
        add_action('wp_head', 'insertFrontModuleHook');

        // 管理画面
        add_action('admin_print_scripts', 'insertAdminModuleHook');

        return;
    }

    $isAdmin = mb_strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false;
    if($isAdmin) {
        echo "admin page";
    }

    // ビルド済み環境の場合
    $manifestPath = get_template_directory() . '/manifest.json';
    $raw = file_get_contents($manifestPath);
    try {
        $manifest = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        foreach($manifest as $key => $array) {
            $file_key = str_replace('src/ts', '', $key);

            if(!$array["isEntry"]) {
                continue;
            }

            // 管理画面＋admin.tsを含まない or 非管理画面+admin.tsを含む場合スキップする
            if(
                ($isAdmin && mb_strpos($file_key, "admin") === false)
                || (!$isAdmin && mb_strpos($file_key, "admin") !== false)
            ) {
                continue;
            }

            if(isset($array["css"])) {
                foreach($array["css"] as $i => $css) {
                    wp_enqueue_style( $file_key . '-' . $i, THEME_URI . '/' . $css , '', '');
                }
            }
            wp_enqueue_script( $file_key, THEME_URI . '/' . $array["file"], [], '', true );
        }

    } catch (JsonException $e) {
        wp_die($e->getMessage());
    }
}

add_action( 'init', 'loadViteAssets');
