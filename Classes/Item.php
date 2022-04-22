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

      if($name == "roto"){
        echo "さぁ、サイコロを降りなさい！\n";
        echo "でた目が1か6なら以下の効果が得られる！\n";
        echo "1 => 全ての人の居場所を入れ替えちゃう。\n";
        echo "6 => みんな振り出しになる\n";
        $dice = Dice::rollDice();
        sleep(1);
        echo $dice . "\n\n";
        sleep(1);
        if($dice == 1){
          echo "全ての人の居場所がランダムに入れ替わる！\n";
          return;
        }
        if($dice == 6){
          echo "みんな振り出しになった！\n";
          return;
        }
        echo "ハズレ！ターン終了\n";
        return;
      }
    }

  }

?>