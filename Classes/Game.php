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

    function printGameProgress($player){
      $progress = $this->board->board;
      $progress[$player->standing_point] = $player->name;
      $tmp = [];
      foreach($progress as $key => $value){
        $masu = <<<EOT
        | $value 
        EOT;
        $tmp[] = $masu;
      }
      echo "\n";
      foreach($tmp as $key => $value){
        echo $value;
      }
      echo "\n";
    }

    function start(){
      echo "ゲームを始めます。\n";
      echo "ゴールは". $this->board->goal_point ."マス目にあります。\n";
      while($this->players){
        foreach($this->players as $key => $player){

          $this->printGameProgress($player);

          //サイコロ・アイテム・必殺技のコマンド選択
          $dice_number = $player->startCommand($this->dice,$this->board,$this->players);
          //もし移動しないアイテムを使っていた場合は、ターン終了
          if(!$dice_number){ break ; }

          //進むか戻るか判定する。
          $player->goOrBack($dice_number, $this->board->goal_point);

          //移動した後のゴール判定
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

          $this->printGameProgress($player);

        }
      }
    }
  }
?>