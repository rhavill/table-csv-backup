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
use Illuminate\Http\Response;
use App\Util;

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

$app->get('/table/{table}', function ($table) {
  try {
    $records = app('db')->select("SELECT * FROM " . Util::backtickEscape($table));
  }
  catch (Exception $e) {
    return response('Database table does not exist.', 404);
  }
  $data = array();
  if ($records) {
    for ($i = 0; $i < count($records); $i++) {
      $record = (array)$records[$i];
      if ($i == 0) {
        $data[] = array_keys($record);
      }
      // Replace null value with the string "NULL"
      $row = array();
      foreach(array_values($record) as $value) {
        $row[] = is_null($value) ? 'NULL' : $value;
      }
      $data[] = $row;
    }
  }
  else {
    $columnData = app('db')->select(
        "SELECT column_name FROM information_schema.columns WHERE table_name = ?",
        [$table]
    );
    $columns = array();
    foreach ($columnData as $record) {
      $columns[] = $record->column_name;
    }
    $data[] = $columns;
  }
  $data = Util::array2csv($data);
  $fileName = date('YmdHis') . '.csv';
  $now = gmdate("D, d M Y H:i:s");
  return response($data, 200)
      ->header('Content-Type', 'text/comma-separated-values')
      ->header('Expires', "$now GMT")
      ->header('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate, pre-check=0, post-check=0, max-age=0')
      ->header('Last-Modified', "$now GMT")
      ->header('Pragma', 'no-cache')
      ->header('Content-Disposition', "attachment;filename=$fileName")
      ->header('Content-Transfer-Encoding', 'binary');
});

$app->post('/table', function () {
  return json_encode(array('success'=> true, "uuid" => 1));
});