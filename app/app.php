<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Inventory.php";

  $app = new Silex\Application();

  $DB = new PDO('pgsql:host=localhost;dbname=to_do');

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  $app->get("/", function() use ($app) {
    return $app['twig']->render('index.twig');
  });

  $app->get("/items", function() use ($app) {
    return $app['twig']->render('items.twig', array('items' => Inventory::getAll()));
  });

  $app->post("/items", function() use ($app) {
    $category = new Inventory($_POST['name']);
    $category->save();
    return $app['twig']->render('items.twig', array('items' => Inventory::getAll()));
  });

  $app->post("/deleteItems", function() use ($app) {
    Inventory::deleteAll();
    return $app['twig']->render('index.twig');
  });

  return $app;
?>
