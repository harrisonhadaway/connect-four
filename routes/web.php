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

    $players = ['Red', 'Blue'];
    $turn = 5;
    $currentPlayer = $players[$turn % 2];
    $board = [];
    $rows = 6;
    $columns = 7;
    for ($r = 0; $r < $rows; $r++) {
      for ($c = 0; $c < $columns; $c++) {
        $board[$r][$c] = '';
      }
    }

    return view('board', compact('currentPlayer', 'board', 'rows', 'columns'));
    
});
