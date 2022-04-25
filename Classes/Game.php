<?php

  require_once "Board.php";

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
      echo "========================================================================================================================================\n";
      foreach($tmp as $key => $value){
        echo $value;
      }
      echo "\n";
      echo "========================================================================================================================================\n";

    }

    function start(){
      sleep(1);
      echo "第三回すごろく大会決勝を開始します。\n";
      sleep(1);
      echo "決勝に進出したプレイヤーの紹介をします。\n";
      sleep(1);
      echo "過去二大会共に優勝している最強プレイヤーの~~~~\n";
      sleep(2);
      echo "Jiro------!\n";
      sleep(1);
      echo "Jiroくんの必殺技は大変強いですからね〜。それが優勝の秘訣でもありますよね。\n";
      sleep(1);
      echo "そして対する今回の挑戦者は~~~~~\n";
      sleep(1);
      echo "Taro----------！\n";
      sleep(1);
      echo "彼にも頑張ってほしいですね。\n";
      sleep(2);
      echo "それではゲームを始めます。\n";
      sleep(1);
      echo "ゴールは". $this->board->goal_point ."マス目にあります。\n";
      sleep(1);
      echo "すごろく開始！\n";

      while($this->players){
        foreach($this->players as $key => $player){

          sleep(1);
          $this->printGameProgress($player);

          //サイコロ・アイテム・必殺技のコマンド選択
          $dice_number = $player->startCommand($this->dice,$this->board,$this->players);
          //もし移動しないアイテムを使っていた場合は、ターン終了
          if($dice_number == "changeWorld"){$this->setBoard(new Board("Classes/sample1.csv")); continue;}
          if(!$dice_number){ continue ; }

          //進むか戻るか判定する。
          $player->goOrBack($dice_number, $this->board->goal_point);

          //移動した後のゴール判定
          if ($player->standing_point == $this->board->goal_point){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
            break;
          }

          $number_on_standing_point = $this->board->board[$player->standing_point];
          sleep(1);
          echo $player->standing_point . "マス目に書かれている数字は" . $number_on_standing_point. "だ！\n";
          sleep(1);


          //マスに書いてある数字が0以外であれば効果を受ける
          $player->getEffectOnStandingPoint($number_on_standing_point);

          //効果を受け、移動した後のゴール判定
          if ($player->standing_point == $this->board->goal_point){
            echo $player->name . "さんがゴールしました!\n";
            unset($this->players[$key]);
            break;
          }

          sleep(1);
          $this->printGameProgress($player);
         

        }
      }
    }
  }
?>