<?php
/*----------------------------------------------------------------------------------
    WordPressのコア設定
    @update 2023.08.22
-----------------------------------------------------------------------------------*/

/**
 * headタグ・レスポンスヘッダ内の不要項目削除
 */
function removeUnnecessaryHeader(): void
{
    // WPのバージョン表記削除
    remove_action('wp_head','wp_generator');

    // 編集用RSDリンクの削除
    remove_action('wp_head', 'rsd_link');

    // Windows Live Writer編集用リンクの削除
    remove_action('wp_head', 'wlwmanifest_link');

    // RSSリンクの削除
    remove_action('wp_head', 'feed_links');
    remove_action('wp_head', 'feed_links_extra');

    // 短縮URLの削除
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // 関連ページリンクの削除
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

    // 自前で実装するのでcanonical外す
    remove_action( 'wp_head', 'rel_canonical');

    // WP-JSONリンクの削除
    remove_action( 'wp_head','rest_output_link_wp_head');

    // Link削除
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
add_action( 'init', 'removeUnnecessaryHeader' );

/**
 * 絵文字機能の削除
 */
function disableEmojis(): void
{
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disableEmojis' );

/**
 * クリックジャッキング対策
 * X-Frame-Optionsを設定
 */
add_action( 'send_headers', 'send_frame_options_header', 10, 0 );

/**
 * ファイルシステムの変更
 * プラグインの更新が出来ない状態になるのを回避する
 */
function modifyFileMethod($args): string
{
    return 'direct';
}
add_filter( 'filesystem_method','modifyFileMethod' );

/**
 * デフォルトスタイルの操作
 * @return void
 */
function handleAssets(): void
{

    if(!USE_BLOCK_EDITOR) {
        wp_dequeue_style( 'global-styles' );
    }

}
add_action( 'wp_enqueue_scripts', 'handleAssets' );