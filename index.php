<?php

use Illuminate\Database\Capsule\Manager as DB;
require 'vendor/autoload.php';
session_start();

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/db.street.api.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$app = new Slim\Slim();

$app->get('/buildingPost', function() use ($app) {
    $c = new \app\controller\ControllerBuildingsPost($app->request()->params());
    $c->postBuilding();
});

$app->post('/buildingP', function() use ($app) {
    $c = new \app\controller\ControllerBuildingsPost($app->request()->params());
    $c->postBuilding();
});

$app->get('/allBuildingsInRegion', function() use ($app) {
    $c = new \app\controller\ControllerBuildingsGetRegion($app->request()->params());
    $c->getBuildingsRegion();
});

$app->get('/building', function() use ($app) {
    $c = new \app\controller\ControllerGetBuilding($app->request()->params());
    $c->getBuilding();
});

$app->get('/GEOjson', function() use ($app) {
    $c = new \app\controller\ControllerGetGeoJson();
    $c->getGEOJSON();
});

$app->get('/updateDesc', function() use ($app) {
    $c = new \app\controller\ControllerUpdateBuilding($app->request()->params());
    $c->updateBuilding();
});

$app->run();