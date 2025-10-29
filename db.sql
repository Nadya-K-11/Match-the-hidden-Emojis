CREATE DATABASE IF NOT EXISTS mach_hidden_tiles CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mach_hidden_tiles;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  points INT NOT NULL DEFAULT 0,
  moves_available INT NOT NULL DEFAULT 150,
  registered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login DATE NULL,
  login_bonus_count_today TINYINT NOT NULL DEFAULT 0,
  INDEX(idx_username) (username),
  INDEX(idx_email) (email)
);

CREATE TABLE daily_bonus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  bonus_date DATE NOT NULL,
  bonus_count TINYINT NOT NULL DEFAULT 0,
  UNIQUE KEY (user_id, bonus_date),
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE results (
  result_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  username VARCHAR(50) NOT NULL,
  score INT NOT NULL,
  moves_used INT NOT NULL,
  errors INT NOT NULL DEFAULT 0,
  time_taken_seconds INT NOT NULL,
  played_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE statistics (
  stat_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  username VARCHAR(50) NOT NULL,
  total_games INT NOT NULL DEFAULT 0,
  total_wins INT NOT NULL DEFAULT 0,
  total_score BIGINT NOT NULL DEFAULT 0,
  total_time_seconds BIGINT NOT NULL DEFAULT 0,
  total_errors INT NOT NULL DEFAULT 0,
  average_score DECIMAL(8,2) NOT NULL DEFAULT 0,
  average_time DECIMAL(10,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE winners (
  winner_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  username VARCHAR(50) NOT NULL,
  score INT NOT NULL,
  time_taken_seconds INT NOT NULL,
  victory_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  efficiency DECIMAL(8,4) NOT NULL, -- e.g. score/time
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE leaderboard (
  lb_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  username VARCHAR(50) NOT NULL,
  score INT NOT NULL,
  time_taken_seconds INT NOT NULL,
  errors INT DEFAULT 0,
  played_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  INDEX(idx_eff) (score, time_taken_seconds)
);
