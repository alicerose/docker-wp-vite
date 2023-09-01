<?php
/**
 * WebP対応画像タグ出力
 * @param ?string $path /assets/images 以降のwebp前の画像へのパス
 * @param string $alt altタグ
 * @param string $class クラス
 * @param bool $lazy 遅延読み込みをするか
 * @param bool $base64 base64化するか
 * @return void
 */
function ImageLoader(?string $path, string $alt = "", string $class = "", bool $lazy = true, bool $base64 = false)
{
    global $pagenow;
    // 管理画面での参照時はlazyloadしない
    if($pagenow === 'post.php') {
        $lazy = false;
    }
    if($path) {
        echo getImageLoader(
            $path,
            $alt,
            $class,
            $lazy,
            $base64
        );
    }
}

/**
 * 画像タグの生成
 * @param string $path
 * @param string $alt
 * @param string $class
 * @param bool $lazy
 * @param bool $base64
 * @return string
 */
function getImageLoader(string $path, string $alt = "", string $class = "", bool $lazy = true, bool $base64 = false): string
{

    $uploadUrl = wp_get_upload_dir();

    /**
     * 渡されたパスでの処理振り分け
     */
    if(strpos($path, $uploadUrl["baseurl"]) !== false) {

        // アップロード画像の場合
        $path = str_replace($uploadUrl["baseurl"], "", $path);
        debugLog('[Image] strip url', $path);
        $templateUrl = $uploadUrl["baseurl"];
        $templateDir = $uploadUrl["basedir"];
        $imageDir = "";
    } else {
        // テーマ内画像の場合
        $templateUrl = get_template_directory_uri();
        $templateDir = get_template_directory();
        $imageDir = "/assets/images";
    }

    $dom = "<picture class='${class}'>";

    $size = getUrlImageSize(get_template_directory_uri() . $imageDir . $path, $lazy, false);

    if($base64) {
        if(strpos("svg", $path)) {
            $code = ImagePathToBase64($imageDir . $path, 'svg');
        } else {
            $code = ImagePathToBase64($imageDir . $path);
        }
        $dom .= "<img src='${code}' alt='${alt}' aria-label='${alt}' ${size} />";
    } else {
        if(file_exists($templateDir . $imageDir . $path . ".webp")) {
            $dom .= "<source srcset='${templateUrl}${imageDir}${path}.webp' type='image/webp'>";
        }

        if($lazy) {
            $dom .= "<img data-src='${templateUrl}${imageDir}${path}' alt='' ${size}>";
        } else {
            $dom .= "<img src='${templateUrl}${imageDir}${path}' alt='' ${size}>";
        }

    }

    $dom .= "</picture>";

    return $dom;
}

/**
 * 指定されたパスの画像をbase64化して返す
 * @param string $path /assets/から始まるパス
 * @param string $type 拡張子
 * @return string
 */
function ImagePathToBase64(string $path, string $type = "png"): string
{
    if($type === "svg") $type = "svg+xml";
    return "data:image/" . $type . ";base64," . base64_encode(file_get_contents(get_template_directory() . $path ));
}

/**
 * 画像サイズの取得
 * @param string $url
 * @param bool $lazy loading属性をlazyにするかどうか
 * @param bool $echo 出力するかどうか
 * @return false|mixed|string|void
 */
function getUrlImageSize(string $url, bool $lazy = true, bool $echo = true) {
    $path = $_SERVER["DOCUMENT_ROOT"] . str_replace(home_url(), "", $url);
//    debugLog($path);
//    debugLog('check image exist: ' . $path);

    /**
     * 画像が見つからなかったら中断
     */
    if(!file_exists($path)) {
        if($echo) {
            echo "";
            return false;
        } else {
            return '';
        }
    }

    $size = getimagesize($path);

    if(!$size) {

        if(strpos( $url, ".svg") !== false) {
            $svg = file_get_contents($path, false);
//            error_log($svg);
            $xmlget = simplexml_load_string($svg);
            $xmlattributes = $xmlget->attributes();
            $width = (string) $xmlattributes->width;
            $height = (string) $xmlattributes->height;



            $size = "width='${width}' height='${height}'";
            if($lazy) {
                $size .= " loading='lazy' decoding='async'";
            }

            if($echo) {
                echo $size;
                return "";
            } else {
                return $size;
            }
        }

        error_log("[ImageSize] " . $path . " not found");
        return false;
    };

//    if(strpos( $url, "flow") !== false) {
//        error_log($url);
//        error_log($size[3]);
//    }

    $size = $size[3];
    if($lazy) {
        $size .= " loading='lazy' decoding='async'";
    }

    if($echo) {
        echo $size;
    } else {
        return $size;
    }
}
