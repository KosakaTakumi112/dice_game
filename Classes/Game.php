<?php

  class Game{

    public $board = [];
    public $players = [];
    public $dice;

    function __construct(){
    }

    function setBoard($board){
      $this->board = $board;
    }

    function addPlayer($player){
      $this->players[] = $player;
    }

    function setDice($dice){
      $this->dice = $dice;
    }

    function start(){
      echo "ゲームを始めます。\n";
      echo "ゴールは". $this->board->goalNumber ."マス目にあります。";
      while($this->players){
        foreach($this->players as $key => $player){
          
          echo $player->name . "さんの番です。サイコロを振ってください\n";
          echo "Enterを押してサイコロの目を確定させてください\n";
          fgets(STDIN);
          $number = $this->dice->rollDice();
          echo $number . "が出ました。\n";

          //ここに進むか戻るかゴールの判定をしたメソッドを用意する。
          echo $number . "マス進む\n";
          $player->goForward($number);
          echo $player->name . "さんは現在" . $player->standing_point . "マス目にいます。\n";

          if ($player->standing_point > $this->board->goalNumber){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
          }

        }

      }
    }


    


  }

?>