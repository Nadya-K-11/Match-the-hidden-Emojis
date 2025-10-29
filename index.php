<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Match The Hidden Tiles - Login</title>
<style>
/* --- General layout --- */
body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #333;
}

/* --- Login box --- */
.container {
  text-align: center;
  background: rgba(255,255,255,0.95);
  padding: 40px 50px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.25);
  animation: fadeIn 0.8s ease-in-out;
}

/* --- Title --- */
h2 {
  margin-bottom: 20px;
  color: #111;
  text-shadow: 0 0 6px rgba(0,0,0,0.1);
}

/* --- Form inputs --- */
input {
  display: block;
  margin: 10px auto;
  padding: 10px 14px;
  width: 250px;
  border: 2px solid #ccc;
  border-radius: 8px;
  transition: 0.3s;
  font-size: 14px;
}
input:focus {
  border-color: #00aaff;
  box-shadow: 0 0 10px rgba(0,150,255,0.3);
  outline: none;
}

/* --- Button --- */
button {
  margin-top: 10px;
  padding: 10px 22px;
  border: none;
  background: linear-gradient(90deg, #007bff, #00d4ff);
  color: #fff;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  font-size: 15px;
  transition: 0.3s;
}
button:hover {
  background: linear-gradient(90deg, #0066cc, #00aaff);
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* --- Link --- */
a {
  display: block;
  margin-top: 15px;
  color: #007bff;
  text-decoration: none;
  transition: 0.3s;
}
a:hover {
  color: #004a99;
  text-decoration: underline;
}

/* --- Animation --- */
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-20px);}
  to {opacity: 1; transform: translateY(0);}
}
</style>
</head>

<body>
<div class="container">
  <h2>Match The Hidden Tiles</h2>
  <form id="loginForm">
    <input type="text" name="username" placeholder="Email or Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Enter</button>
  </form>
  <a href="register.php">Registration</a>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = Object.fromEntries(new FormData(e.target).entries());
  try {
    const res = await fetch('api/login.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(formData)
    });
    const data = await res.json();
    if (data.success) {
      window.location.href = 'info.php';
    } else {
      alert(data.error || 'Login failed.');
    }
  } catch (err) {
    alert('Network or server error.');
  }
});
</script>
</body>
</html>
