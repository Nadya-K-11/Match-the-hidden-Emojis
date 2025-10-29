const ROWS = 10, COLS = 10, TOTAL = ROWS * COLS;
let board = [], revealed = [], matched = [];
let first = null, second = null;
let moves = 0, errors = 0, points = 0;
let seconds = 0, timerInt = null, paused = false;
const imageCount = 25;

function shuffle(a) {
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a;
}

function initBoard() {
  const arr = [];
  for (let i = 1; i <= imageCount; i++) arr.push(i, i);
  while (arr.length < TOTAL) arr.push((arr.length % imageCount) + 1);
  shuffle(arr);
  board = arr;
  revealed = new Array(TOTAL).fill(false);
  matched = new Array(TOTAL).fill(false);
  moves = errors = points = seconds = 0;
  paused = false;
  clearInterval(timerInt);
  timerInt = setInterval(() => {
    if (!paused) {
      seconds++;
      updateClock();
    }
  }, 1000);
  render();
}

function render() {
  const b = document.getElementById('board');
  b.innerHTML = '';
  for (let i = 0; i < TOTAL; i++) {
    const d = document.createElement('div');
    d.className = 'tile' + (revealed[i] || matched[i] ? ' flipped' : '');
    if (revealed[i] || matched[i]) {
      const img = document.createElement('img');
      img.src = 'assets/tiles/' + board[i] + '.png';
      d.appendChild(img);
    }
    d.onclick = () => clickTile(i);
    b.appendChild(d);
  }
  document.getElementById('points').textContent = 'Points: ' + points;
}

function updateClock() {
  const m = Math.floor(seconds / 60).toString().padStart(2, '0');
  const s = (seconds % 60).toString().padStart(2, '0');
  document.getElementById('timer').textContent = 'Time: ' + m + ':' + s;
}

let current_combo_counter = 0;

function clickTile(i) {
  if (paused || matched[i] || revealed[i]) return;
  if (first !== null && second !== null) return;

  revealed[i] = true;
  render();

  if (first === null) {
    first = i;
    return;
  }

  second = i;

  if (board[first] === board[second]) {
	  
    matched[first] = matched[second] = true;

    current_combo_counter++;
    points += 10 * current_combo_counter;

    first = second = null;
    render();

    if (matched.every(x => x)) endGame(true);
  } else {
	  
    errors++;
    moves++; 
    current_combo_counter = 0;

    setTimeout(() => {
      revealed[first] = revealed[second] = false;
      first = second = null;
      render();
    }, 700);
  }

  document.getElementById('points').textContent = 'Points: ' + points;
  document.getElementById('moves').textContent = 'Moves: ' + moves;
}


function hint() {

  let firstHidden = -1, pairIndex = -1;
  for (let i = 0; i < TOTAL; i++) {
    if (!matched[i] && !revealed[i]) {
      if (firstHidden === -1) {
        firstHidden = i;
      } else if (board[i] === board[firstHidden]) {
        pairIndex = i;
        break;
      }
    }
  }

  if (firstHidden !== -1 && pairIndex !== -1) {
    revealed[firstHidden] = true;
    revealed[pairIndex] = true;
    render();
    setTimeout(() => {
      revealed[firstHidden] = false;
      revealed[pairIndex] = false;
      render();
    }, 1500);
    points = Math.max(0, points - 10);
    document.getElementById('points').textContent = 'Points: ' + points;
  }
}

function endGame(won) {
  clearInterval(timerInt);

  if (won) {
    const timeUsed = seconds;
    const earnedPoints = points;

    fetch('api/submit_result.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        user_id: userId,
        username: username,
        score: earnedPoints,
        moves_used: moves,
        errors: errors,
        time_taken_seconds: timeUsed
      })
    })
    .then(res => res.text())
    .then(data => {
      alert('You won! Points submitted.');

      window.location.href = "index.php";
    })
    .catch(err => {
      console.error(err);
      alert("Error submitting result!");
    });
  } else {
    alert('Game over!');
  }
}


document.getElementById('btnNew').onclick = initBoard;
document.getElementById('btnReset').onclick = initBoard;
document.getElementById('btnPause').onclick = () => {
  paused = !paused;
  document.getElementById('btnPause').textContent = paused ? 'Resume' : 'Pause';
};
document.getElementById('btnHint').onclick = hint;
document.getElementById('btnStats').onclick = () => location.href = 'stats.php';
document.getElementById('btnExit').onclick = () => location.href = 'index.php';
document.getElementById('btnAddMoves').onclick = () => {
  if (points >= 20) {
    moves += 10;
    points -= 20;
    document.getElementById('moves').textContent = 'Moves: ' + moves;
    document.getElementById('points').textContent = 'Points: ' + points;
  } else {
    alert("Not enough points to buy extra moves!");
  }
};

initBoard();
