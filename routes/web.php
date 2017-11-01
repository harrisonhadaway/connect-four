<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect()->route('restart');
});




Route::get('game/{id}/drop/{column}', function($id, $column) {

  // Get the current game
  $game = \App\Game::find($id);
  $board = json_decode($game->board);



  // Put checker in column
  // TODO: defaulting to row 0 - this needs to be fixed

  $board[0][$column] = $game->players[$game->turn % 2];


  // Did anyone win?



  // Increment turn counter
  $game->turn++;
  $game->board = json_encode($board);
  
  // Save the game state
  $game->save();

  // Show the board
  return redirect()->route('game', ['id' => $id]);

});







Route::get('game/{id}', function($id) {

  $game = \App\Game::find($id);

  $game_id = $id;
  $turn = $game->turn;
  $rows = $game->rows;
  $columns = $game->columns;
  $board = json_decode($game->board);

  $currentPlayer = $game->players[$turn % 2];
  
  return view('board', compact('game_id', 'currentPlayer', 'turn', 'board', 'rows', 'columns'));

})->name('game');





Route::get('/restart', function() {

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

})->name('restart');
