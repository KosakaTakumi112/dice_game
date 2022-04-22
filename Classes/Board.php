<?php

  require_once "File.php";

  class Board{

    public $board;
    public $goal_point;

    function __construct($path){
      $this->board = File::getArrayFromCsv($path);
      $this->goal_point = count($this->board) - 1;
    }

    function getBoard(){
      return $this->board;
    }

  }

?>