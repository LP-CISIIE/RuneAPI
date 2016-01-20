<?php
/**
 * Created by PhpStorm.
 * User: locoman
 * Date: 12/01/16
 * Time: 15:47
 */

namespace front\controller;


class indexController
{
    public static function index($app)
    {
        $action = $app->urlFor('index');
        $app->render('index.html.twig', array(
            "test" => "test",
            "action" => $action
        ));
    }
}