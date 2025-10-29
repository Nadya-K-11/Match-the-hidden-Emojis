/*
 * Match The Hidden Emojis (Tiles) - stats.php
 * Description: Displays user and global game statistics for the Match The Hidden Tiles game.
 * Note: This file is part of a demo/game project and is NOT used for malicious purposes.
 * Database queries are local (require 'db.php') and safe for internal demo use.
 */

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require 'db.php';
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Statistics & Leaderboard</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #a2c2e0, #f9d29d);
    margin: 0;
    padding: 40px 20px;
    color: #333;
    text-align: center;
}

h2 {
    color: #222;
    font-size: 28px;
    margin-bottom: 10px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

h3 {
    color: #444;
    margin-top: 40px;
    margin-bottom: 10px;
    border-bottom: 2px solid rgba(0,0,0,0.1);
    display: inline-block;
    padding-bottom: 5px;
}

table {
    margin: 20px auto;
    border-collapse: collapse;
    width: 95%;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 12px rgba(0,0,0,0.2);
    transition: all 0.3s ease-in-out;
}

table:hover {
    transform: scale(1.01);
}

th, td {
    padding: 10px 12px;
    border: 1px solid #ddd;
}

th {
    background: linear-gradient(90deg, #4b6cb7, #182848);
    color: white;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
}

tr:nth-child(even) {
    background-color: #f8f9fa;
}

tr:hover {
    background-color: #e2f0ff;
    transition: background-color 0.2s ease-in-out;
}

td {
    font-size: 14px;
    color: #333;
}

.back {
    display: inline-block;
    margin-top: 30px;
    padding: 10px 20px;
    background: linear-gradient(90deg, #007bff, #00c6ff);
    color: #fff;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.back:hover {
    background: linear-gradient(90deg, #0056b3, #0099cc);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.25);
}

footer {
    margin-top: 50px;
    font-size: 13px;
    color: rgba(0,0,0,0.6);
}
</style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>

<h3>Ranking (Top 10 by efficiency)</h3>
<table>
<tr>
    <th>#</th><th>User</th><th>Points</th><th>Time (sec)</th><th>Efficiency</th><th>Date</th>
</tr>
<?php
$stmt = $pdo->query("SELECT username,score,time_taken_seconds,efficiency,victory_date 
                     FROM winners ORDER BY efficiency DESC LIMIT 20");
$rank = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>{$rank}</td>
        <td>".htmlspecialchars($row['username'])."</td>
        <td>{$row['score']}</td>
        <td>{$row['time_taken_seconds']}</td>
        <td>{$row['efficiency']}</td>
        <td>{$row['victory_date']}</td>
    </tr>";
    $rank++;
}
?>
</table>

<h3>Game statistics (all users)</h3>
<table>
<tr>
    <th>#</th><th>UserName</th><th>Games</th><th>Wins</th><th>Total Score</th>
    <th>Total Time (sec)</th><th>Average Score</th><th>Average Time (sec)</th>
</tr>
<?php
$stmt2 = $pdo->query("SELECT username,total_games,total_wins,total_score,total_time_seconds,total_errors,average_score,average_time
                      FROM statistics ORDER BY total_score DESC");
$rank = 1;
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>{$rank}</td>
        <td>".htmlspecialchars($row['username'])."</td>
        <td>{$row['total_games']}</td>
        <td>{$row['total_wins']}</td>
        <td>{$row['total_score']}</td>
        <td>{$row['total_time_seconds']}</td>
        <td>{$row['total_errors']}</td>
        <td>{$row['average_score']}</td>
        <td>{$row['average_time']}</td>
    </tr>";
    $rank++;
}
?>
</table>

<a class="back" href="game.php">⬅ Back To The Game</a>

</body>
</html>
