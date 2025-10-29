<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Match The Hidden Tiles</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    text-align: center;
    margin: 0;
    padding: 0;
  }
  #top {
    background: #343a40;
    color: white;
    padding: 10px;
  }
  #username {
    font-size: 20px;
    margin-bottom: 5px;
  }
  #points, #timer {
    font-size: 18px;
    margin: 5px;
  }
  #board {
    display: grid;
    grid-template-columns: repeat(10, 50px);
    grid-template-rows: repeat(10, 50px);
    justify-content: center;
    gap: 5px;
    margin: 20px auto;
    width: max-content;
  }
  .tile {
    width: 50px;
    height: 50px;
    background: #007bff;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .tile.flipped {
    background: #e9ecef;
  }
  .tile img {
    width: 48px;
    height: 48px;
  }
  #controls {
    margin-top: 15px;
  }
  #controls button {
    margin: 5px;
    padding: 8px 15px;
    border: none;
    background: #007bff;
    color: white;
    border-radius: 6px;
    cursor: pointer;
  }
  #controls button:hover {
    background: #0056b3;
  }
</style>
</head>
<body>

<div id="top">
  <div id="username">Welcome, <?php echo htmlspecialchars($username); ?></div>
  <div id="points">Points: 0</div>
  <div id="timer">Time: 00:00</div>
  <div id="moves">Moves: 250</div>
</div>

<div id="board"></div>

<div id="controls">
  <button id="btnNew">New Game</button>
  <button id="btnReset">Reset</button>
  <button id="btnPause">Pause</button>
  <button id="btnHint">Hint (-10)</button>
  <button id="btnAddMoves">+10 Moves (-20 points)</button>
  <button id="submitResult">Submit Result</button>
  <button id="btnStats">Statistics</button>
  <button id="btnExit">Exit</button>
</div>

<script src="assets/game.js"></script>
</body>
</html>
