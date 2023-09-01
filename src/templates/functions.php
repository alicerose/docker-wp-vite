<?php
// constants
include_once "constants/alias.php";
include_once "constants/config.php";

// utilities
include_once "utilities/headTag.php";
include_once "utilities/images.php";
include_once "utilities/misc.php";
include_once "utilities/viteLoader.php";

if(!WP_DEBUG && ALLOW_HTML_COMPRESSION) {
    include_once "utilities/compressHTML.php";
}

// functions
include_once "functions/admin.php";
include_once "functions/core.php";
include_once "functions/rest.php";
