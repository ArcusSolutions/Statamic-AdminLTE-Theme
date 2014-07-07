<!DOCTYPE html>
<html lang="<?php echo Config::getCurrentLanguage(); ?>" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><?php echo Config::getSiteName(); ?> <?php echo Localization::fetch('login'); ?></title>

    <link href="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>css/adminlte.css" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <?php echo Hook::run('control_panel', 'add_to_head', 'cumulative') ?>
</head>
<body class="bg-black" id="login" style="height: 100%;">

    <?php echo $_html; ?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <script src="<?php echo Path::tidy(Config::getSiteRoot().'/'.$app->config['theme_path']) ?>js/bootstrap.min.js" type="text/javascript"></script>

    <?php echo Hook::run('control_panel', 'add_to_foot', 'cumulative') ?>
</body>
</html>