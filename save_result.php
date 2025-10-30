<?php
session_start();
require '../db.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error'=>'Not logged in']); exit;
}
$data = json_decode(file_get_contents("php://input"), true);
$score = (int)$data['score'];
$moves = (int)$data['moves'];
$errors = (int)$data['errors'];
$time_taken = (int)$data['time_taken'];

$uid = $_SESSION['user_id'];
$username = $_SESSION['username'];
$won = ($score > 0);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO results (user_id,username,score,moves_used,errors,time_taken_seconds) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$uid,$username,$score,$moves,$errors,$time_taken]);

    if ($won) {
        $eff = $score / max(1,$time_taken);
        $pdo->prepare("INSERT INTO winners (user_id,username,score,time_taken_seconds,efficiency) VALUES (?,?,?,?,?)")
            ->execute([$uid,$username,$score,$time_taken,$eff]);

        $pdo->prepare("INSERT INTO leaderboard (user_id,username,score,time_taken_seconds,errors,played_at)
            VALUES (?,?,?,?,?,NOW())")->execute([$uid,$username,$score,$time_taken,$errors]);
    }

    updateStatistics($pdo,$uid,$username,$score,$time_taken,$errors,$won);

    $pdo->commit();
    echo json_encode(['success'=>true,'won'=>$won]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['error'=>$e->getMessage()]);
}
?>
