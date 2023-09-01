<?php
/**
 * headタグ内にコードを挿入
 * @return void
 */
function insertHead() {
    $str = "";

    $str .= ADDITIONAL_HEAD_TAG;

    echo $str;
}

/**
 * GTMタグを挿入
 * @param string $placement 挿入先箇所
 * @return string|void
 */
function insertGTMBody(string $placement = "head") {

    if(!GTM_TAG_ID || GTM_TAG_ID === "XXXXXX") {
        return "";
    }

    $id = GTM_TAG_ID;

    $tag = "";
    if($placement === "head") {
        $tag = <<<EOT
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', {$id});
    </script>
    <!-- End Google Tag Manager -->
EOT;
    }

    if($placement === "body") {
        $tag = <<<EOT
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-{$id}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
EOT;
    }

    echo $tag;
}
