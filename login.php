<?php
session_start();
require '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$username, $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    echo json_encode(['error'=>'Invalid username or password']); exit;
}

$uid = $user['user_id'];
$today = date('Y-m-d');

$pdo->beginTransaction();
try {
    $stmtB = $pdo->prepare("SELECT bonus_count FROM daily_bonus WHERE user_id=? AND bonus_date=?");
    $stmtB->execute([$uid, $today]);
    $row = $stmtB->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if ($row['bonus_count'] < 2) {
            $pdo->prepare("UPDATE daily_bonus SET bonus_count=bonus_count+1 WHERE user_id=? AND bonus_date=?")
                ->execute([$uid, $today]);
            $pdo->prepare("UPDATE users SET points=points+10 WHERE user_id=?")->execute([$uid]);
        }
    } else {
        $pdo->prepare("INSERT INTO daily_bonus (user_id,bonus_date,bonus_count) VALUES (?,?,1)")
            ->execute([$uid,$today]);
        $pdo->prepare("UPDATE users SET points=points+10 WHERE user_id=?")->execute([$uid]);
    }

    $pdo->prepare("UPDATE users SET last_login=? WHERE user_id=?")->execute([$today,$uid]);
    $pdo->commit();

    $_SESSION['user_id'] = $uid;
    $_SESSION['username'] = $user['username'];
    echo json_encode(['success'=>true]);
} catch(Exception $e) {
    $pdo->rollBack();
    echo json_encode(['error'=>$e->getMessage()]);
}
?>
