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
          echo $number . "マス進む\n";

          //ここに進むか戻るかゴールの判定をしたメソッドを用意する。
          $next_point = $player->standing_point + $number;

          if ($next_point <= $this->board->goalNumber){
            $player->goForward($number);
          }

          if ($next_point > $this->board->goalNumber){
            $goNumber = $this->board->goalNumber - $player->standing_point;
            $player->goForward($goNumber);
            $backNumber = $number - $goNumber;
            $player->goBackward($backNumber);
            echo "ゴール地点で折り返し！\n";
            echo $backNumber . "マス戻った！";
          }


          //ゴール判定
          if ($player->standing_point == $this->board->goalNumber){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
          }else{
            echo $player->name . "さんは現在" . $player->standing_point . "マス目にいます。\n";
          }

        }

      }
    }


    


  }

?>