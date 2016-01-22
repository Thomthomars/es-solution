<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 15/09/15
 * Time: 14:17
 */

use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Response;

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add('Controller', __DIR__ . '/../src');
$app = new Silex\Application();
require_once __DIR__ . '/../src/routes.php';
require_once __DIR__ . '/../app/elastic.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/template',
));


$app["debug"] = true;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$app->run();
