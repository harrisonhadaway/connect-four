<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{

  public function index() {

    // What should be here? 

  }

  public function drop($id, $column) {

    // Get the current game
    $game = \App\Game::find($id);
    $board = json_decode($game->board);

    // Put checker in column
    $placed_checker = false;
    for ($i = 0; $i < $game->rows; $i++) {
      if ($board[$i][$column] === '') {
        $board[$i][$column] = $game->players[$game->turn % 2];
        $placed_checker = true;
        break;
      }
    }
    if ($placed_checker) {

      // Did anyone win?
      $isWon = $this->checkBoard($board);
      if ($isWon) {

        // game is over


        // display a message


        // mark game as no longer in progress
        $game->in_progress = false;


      }
      else {

        // continue

      }

      // Increment turn counter
      $game->turn++;
      $game->board = json_encode($board);
      
      // Save the game state
      $game->save();

    }

    // Show the board
    return redirect()->route('game', ['id' => $id]);

  }

  public function checkBoard($board) {

    // $board is a 2-dimensional array

    $wins = [
      [ [0,0], [0,1], [0,2], [0,3] ],
      [ [1,0], [1,1], [1,2], [1,3] ]
    ];

    for ($i = 0; $i < count($wins); $i++) {

      // $wins[$i] = an array of coordinates
      // error_log("Checking...\$wins[" . $i . "]");
      // error_log(print_r($wins[$i], true));

      // compareLine(
      //   $board[ $wins[0][0] ][ $wins[0][1] ], 
      //   $board[ $wins[1][0] ][ $wins[1][1] ], 
      //   $board[ $wins[2][0] ][ $wins[2][1] ], 
      //   $board[ $wins[3][0] ][ $wins[3][1] ]
      // );

    }

    return false;

  }

  // private function compareLine($a $b, $c, $d) {
  //   return $a === $b === $c === $d;
  // }


  public function game($id) {

    $game = \App\Game::find($id);

    $game_id = $id;
    $turn = $game->turn;
    $rows = $game->rows;
    $columns = $game->columns;
    $board = json_decode($game->board);
    $in_progress = $game->in_progress;

    $currentPlayer = $game->players[$turn % 2];
    
    return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns', 'in_progress'));

  }

  public function restart() {

    // TODO: End the old game
    // ??? set in_progress to false ???
    // Not safe to do until we have user logins!!!

    // Make a new game
    $game = new \App\Game;
    $game->turn = 1;
    $board = [];
    for ($r = 0; $r < $game->rows; $r++) {
      for ($c = 0; $c < $game->columns; $c++) {
        $board[$r][$c] = '';
      }
    }
    $game->board = json_encode($board);
    $game->save();

    // What's my id?
    $id = $game->id;

    // Show the board
    return redirect()->route('game', ['id' => $id]);

  }

}
