<?php

  class Player{

    public $name;
    public $standing_point;

    function __construct($name){
      $this->name = $name;
      $this->standing_point = 0;
    }

    function goForward($n){
      $this->standing_point += $n;
    }

    function goBackward($n){
      $this->standing_point -= $n;
    }


  }

?>