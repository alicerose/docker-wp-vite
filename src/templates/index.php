<?php get_header(); ?>
<main>
    <img src='<?= get_template_directory_uri() ?>/assets/images/sample.png' alt=''>
    <div class='test'></div>

    <?php ImageLoader('/sample.png'); ?>
    <?php ImageLoader('/sample.png', '', 'example', false, true); ?>
</main>
<?php
$arr = [
    "piyo" => "aaa",
    "hoge" => [
        "aa" => "bb"
    ]
];
$obj = (object) [
    "foo" => "bar"
];
debugLog('hoge', 'fuga', $arr, $obj);
error_log('index');
?>
<?php get_footer(); ?>
