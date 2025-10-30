<?php
function updateStatistics($pdo, $userId, $username, $score, $time, $errors, $won = false) {
    $stmt = $pdo->prepare("SELECT * FROM statistics WHERE user_id = ?");
    $stmt->execute([$userId]);
    $stat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stat) {
        $totalGames = $stat['total_games'] + 1;
        $totalWins = $stat['total_wins'] + ($won ? 1 : 0);
        $totalScore = $stat['total_score'] + $score;
        $totalTime = $stat['total_time_seconds'] + $time;
        $totalErrors = $stat['total_errors'] + $errors;
        $avgScore = $totalScore / $totalGames;
        $avgTime = $totalTime / $totalGames;

        $stmt = $pdo->prepare("UPDATE statistics 
            SET total_games=?, total_wins=?, total_score=?, total_time_seconds=?, total_errors=?, average_score=?, average_time=? 
            WHERE user_id=?");
        $stmt->execute([$totalGames, $totalWins, $totalScore, $totalTime, $totalErrors, $avgScore, $avgTime, $userId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO statistics (user_id, username, total_games, total_wins, total_score, total_time_seconds, total_errors, average_score, average_time)
            VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$userId, $username, 1, ($won?1:0), $score, $time, $errors, $score, $time]);
    }
}
?>
