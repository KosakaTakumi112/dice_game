<?php

  class Dice{


    function __construct(){

    }

    static function rollDice(){
      echo "Enterを押してサイコロの目を確定させてください\n";
      fgets(STDIN);
      return rand(1,6);
    }

  }

?>