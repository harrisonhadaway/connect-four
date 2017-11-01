<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

  // Variables available to every game
  public $players = ['Red', 'Blue'];
  public $rows = 6;
  public $columns = 7;

}
