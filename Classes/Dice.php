<?php

  class Dice{


    function __construct(){

    }

    static function rollDice(){
      echo "Enterを押してサイコロの目を確定させてください\n";
      fgets(STDIN);
      sleep(1);
      return rand(1,6);
    }

  }

?>