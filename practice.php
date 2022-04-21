<?php

  require_once "Classes/Game.php";
  require_once "Classes/Board.php";
  require_once "Classes/Player.php";
  require_once "Classes/Dice.php";

  $game = new Game();
  $game->setBoard(new Board("Classes/sample.csv"));
  $game->addPlayer(new Player("Taro"));
  $game->addPlayer(new Player("Jiro"));
  $game->setDice(new Dice());


  // echo $game->board->board[0] ;
  // print_r($game->players);
  
  $game->start();

?>