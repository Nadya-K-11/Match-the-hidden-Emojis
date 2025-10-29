<?php
session_start();
require '../db.php';
require 'helpers.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$username || !$email || !$password) {
    echo json_encode(['error'=>'Missing fields']); exit;
}

$pwHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO users (username,email,password_hash,points) VALUES (?,?,?,100)");
    $stmt->execute([$username, $email, $pwHash]);
    $uid = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO statistics (user_id,username) VALUES (?,?)");
    $stmt2->execute([$uid, $username]);

    $pdo->commit();
    echo json_encode(['success'=>true,'message'=>'Welcome! Successful Registration!']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['error'=>'Registration failed: '.$e->getMessage()]);
}
?>
