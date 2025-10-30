<?php
require '../db.php';
$stmt = $pdo->query("SELECT username,score,time_taken_seconds,efficiency,victory_date 
                     FROM winners ORDER BY efficiency DESC LIMIT 10");
echo json_encode($stmt->fetchAll());
?>
