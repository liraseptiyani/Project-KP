<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - LOGISTA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    * {
      font-family: 'Poppins', sans-serif;
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .login-page-container {
      display: flex;
      width: 100%;
      max-width: 960px;
      min-height: 80vh;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .login-image-section {
      flex: 1;
      background-image: url('{{ asset('images/background_login.jpg') }}');
      background-size: cover;
      background-position: center;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-image-section::before {
      content: '';
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.2);
    }

    .login-form-section {
      flex: 1;
      padding: 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-color: #fff;
    }

    .logo {
      width: 120px;
      margin-bottom: 16px;
    }

    .login-form-section h1 {
      font-size: 1.8em;
      color: #333;
      margin-bottom: 8px;
      font-weight: 600;
    }

    .login-form-section p {
      font-size: 0.9em;
      color: #666;
      margin-bottom: 30px;
      text-align: center;
    }

    .login-form {
      width: 100%;
      max-width: 320px;
    }

    .input-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .input-group label {
      display: block;
      font-size: 0.85em;
      color: #555;
      margin-bottom: 6px;
      font-weight: 500;
    }

    .input-group input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 0.95em;
      transition: border-color 0.3s ease;
    }

    .input-group input:focus {
      border-color: #007bff;
      outline: none;
    }

    .login-button {
      width: 100%;
      padding: 12px;
      background-color: #5cb85c;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 10px;
    }

    .login-button:hover {
      background-color: #4cae4c;
    }

    .error {
      color: #dc3545;
      font-size: 0.85em;
      margin-top: 5px;
    }

    @media (max-width: 768px) {
      .login-page-container {
        flex-direction: column;
        max-width: 90%;
        margin: 20px;
      }

      .login-image-section {
        height: 220px;
        width: 100%;
      }

      .login-form-section {
        width: 100%;
        padding: 24px;
      }

      .login-form-section h1 {
        font-size: 1.5em;
      }

      .login-form-section p {
        font-size: 0.85em;
      }
    }
  </style>
</head>
<body>
  <div class="login-page-container">
    <div class="login-image-section">
      {{-- Gambar latar --}}
    </div>
    <div class="login-form-section">
      <img src="{{ asset('images/logo tel.png') }}" alt="Logo Tel" class="logo" />
      <h1>Welcome!</h1>
      <p>LOGISTA - Logistic Inventory System for TELPP Area</p>
      <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus value="{{ old('username') }}">
          @error('username')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="input-group" style="position: relative;">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <!-- Ikon mata -->
            <span onclick="togglePasswordVisibility()" 
                  style="position: absolute; right: 10px; bottom: 9px; cursor: pointer;">
                <i id="eyeIcon" class="fa fa-eye" style="font-size: 16px; color: #666;"></i>
            </span>

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
  </div>
</body>
</html>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>