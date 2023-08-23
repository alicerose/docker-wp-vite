<?php
/**
 * Vite Loader Utility
 * @url https://github.com/blonestar/wp-theme-vite-tailwind/blob/main/inc/inc.vite.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

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

// enqueue hook
add_action( 'wp_enqueue_scripts', function() {

    if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {

        // insert hmr into head for live reload
        function vite_head_module_hook(): void
        {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
        }

        add_action('wp_head', 'vite_head_module_hook');

    } else {

        // asset insertion for production build
        // read manifest.json to figure out what to enqueue
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


});