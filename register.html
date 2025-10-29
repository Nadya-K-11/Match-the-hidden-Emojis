<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Registration - Match The Hidden Tiles</title>
<style>
body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: linear-gradient(135deg, #89f7fe, #66a6ff);
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #333;
}

.container {
  text-align: center;
  background: rgba(255,255,255,0.96);
  padding: 40px 50px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.25);
  animation: fadeIn 0.8s ease-in-out;
}

h2 {
  margin-bottom: 20px;
  color: #111;
  text-shadow: 0 0 5px rgba(0,0,0,0.1);
}

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
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0,123,255,0.3);
  outline: none;
}

button {
  margin-top: 10px;
  padding: 10px 22px;
  border: none;
  background: linear-gradient(90deg, #00c6ff, #0072ff);
  color: #fff;
  font-weight: bold;
  border-radius: 25px;
  cursor: pointer;
  font-size: 15px;
  transition: 0.3s;
}

button:hover {
  background: linear-gradient(90deg, #007bff, #0056b3);
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

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

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-20px);}
  to {opacity: 1; transform: translateY(0);}
}
</style>
</head>
<body>
<div class="container">
  <h2>Registration</h2>
  <form id="regForm">
    <input name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <a href="index.php">Back to Login</a>
</div>

<script>
document.getElementById('regForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = Object.fromEntries(new FormData(e.target).entries());
  try {
    const res = await fetch('api/register.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(formData)
    });
    const data = await res.json();
    if (data.success) {
      alert(data.message || 'Registration successful!');
      window.location.href = 'index.php';
    } else {
      alert(data.error || 'Registration failed.');
    }
  } catch (err) {
    alert('Network or server error.');
  }
});
</script>
</body>
</html>
