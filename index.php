<?php

require_once ('vendor/autoload.php');
$app = new \Slim\App;

use \cocktails\controler\Controller_test;


$app->get('/', function() {
  echo "C'est la racine";
});

$app->get('/calcul', function(){
  $c = new Controller_test();
  $c->test();
});

$app->run();
