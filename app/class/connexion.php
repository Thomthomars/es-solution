<?php

/**
 * Created by PhpStorm.
 * User: mars
 * Date: 22/11/2015
 * Time: 17:45
 */
use Elasticsearch\ClientBuilder;


class connexion {

  public $host = array('localhost', 'localhost:9200', '127.0.0.1:9200');


  public static function getConnexion($host) {

    if (self::getConnexion($host) === NULL) {
      return $host = array('localhost', 'localhost:9200', '127.0.0.1:9200');
    }

    return $host;
  }
}