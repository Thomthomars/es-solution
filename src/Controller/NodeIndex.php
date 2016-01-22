<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 25/09/15
 * Time: 11:59
 */

namespace Controller;

use Silex\Application;
use Elasticsearch\Client;
use Elasticsearch\Endpoints\Indices\Settings;
use Symfony\Component\HttpFoundation\Response;

class NodeIndex {

  /**
   * @return \PDO
   *
   * Configuration to enable bdd connection.
   */
  static function BaseConnection() {
    $bdd = new \PDO('mysql:host=localhost;dbname=csoecsic;charset=utf8', 'root', 'root');

    return $bdd;
  }

  /**
   * @param \Silex\Application $app
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * Création du mapping au cas ou il n'existe plus.
   */
  public function indexContenuCreat(Application $app) {
    $params = array();
    $client = $app['elasticsearch'];

    $article['index'] = 'elasticsearch_index_csoecsic_content';
    $article['type'] = 'content';
    $index = array('index' => 'elasticsearch_index_csoecsic_content');
    /* Call function to try if mapping exist. */
    $ret = $this->getMappingCurrent($app, $index);

    $mess['confirm'] = "The mapping already exist, no need to recreate !";
    if ($ret['bool'] == false) {

      // invoke mapping for injected it in Elasticsearch.
      require_once __DIR__ . '../../config/Mapping.php';
      //inject mapping in elasticsearch.
      $client->indices()->create($params);

      /* all function to try if mapping is created or not. */
      $try = $this->getMappingCurrent($app, $index);

      if($try['bool'] == false) {
        $mess['index'] = "Epic Fail !";
        $mess['confirm'] = "Oh so bad you should have a probleme with your configuration";
      }
      else {
        $mess['index'] = $try['mapp'];

        $mess['confirm'] = "The mapping is creat with success !";
      }
    }
    else {
      $mess['index'] = $ret['mapp'];
    }



    return $app['twig']->render('check_index.html.twig', ['message' => $mess]);
  }

  /**
   * Récupération des contenus depuis la base distance.
   *
   * Will not use in future.
   */
  public function getContentFromBdd() {
    $field = array();
    require_once __DIR__ . '../../config/fields.php';
    $bdd = $this->BaseConnection();
    $sql = "select id from node";
    $req = $bdd->query($sql);
    $sql = "select nid, title from node ";
    foreach($field as $table => $column) {
      $sql .= "left outer join ".$table." on ";
    }

    while ($row = $req->fetch()) {
      echo $row['nid'] . '<br/>';
    }
    $req->closeCursor();
  }

  /**
   * @param \Silex\Application $app
   * Get current index, with settings.
   * Try if the cluster is not empty.
   *
   */
  public function getIndexAndSettings(Application $app) {
    $client = $app['elasticsearch'];

  }

  /**
   * @param \Silex\Application $app
   * @return bool|\Symfony\Component\HttpFoundation\Response
   * Try if the Mapping exist already or if we need to create it.
   */
  public function getMappingCurrent(Application $app, $index) {
    $client = $app['elasticsearch'];
    $res = FALSE;
    try {
      $try['mapp'] = $client->indices()->getMapping($index);
      if ($try != NULL) {

        $try['bool'] = TRUE;
      }

    }catch (\Exception $e) {

      $try['bool'] = new Response("Pas de Mapping !", $e);
    }

    return $try;
  }
}
