<?php


  class Player{

    public $name;
    public $standing_point;

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

    function startCommand($dice){
      echo "\n" . $this->name . "さんの番です。\nサイコロを振ってください\n";
      echo "Enterを押してサイコロの目を確定させてください\n";
      fgets(STDIN);
      $number = $dice->rollDice();
      echo $number . "が出ました。\n\n";
      echo $number . "マス進む\n";
      return $number;
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

  }

?>