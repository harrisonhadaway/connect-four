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

        // display a message
        $game->message = $game->players[$game->turn % 2] . " won!";

        // mark game as no longer in progress
        $game->in_progress = false;

      }

      // TODO: Is it a draw?
      // It's a draw if turn = 42 and nobody has won
      if ($game->turn === 42) {

        // display a message
        $game->message = "It's a draw!";

        // mark game as no longer in progress
        $game->in_progress = false;

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

    // $wins is the set of lines on the board that represent wins
    $wins = [
      [ [0,0], [0,1], [0,2], [0,3] ],
      [ [1,0], [1,1], [1,2], [1,3] ]
    ];

    $game_over = false;

    for ($i = 0; $i < count($wins) && !$game_over; $i++) {

      $game_over = $this->compareLine(
        $board[ $wins[$i][0][0] ][ $wins[$i][0][1] ], 
        $board[ $wins[$i][1][0] ][ $wins[$i][1][1] ], 
        $board[ $wins[$i][2][0] ][ $wins[$i][2][1] ], 
        $board[ $wins[$i][3][0] ][ $wins[$i][3][1] ]
      );

    }

    return $game_over;

  }

  private function compareLine($a, $b, $c, $d) {
    return $a !== '' && $a === $b && $a === $c && $a === $d;
  }

  public function game($id) {

    $game = \App\Game::find($id);

    $game_id = $id;
    $turn = $game->turn;
    $rows = $game->rows;
    $columns = $game->columns;
    $board = json_decode($game->board);
    $in_progress = $game->in_progress;
    $message = $game->message;

    $currentPlayer = $game->players[$turn % 2];
    
    return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns', 'in_progress', 'message'));

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
