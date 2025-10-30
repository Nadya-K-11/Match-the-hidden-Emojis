<?php
session_start();
require '../db.php';

if(!isset($_SESSION['user_id'])){ echo json_encode(['error'=>'Not logged in']); exit; }
$uid = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

if($action === 'hint' || $action === 'buy_moves'){
    $cost = 20;
    $addMoves = ($action==='buy_moves') ? 10 : 0;
    $stmt = $pdo->prepare("SELECT points,moves_available FROM users WHERE user_id=?");
    $stmt->execute([$uid]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    if($u['points'] < $cost){
        echo json_encode(['error'=>'Not enough points']); exit;
    }
    $newPoints = $u['points'] - $cost;
    $newMoves = $u['moves_available'] + $addMoves;
    $pdo->prepare("UPDATE users SET points=?, moves_available=? WHERE user_id=?")
        ->execute([$newPoints,$newMoves,$uid]);
    echo json_encode(['success'=>true,'points'=>$newPoints,'moves'=>$newMoves]);
} else {
    echo json_encode(['error'=>'Invalid action']);
}
?>
