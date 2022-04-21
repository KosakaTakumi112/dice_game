<?php

  abstract class File{

    static function getArrayFromCsv($file_path){
      $array_from_csv = [];

      $f = fopen($file_path, "r");
      while($line = fgetcsv($f)) {
        for ($i=0;$i<count($line);$i++) {
          $array_from_csv[] = $line[$i];
        }
      }

      fclose($f);

      return $array_from_csv;
    }

  }

?>