<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

const APP_ENV = 'APP_ENV';
const APP_DEBUG = 'APP_DEBUG';

if (!class_exists(Dotenv::class)) {
    throw new LogicException(
        'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.'
    );
}

$dotenv = new Dotenv();
$dotenv->usePutenv(true);

if (is_array($env = @include dirname(__DIR__) . '/.env.local.php') && (!isset($env[APP_ENV]) || ($_SERVER[APP_ENV] ?? $_ENV[APP_ENV] ?? $env[APP_ENV]) === $env[APP_ENV])) {
    $dotenv->populate($env);
} else {
    $dotenv->loadEnv(dirname(__DIR__) . '/.env');
}

$_SERVER += $_ENV;
$_SERVER[APP_ENV] = $_ENV[APP_ENV] = ($_SERVER[APP_ENV] ?? $_ENV[APP_ENV] ?? null) ?: 'dev';
$_SERVER[APP_DEBUG] = $_SERVER[APP_DEBUG] ?? $_ENV[APP_DEBUG] ?? 'prod' !== $_SERVER[APP_ENV];
$_SERVER['c'] = $_ENV[APP_DEBUG] = (int) $_SERVER[APP_DEBUG] || filter_var($_SERVER[APP_DEBUG], FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
