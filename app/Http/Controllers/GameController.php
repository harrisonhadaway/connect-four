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

      // TODO: Did anyone win?


      // Increment turn counter
      $game->turn++;
      $game->board = json_encode($board);
      
      // Save the game state
      $game->save();

    }

    // Show the board
    return redirect()->route('game', ['id' => $id]);

  }

  public function game($id) {

    $game = \App\Game::find($id);

    $game_id = $id;
    $turn = $game->turn;
    $rows = $game->rows;
    $columns = $game->columns;
    $board = json_decode($game->board);

    $currentPlayer = $game->players[$turn % 2];
    
    return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns'));

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
