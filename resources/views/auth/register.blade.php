<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Open Sans", sans-serif;
    }
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        padding: 0 10px;
    }
    body::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: 
        linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
        url('{{ asset("images/login.jpg") }}');
        background-position: center;
        background-size: cover;
    }
    .wrapper {
        width: 400px;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    }
        form {
        display: flex;
        flex-direction: column;
    }
    h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #fff;
    }
    .input-field {
        position: relative;
        border-bottom: 2px solid #ccc;
        margin: 15px 0;
    }
    .input-field label {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        color: #fff;
        font-size: 16px;
        pointer-events: none;
        transition: 0.15s ease;
    }
    .input-field input {
        width: 100%;
        height: 40px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 16px;
        color: #fff;
    }
        .input-field input:focus~label,
        .input-field input:valid~label {
        font-size: 0.8rem;
        top: 10px;
        transform: translateY(-120%);
    }
    .forget {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 25px 0 35px 0;
        color: #fff;
    }
    .wrapper a {
        color: #efefef;
        text-decoration: none;
    }
    .wrapper a:hover {
        
    }
    button {
        background: #fff;
        color: #000;
        font-weight: 600;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 16px;
        border: 2px solid transparent;
        transition: 0.3s ease;
    }
        button:hover {
        color: #fff;
        border-color: #fff;
        background: rgba(255, 255, 255, 0.15);
    }
    .back-home {
        margin-top: 10px; 
        background: transparent; 
        color: #fff; 
        border: 2px solid #fff;
    }
    .register {
        text-align: center;
        margin-top: 30px;
        color: #fff;
    }
</style>
</head>
<body>
  <div class="wrapper">
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" name="full_name" required>
        <label>Enter your full name</label>
      </div>
      <div class="input-field">
        <input type="text" name="phone_number" required>
        <label>Enter your phone number</label>
      </div>
      <div class="input-field">
        <input type="text" name="username" required>
        <label>Enter your username</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required>
        <label>Enter your password</label>
      </div>
      <button type="submit">Register</button>
      <button class="back-home" onclick="window.location.href='{{ route('home') }}'">Back to Home</button>
      <div class="register">
        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>