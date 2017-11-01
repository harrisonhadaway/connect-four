<!DOCTYPE html>
<html>
<head>
  <title>Laravel Connect Four</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="/style.css">
  <script src="https://use.fontawesome.com/14f1f2c704.js"></script>
</head>
<body class="text-center container">

<h1 class="mt-5">Laravel Connect Four</h1>

<div class="row justify-content-center mt-5">
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/0">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/1">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/2">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/3">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/4">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/5">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
  <div class="drop">
    <form method="get" action="/game/{{ $game_id }}/drop/6">
      <button class="btn btn-light">
        <i class="fa fa-arrow-down" aria-hidden="true"></i>
      </button>
    </form>
  </div>
</div>

<div class="mt-2 mb-3 board">
  
@for ($i = $rows -1; $i >= 0; $i--)

  <div class="row">

  @for ($j = 0; $j < $columns; $j++)

    <div class="spot {{ $board[$i][$j] }}">{{ $i }}, {{ $j }}</div>

  @endfor

  </div>

@endfor  

</div>

<div class="mt-5 mb-3">
  Current Player: {{ $currentPlayer }}
</div>

<div class="mb-3">
  Turn: {{ $turn }}
</div>

<div class="mt-5 mb-3">
  <form method="get" action="/restart">
    <button class="btn btn-light">Restart Game</button>
  </form>
</div>

</body>
</html>