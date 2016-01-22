<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 15/09/15
 * Time: 16:06
 */

use Symfony\Component\HttpFoundation\Response;

header("Content-Type: text/html; charset=UTF-8");
/**
 * home.
 */
$app->get('/', "Controller\\NodeController::home");
$app->get('/home', "Controller\\NodeController::home");

/**
 * Listing nodes.
 */
$app->get('/node', "Controller\\NodeController::index");

/**
 * Affichage formulaire de recherche.
 */
$app->get('/search', "Controller\\FormController::form");

/**
 * Route /node/{nid} where {nid} is a node id.
 */
$app->get("/search/", "Controller\\NodeController::show");

/**
 * Route /connexion
 * Connection bdd et création index.
 */
$app->get("/connexion", "Controller\\NodeIndex::indexContenuCreat");

/**
 * Route /indexation
 * Affiche les nodes récupérer de la base de donnée distante.
 *
 */
$app->get("/indexation", "Controller\\NodeIndex::getContent");

/**
 * return User.
 */
$app->get("/users/{user}", function($user){
  return "User - {$user}";
})
  ->convert("user", function($id){
    $userRepo = new User();
    $user = $userRepo->find($id);

    if (!$user) {
      return new Response("User #{$id} not found.", 404);
    }
    return $user;
  });

/**
 * Error Handler.
 * Return Response with error.
 */
$app->error(function (\Exception $e, $code) {
  switch ($code) {
    case 404:
      $message = $e->getMessage();
      break;
    default:
      $message = ' We are sorry, but something went terribly wrong.' . $e->getMessage() . '<br />';
  }

  return new Response($message);
});
