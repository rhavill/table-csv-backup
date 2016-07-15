<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    $tables = array();
    $results = app('db')->select("SHOW TABLES");
    foreach ($results as $result) {
        $properties = get_object_vars($result);
        if (count($properties) == 1) {
            $keys = array_keys($properties);
            $tables[] = $properties[$keys[0]];
        }
    }
    return view('home', ['tables' => $tables]);
});
