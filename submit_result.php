<?php
include("../db.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$username = $data['username'];
$score = $data['score'];
$total_score = $data['total_score'];
$moves_used = $data['moves_used'];
$time_taken = $data['time_taken_seconds'];


$eff = round($score / max($time_taken, 1), 2);
$stmt = $conn->prepare("INSERT INTO winners (user_id, username, score, time_taken_seconds, victory_date, efficiency) VALUES (?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("isiii", $user_id, $username, $score, $time_taken, $eff);
$stmt->execute();


$errors = max(0, $moves_used - Math.floor($score/10));
$stmt = $conn->prepare("INSERT INTO results (user_id, username, score, moves_used, errors, time_taken_seconds, played_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isiiii", $user_id, $username, $score, $moves_used, $errors, $time_taken);
$stmt->execute();


$conn->query("UPDATE users SET points = $total_score WHERE user_id = $user_id");

$res = $conn->query("SELECT * FROM statistics WHERE user_id=$user_id");
if ($res->num_rows == 0) {
    $conn->query("INSERT INTO statistics (user_id, username, total_games, total_wins, total_score, total_time, total_errors, average_score, average_time)
                  VALUES ($user_id, '$username', 1, 1, $total_score, $time_taken, $errors, $score, $time_taken)");
} else {
    $conn->query("UPDATE statistics
                  SET total_games = total_games + 1,
                      total_wins = total_wins + 1,
                      total_score = total_score + $score,
                      total_time = total_time + $time_taken,
                      total_errors = total_errors + $errors,
                      average_score = total_score / total_games,
                      average_time = total_time / total_games
                  WHERE user_id = $user_id");
}

$conn->query("INSERT INTO leaderboard (username, score, time_taken, errors, attempts, played_at)
              VALUES ('$username', $score, $time_taken, $errors, $moves_used, NOW())");

echo "Result submitted successfully!";
?>
