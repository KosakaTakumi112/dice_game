<?php


  require_once "Item.php";

  class Player{

    public $name;
    public $standing_point;
    public $items = ["kinoko","wana","teleport"];
    public $special_skill;

    function __construct($name){
      $this->name = $name;
      $this->standing_point = 0;
    }

    function goForward($n){
      $this->standing_point += $n;
    }

    function goBackward($n){
      $this->standing_point -= $n;
    }

    function startCommand($dice,$board,$players){
      echo "\n" . $this->name . "さんの番です。";
      echo "コマンドを決めてください\n";
      while( true ){
        echo "サイコロ -> 1 , アイテム -> 2 , 必殺技 -> 3 \n";
        $selected_number = 0;
        while(!($selected_number == 1 || $selected_number == 2 || $selected_number == 3)){
          echo "数字の1か2か3で入力してください\n";   
          $selected_number = fgets(STDIN);

          if ($selected_number == 1){
            $number = $dice->rollDice();
            echo $number . "が出ました。\n\n";
            echo $number . "マス進む\n";
            return $number;
          }

          if ($selected_number == 2){
            echo "どのアイテムを使いますか？アイテムを使わない場合は、bを押してください。\n";
            foreach($this->items as $key => $value){
              echo $value . "を使う => " . $key . "を入力\n";
            }
            $item_number = fgets(STDIN);
            if(!(is_numeric($item_number))){ break; }
            $item_number = (int) $item_number;
            $item_name = $this->items[$item_number];

            if($item_name){
              echo $item_name . "を使った。\n";
              $number = Item::useItem($item_name,$this,$board,$players);
              unset($this->items[$item_number]);
              //ここでアイテム毎のコマンドを実行させて、進む数字を返す。数字を返さなければ終わらせる。
              return $number;
            }
          }
        }
      }
    }

    function goOrBack($dice_number, $goal_point){
      $next_point = $this->standing_point + $dice_number;

      if ($next_point <= $goal_point){
        $this->goForward($dice_number);
      }

      if ($next_point > $goal_point){
        $goNumber = $goal_point - $this->standing_point;
        $this->goForward($goNumber);
        $backNumber = $dice_number - $goNumber;
        $this->goBackward($backNumber);
        echo "ゴール地点で折り返し！\n";
        echo $backNumber . "マス戻った！";
      }

      echo $this->name . "さんは" . $this->standing_point . "マス目に止まった。\n";
    }

    function getEffectOnStandingPoint($number_on_standing_point){

      if(is_numeric($number_on_standing_point)){
        if ($number_on_standing_point > 0){
          echo "マスの効果発動！\n";
          echo $this->name . "は" . $number_on_standing_point. "マス進んだ！\n";
          $this->goForward($number_on_standing_point);
          echo $this->name . "さんは" . $this->standing_point . "マス目に止まった。\n";
        }
        if ($number_on_standing_point < 0){
          echo "マスの効果発動！\n";
          echo $this->name . "は" . $number_on_standing_point. "マス戻る\n";
          $this->goBackward($number_on_standing_point);
          echo $this->name . "さんは" . $this->standing_point . "マス目に止まった。\n";
        }
      }

      if(is_string($number_on_standing_point)){
        if ($number_on_standing_point == "穴"){
          echo "振り出しに戻ってしまった！\n";
        }
        if ($number_on_standing_point == "アイテム"){
          echo "アイテムがもらえる\n";
        }
        if ($number_on_standing_point == "休み"){
          echo "滑って転んで一回休みになった！\n";
        }
      }


    }


  }

?>