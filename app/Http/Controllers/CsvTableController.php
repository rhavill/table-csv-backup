<?php
/**
 * Created by PhpStorm.
 * User: wec
 * Date: 7/17/16
 * Time: 5:42 PM
 */

namespace App\Http\Controllers;
use App\Util;

class CsvTableController extends Controller
{
  public function getTables() {
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
  }

  public function getTable($table) {
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
  }
  public function createTable() {
    $request = app('request');
    $table = $request->input('table');
    if ($request->hasFile('qqfile') && $request->file('qqfile')->isValid()) {
      $file = $request->file('qqfile');
      //$mime = $file->getMimeType();
      $fh = fopen($file->getRealPath(), 'r');
      $firstRow = fgetcsv($fh, 1000, ",");
      $sql= 'CREATE TABLE ' . Util::backtickEscape($table) . ' (';
      foreach($firstRow as $columnName) {
        $sql .= Util::backtickEscape($columnName).' VARCHAR(255), ';
      }
      $sql = substr($sql,0,strlen($sql)-2);
      $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8';
      app('db')->beginTransaction();
      try {
        app('db')->statement($sql);
      }
      catch (Exception $e) {
        return json_encode(array('error'=> 'Error creating table. Check table name.'));
      }
      $doInsert = FALSE;
      $sql= 'INSERT INTO ' . Util::backtickEscape($table) . ' VALUES ';
      while (($row = fgetcsv($fh, 1000, ",")) !== FALSE) {
        $doInsert = TRUE;
        $values = array();
        foreach ($row as $cell) {
          $values[] = $cell == 'NULL' ? 'NULL' : app('db')->getPdo()->quote($cell);
        }
        $sql .= '('. implode(', ', $values) . '), ';
      }
      $sql = substr($sql,0,strlen($sql)-2);

      if ($doInsert) {
        try {
          app('db')->statement($sql);
        }
        catch (Exception $e) {
          app('db')->rollBack();
          return json_encode(array('error'=> 'Error inserting data.'));
        }
      }
      app('db')->commit();
      fclose($fh);
      return json_encode(array('success'=> true, 'table'=>$table, 'sql'=>$sql));
    }
    return json_encode(array('error'=> 'Error uploading file.'));
  }
}
