<?php

require_once './cors.php';
require_once 'libs/database.php';
require_once 'libs/controller.php';
require_once 'libs/view.php';
require_once 'libs/model.php';
require_once 'libs/app.php';
require_once 'libs/mailer.php';
require_once 'libs/vendor/autoload.php';

//require_once 'config/config.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable('.');
$dotenv->load();

define("dir", getenv('APP_HOST'));

$app = new App();

?>