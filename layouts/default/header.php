<?php

use \Academy\App;
use \Academy\Helpers\Url;

$basePath = App::$i->request->getBasePath();
$pageTitle = !empty($this->pageTitle)
    ? $this->pageTitle
    : App::$i->config->get('applicationName');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= $basePath ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $basePath ?>/css/site.css">
</head>
<body>
    <nav class="navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
            <?php if (!empty($user->username)) : ?>
                <span class="navbar-brand">Welcome, <?= $user->username ?>.</span>
            <?php else: ?>
                <span class="navbar-brand">PHP-Academy</span>
            <?php endif; ?>
            </div>
            <ul class="nav navbar-nav">
                <li>
                    <a href="/index.php">Home</a>
                </li>
            <?php if (!empty($user->id)) : ?>
                <li>
                    <a href="<?= Url::to('user/profile') ?>">Your profile</a>
                </li>
                <?php if (!empty($user->superuser)): ?>
                <li>
                    <a href="/management.php">Manage users</a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="/logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= Url::to('user/signup') ?>">Sign up</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">