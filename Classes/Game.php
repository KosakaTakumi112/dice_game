<?php

  class Game{

    public $board;
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
      echo "ゴールは". $this->board->goalNumber ."マス目にあります。\n\n";
      while($this->players){
        foreach($this->players as $key => $player){
          
          echo "\n" . $player->name . "さんの番です。\nサイコロを振ってください\n";
          echo "Enterを押してサイコロの目を確定させてください\n";
          fgets(STDIN);
          $number = $this->dice->rollDice();
          echo $number . "が出ました。\n\n";
          echo $number . "マス進む\n";

          //進むか戻るか判定する。
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
            break;
          }
          
          echo $player->name . "さんは" . $player->standing_point . "マス目に止まった。\n";
          $number_on_standing_point = $this->board->board[$player->standing_point];

          echo $player->standing_point . "マス目に書かれている数字は" . $number_on_standing_point. "だ！\n";

          //効果判定
          if ($number_on_standing_point > 0){
            echo "マスの効果発動！\n";
            echo $player->name . "は" . $number_on_standing_point. "マス進んだ！\n";
            $player->goForward($number_on_standing_point);
            echo $player->name . "さんは" . $player->standing_point . "マス目に止まった。\n";

          }
          if ($number_on_standing_point < 0){
            echo "マスの効果発動！\n";
            echo $player->name . "は" . $number_on_standing_point. "マス戻る\n";
            $player->goBackward($number_on_standing_point);
            echo $player->name . "さんは" . $player->standing_point . "マス目に止まった。\n";

          }

          //効果判定後のゴール判定
          if ($player->standing_point == $this->board->goalNumber){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
            break;
          }

        }

      }
    }


  }

?>