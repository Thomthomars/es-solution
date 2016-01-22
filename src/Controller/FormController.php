<?php
/**
 * Created by PhpStorm.
 * User: guivarch
 * Date: 17/09/15
 * Time: 11:39
 */


namespace Controller;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class FormController {

  public function form(Application $app) {

    $form = "<form action='/recherche/'><input type='text' name='recherche' value='' />";
    $form .= "<input type='submit' value='go !'></form>";


    return $app['twig']->render('form.html.twig', ['form' => $form]);

  }
}

