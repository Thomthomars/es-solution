<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 15/09/15
 * Time: 15:10
 */

use Elasticsearch\ClientBuilder;
use Silex\Application;
use Monolog\Logger;

$app['elasticsearch'] = function() {
  $params = array();
  $hosts = self::getConnexion();
  $logger = ClientBuilder::defaultLogger("../log/elastic.log");
  $client = ClientBuilder::create()->setHosts($hosts)->setLogger($logger)->build();

  return $client;
};
