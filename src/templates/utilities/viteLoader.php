<?php
/**
 * Vite Loader Utility
 * @url https://github.com/blonestar/wp-theme-vite-tailwind/blob/main/inc/inc.vite.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * VITE & Tailwind JIT development
 * Inspired by https://github.com/andrefelipe/vite-php-setup
 *
 */

// dist subfolder - defined in vite.config.json
const DIST_DEF = WP_DEBUG ? 'dist' : '';

// defining some base urls and paths
define('DIST_URI', get_template_directory_uri() . '/' . DIST_DEF);
define('DIST_PATH', get_template_directory() . '/' . DIST_DEF);

// js enqueue settings
const JS_DEPENDENCY = []; // array('jquery') as example
const JS_LOAD_IN_FOOTER = true; // load scripts in footer?

// default server address, port and entry point can be customized in vite.config.json
const VITE_SERVER = 'http://localhost:3000';
const VITE_ENTRY_POINT = '/main.js';
const VITE_ADMIN_ENTRY_POINT = '/admin.js';

/**
 * エントリポイント（フロント）
 * @return void
 */
function insertViteModuleHook(): void
{
    echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
}

/**
 * エントリポイント（管理画面）
 * @return void
 */
function insertAdminViteModuleHook(): void
{
    echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ADMIN_ENTRY_POINT . '"></script>';
}

/**
 * Vite環境で生成したアセット類の読み込み
 * @return void
 */
function applyViteAssets(): void
{
    // Vite環境ならエントリポイントを挿入
    if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {

        add_action('wp_head', 'insertViteModuleHook');
        add_action('admin_print_scripts', 'insertAdminViteModuleHook');
        return;
    }

    /**
     * ビルド済み環境の場合
     * manifest.jsonから読み込むスタイルを取得して適用
     */
    try {
        $manifest = json_decode(file_get_contents(DIST_PATH . '/manifest.json'), true, 512, JSON_THROW_ON_ERROR);
        if (is_array($manifest)) {

            foreach($manifest as $key => $array) {

                if(!$array["isEntry"]) {
                    continue;
                }

                // for admin
                if(str_contains("admin", $key)) {
                    if(isset($array["css"])) {
                        foreach($array["css"] as $i => $css) {
                            wp_enqueue_style( 'admin-style-' . $i, DIST_URI . '/' . $css );
                        }
                    }
                    wp_enqueue_script( 'admin-script', DIST_URI . '/' . $array["file"], JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER );
                } else {

                    // for frontend
                    if(isset($array["css"])) {
                        foreach($array["css"] as $i => $css) {
                            wp_enqueue_style( 'app-style-' . $i, DIST_URI . '/' . $css );
                        }
                    }

                    wp_enqueue_script( 'app-script', DIST_URI . '/' . $array["file"], JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER );

                }

            }

        }
    } catch (JsonException $e) {
        wp_die($e->getMessage());
    }
}

// フロントへの適用
add_action( 'wp_enqueue_scripts', 'applyViteAssets');

// 管理画面への適用
add_action( 'admin_enqueue_scripts', 'applyViteAssets');