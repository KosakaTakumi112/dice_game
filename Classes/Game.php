<?php

  class Game{

    public $board;
    public $players = [];
    public $dice;

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
      echo "ゴールは". $this->board->goal_point ."マス目にあります。\n\n";
      while($this->players){
        foreach($this->players as $key => $player){

          //サイコロをふる
          $dice_number = $player->startCommand($this->dice);

          //進むか戻るか判定する。
          $player->goOrBack($dice_number, $this->board->goal_point);

          //サイコロをふり、移動した後のゴール判定
          if ($player->standing_point == $this->board->goal_point){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
            break;
          }

          $number_on_standing_point = $this->board->board[$player->standing_point];
          echo $player->standing_point . "マス目に書かれている数字は" . $number_on_standing_point. "だ！\n";

          //マスに書いてある数字が0以外であれば効果を受ける
          $player->getEffectOnStandingPoint($number_on_standing_point);

          //効果を受け、移動した後のゴール判定
          if ($player->standing_point == $this->board->goal_point){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
            break;
          }

        }
      }
    }
  }
?>