<!doctype html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title><?= get_bloginfo('title') ?></title>
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1><?= get_bloginfo('title') ?></h1>
</header>