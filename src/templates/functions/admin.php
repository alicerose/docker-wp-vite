<?php
/*----------------------------------------------------------------------------------
    管理画面関連設定
    @update 2023.08.22
-----------------------------------------------------------------------------------*/

/**
 * ログイン時のエラー内容を不明瞭にする
 * @param string $error_message
 * @return string
 */
function my_login_errors(string $error_message ): string
{
    error_log($error_message);
    return '<strong>エラー</strong>: ユーザー名またはパスワードが間違っています。';
}

add_filter( 'login_errors', 'my_login_errors' );