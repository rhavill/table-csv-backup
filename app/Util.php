<?php

namespace App;


class Util
{
  public static function backtickEscape($text) {
    return '`' . str_replace('`', '``', $text) . '`';
  }

  // copied from http://stackoverflow.com/questions/4249432/export-to-csv-via-php
  public static function array2csv(array &$array)
  {
    if (count($array) == 0) {
      return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    //fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
      fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
  }


}