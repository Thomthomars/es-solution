<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 15/09/15
 * Time: 15:17
 */

namespace Controller;

use Silex\Application;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\TwigServiceProvider;
use Silex\Application\TwigTrait;

class NodeController {

  /**
   * @param \Silex\Application $app
   * @return \Symfony\Component\HttpFoundation\Response
   * Fonction for listing node.
   */
  public function index(Application $app) {
    header("Content-Type: text/html; charset=UTF-8");
    $client = $app['elasticsearch'];
    $nodes = array();
    $node = "";

    $index =  "elasticsearch_index_csoecsic_content";
    $mapRep = $client->indices()->getMapping(array('index' => 'elasticsearch_index_csoecsic_content'));
    $fieldString = $mapRep[$index]['mappings']['content']['properties'];


    $params= [
      'index' => "elasticsearch_index_csoecsic_content",
      'type' => "string",
      'body' => [
        'query' => [
          "match" => [
            "field_title" => "dns"
          ]
        ]
      ]
    ];


    $result = $client->search($params);

    if ($result['hits']['total'] > 0) {
      foreach ($result as $node) {
        $nodes['result'] = $result['hits']['hits'] = $result;
      }

      foreach ($result as $node) {
        $nodes['result'] = $result['hits']['hits'] = $result;
      }

      foreach ($nodes['result'] as $node) {
        $node = "<pre>" . $node['res'] . "</pre><hr />";

      }
    }


    return $app['twig']->render('all.html.twig', ['result' => $node]);
  }

  /**
   * @param \Silex\Application $app
   * This function can return listing of node.
   */
  public function show(Application $app) {
    header("Content-Type: text/html; charset=UTF-8");
    $client = $app['elasticsearch'];
    $search = $_GET['recherche'];


    $params['index'] = 'elasticsearch_index_csoecsic_content';
    $params['type'] = 'content';

    $ret = $client->indices()->getMapping(array('index' => 'elasticsearch_index_csoecsic_content'));

     $params['body']['query']['match']['_all'] = $search;

    $result = $client->search($params);

    // If no result from node Elasticsearch.
    if ($result && $result['hits']['total'] === 0) {
      $app->abort(404, sprintf('Node %s does not exist.', $search));
    }

    // If result from node Elasticsearch.
    if ($result['hits']['total'] > 0) {
      $nodes = $result['hits']['hits'];
    }
    else {
        print 'no result for this search';
    }

    $output['title_doc'] = 'Le contenu le plus pertinent :' . $nodes[0]['_source']['title'] . '';
    $output['score'] = 'Le meilleurs résultat de la recherche est :' . $nodes[0]['_score'] . '';

    //return '<p>Le contenu le plus pertinent :' . $nodes[0]['_source']['title'] . '</p>' . '<p>Avec comme score :' . $nodes[0]['_score'] . '</p>';
    /*return $app->render('template/result.php', array('node' => reset($output)));*/
    return $app['twig']->render('index.html.twig', ['result' => $output]);
  }

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   * affiche la page d'accueil.
   */
  public function home() {
    echo "Si vous voulez faire une recherche: ";

    return new Response("<a href='/recherche' class='button'>J'y vais !</a>");
  }
}
