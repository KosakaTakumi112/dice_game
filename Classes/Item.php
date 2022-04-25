<?php

  require_once "Dice.php";

  abstract class Item{

    static function printEffect($items){
      $explain_effect
      =
      [ "kinoko" => "サイコロを2つふることができる。",
        "wana" => "今いるマスに罠を仕掛けることができる。",
        "teleport" => "相手と居場所を交換する",
        "roto" => "いいことが起こるかも",
        "ガリガリくん" => "ガリガリ....",
        "fly_ticket" => "豪華なフライトができる",
      ];

      foreach($items as $key => $value){
        echo $value . ":". $explain_effect[$value] . "\n";
      }
    }

    static function useItem($name,$player="",$board="",$players=""){
      //ひたすらここにアイテムの効果を書いていくいつか分別が必要

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
        $number = 0;
        echo $player->name . "は" . $players[$number]->name . "と場所を交換した！\n";
        $tmp = $player->standing_point;
        $player->standing_point = $players[$number]->standing_point;
        $players[$number]->standing_point = $tmp;
        return;
      }

      if($name == "roto"){
        echo "さぁ、サイコロを降りなさい！\n";
        echo "でた目が6なら豪華アイテムゲット！\n";
        $dice = Dice::rollDice();
        sleep(1);
        echo $dice . "\n\n";
        sleep(1);
        if($dice == 6){
          echo "大当たり！\n";
          echo "ガリガリくんプレゼント！\n";
          $player->items[] = "ガリガリくん";
          return;
        }
        echo "ハズレ！ターン終了\n";
        return;
      }

      if($name == "ガリガリくん"){
        echo "ガリガリくんを食べた！\n";
        sleep(1);
        echo "......\n";
        sleep(1);
        echo "何とガリガリくんも当たってしまった！\n";
        sleep(1);
        echo "お店に持ってくと当たり棒と引き換えに航空券をもらった！\n";
        $player->items[] = "fly_ticket";
        return;

      }

      if($name == "fly_ticket"){
        echo "航空券を使って豪華にひとっ飛び!\n";
        sleep(1);
        echo "ふぅ〜いいフライドだったな... \n";
        sleep(1);
        echo "ゴールの１マス前に着陸した。\n";
        $player->standing_point = $board->goal_point -1;
        return ;
      }
    }

  }

?>