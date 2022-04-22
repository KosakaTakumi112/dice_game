<?php

  require_once "Dice.php";

  abstract class Item{

    public $explain_effect
    =
    [ "kinoko" => "サイコロを2つふることができる。",
      "wana" => "今いるマスに罠を仕掛けることができる。",
      "teleport" => "相手と居場所を交換する",
    ];


    function __construct(){

    }

    static function useItem($name,$player="",$board="",$players=""){

      if($name == "kinoko"){
        $dice1 = Dice::rollDice();
        echo "１つ目のサイコロは" . $dice1 . "が出た！\n";
        $dice2 = Dice::rollDice();
        echo "2つ目のサイコロは" . $dice2 . "が出た！\n";
        return $dice1 + $dice2;
      };

      if($name == "wana"){
        echo $player->name . "は今いる" . $player->standing_point . "マス目に罠を仕掛けた！\n";
        $board->board[$player->standing_point] = "罠";
        $dice = Dice::rollDice();
        return $dice;
      }

      if($name == "teleport"){
        echo $player->name . "はテレポートを使った。\n";
        echo "誰と居場所を交換しますか？\n";
        foreach($players as $key => $player1){
          if($player == $player1){ continue;}
          echo $player1->name . "=>" . $key . "\n";
        }
        $number = (int) fgets(STDIN);
        echo $player->name . "は" . $players[$number]->name . "と場所を交換した！\n";
        $tmp = $player->standing_point;
        $player->standing_point = $players[$number]->standing_point;
        $players[$number]->standing_point = $tmp;
        return;
      }
    }

  }

?>