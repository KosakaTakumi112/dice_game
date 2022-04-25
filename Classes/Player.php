<?php


  require_once "Item.php";
  require_once "File.php";

  class Player{

    public $name;
    public $standing_point;
    public $items = ["kinoko","wana","roto","roto","roto","roto"];
    public $special_skill;

    function __construct($name){
      $this->name = $name;
      $this->standing_point = 0;
      if($name == "Taro"){$this->special_skill = "changeWorld";}
      if($name == "Jiro"){$this->special_skill = "changePosition";}
    }

    function startCommand($dice,$board,$players){
      echo "\n" . $this->name . "さんの番です。\n";
      sleep(1);
      echo "コマンドを決めてください\n";
      sleep(1);
      while( true ){

        echo "サイコロ -> 1 , アイテム -> 2 , 必殺技 -> 3 \n";

        $selected_number = 0;
        while(!($selected_number == 1 || $selected_number == 2 || $selected_number == 3)){
  
          echo "数字の1か2か3で入力してください\n";   
          $selected_number = fgets(STDIN);

          if ($selected_number == 1){
            $number = $dice->rollDice();
            echo $number . "\n\n";
            sleep(2);
            echo $number . "が出ました。\n";
            sleep(1);
            echo $number . "マス進む。\n";
            return $number;
          }

          if ($selected_number == 2){
            echo "どのアイテムを使いますか？アイテムの詳細を見るには9を押してください。\n";
            foreach($this->items as $key => $value){
              echo $value . "を使う => " . $key . "を入力\n";
            }
            $item_number = fgets(STDIN);
            if(!(is_numeric($item_number))){ break; }
            $item_number = (int) $item_number;
            if($item_number == 9){ Item::printEffect($this->items); break;}

            $item_name = $this->items[$item_number];
            if($item_name){
              echo $item_name . "を使った。\n";
              $number = Item::useItem($item_name,$this,$board,$players);
              unset($this->items[$item_number]);
              return $number;
            }
          }

          if ($selected_number == 3){
            if(!$this->special_skill){ echo "必殺技はもう使いました\n"; break;}
            echo "必殺技を使いますか？必殺技は１度しか使えません。\n";
            echo $this->name. "の必殺技は" . $this->special_skill . "\n";
            echo "使う => 1   使わない => n \n";
            $item_number = fgets(STDIN);
            if(!(is_numeric($item_number))){ break; }
            $item_number = (int) $item_number;

            if($item_number == 1){
              echo "必殺技を使った！\n";
              if($this->special_skill == "changeWorld"){
                echo "チェンジワールド！\n";
                $this->special_skill = false;
                return "changeWorld";
              }
              if($this->special_skill == "changePosition"){
                echo "チェンジポジション！\n";
                $this->special_skill = false;
                Item::useItem("teleport",$this,$board,$players);
                return;
              }
              return false;
            }
          }

        }
      }
    }


    function goForward($n){
      $this->standing_point += $n;
    }

    function goBackward($n){
      $this->standing_point -= $n;
      if ($this->standing_point < 0){
        $this->standing_point = 0;
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

      sleep(1);
      echo $this->name . "さんは" . $this->standing_point . "マス目に止まった。\n";
      sleep(1);

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

        if($number_on_standing_point == 0){
          echo "マスの効果はなし！\n";
          sleep(1);
          echo "寂しいから名言をプレゼント！\n";
          sleep(2);
          $random_number = rand(1,3);
          $messages = 
          [
            "Vision:テクノロジーで世界を革新する。",
            "Mission:ITの専門知識と課題解決の知見によって社会をアップデートする。",
            "行動指針:ハイスタンダードであれ 変革を体現する 個の成長を追求せよ チャレンジが全て",
            "結論firstか、全体像から話すか、その使い分けは聞き手の背景知識の有無である。",
            "今どんなに辛くても一年後は笑っているさ",
            "せっかくお弁当作ったのに持っていくの忘れた、、、。",
            "仕事を通して「専門性」を高めていく、「人間性」を深めていく、「人格」を高めていく、「魂」を磨いていくということ。",
            "俺がやる、協力する、明るくする",
            "自分には何ができるか悩み抜け",
            "結果が出ない努力に意味はない",
          ];
          $message = $messages[$random_number];
          $message_array = preg_split("/\B/u", $message);
          foreach($message_array as $key => $value){
              echo $value;
              usleep(100000);
          }
        }
      }

      if(is_string($number_on_standing_point)){
        if ($number_on_standing_point == "穴"){
          sleep(1);
          echo "振り出しに戻ってしまった！\n";
          $this->standing_point = 0;
          sleep(1);

        }
        if ($number_on_standing_point == "罠"){
          sleep(1);

          echo "罠に引っかかってしまった！\n";
          sleep(1);
          $this->items = [];
          echo "アイテムを全て失った！\n";
          sleep(1);

        }
      }


    }


  }

?>