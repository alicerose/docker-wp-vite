<?php
/*----------------------------------------------------------------------------------
    REST API関連設定
    @update 2023.08.22
-----------------------------------------------------------------------------------*/

/**
 * 不要なヘッダの削除
 */
function removeUnnecessaryHeaders(): void
{
    remove_action('template_redirect','wp_shortlink_header', 11, 0);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

add_action( 'rest_api_init', 'removeUnnecessaryHeaders' );

/**
 * ユーザエンドポイントの廃止
 */
function disableEndPointUsers( $endpoints ) {
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P[\d]+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'disableEndPointUsers', 10, 1 );