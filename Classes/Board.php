<?php

  require_once "File.php";

  class Board{

    public $board;
    public $goalNumber;

    function __construct($path){
      $this->board = File::getArrayFromCsv($path);
      $this->goalNumber = count($this->board);
    }

    function getBoard(){
      return $this->board;
    }

  }

?>