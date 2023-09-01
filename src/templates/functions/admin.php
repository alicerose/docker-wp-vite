<?php
/*----------------------------------------------------------------------------------
    管理画面関連設定
    @update 2023.08.22
-----------------------------------------------------------------------------------*/

/**
 * ログイン時のエラー内容を不明瞭にする
 * @param string $errorMessage
 * @return string
 */
function ambiguousLoginError(string $errorMessage ): string
{
    error_log("[LOGIN] failed, ", $errorMessage);
    return '<strong>エラー</strong>: ユーザー名またはパスワードが間違っています。';
}

add_filter( 'login_errors', 'ambiguousLoginError' );

function replaceAdminFooterText(): string
{
    $str = "";

    $git = getGitHash();
    if(SHOW_GIT_HASH && $git) {
        $str .= "Git: " . $git;
    }

    if(ADMIN_FOOTER_TEXT) {
        if(SHOW_GIT_HASH && $git) {
            $str .= "<br>";
        }

        $str .= ADMIN_FOOTER_TEXT;
    }

    return $str;
}
add_filter( 'admin_footer_text', 'replaceAdminFooterText' );
