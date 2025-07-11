<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LOGISTA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5; /* Light grey background for the entire page */
            overflow: hidden; /* Prevent scroll if content overflows */
        }

        /* Container for the entire login page */
        .login-page-container {
            display: flex;
            width: 100%;
            max-width: 1200px; /* Max width of the login card */
            height: 700px; /* Fixed height for the card */
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Ensures rounded corners apply to children */
        }

        /* Left side: Image Background */
        .login-image-section {
            flex: 1; /* Takes half width */
            background-image: url('{{ asset('images/background_login.jpg') }}'); /* Ganti dengan path gambar Anda */
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.2); /* Dark overlay for better text readability (optional) */
        }

        /* Right side: Login Form */
        .login-form-section {
            flex: 1; /* Takes half width */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
            background-color: #fff;
        }

        /* Logo */
        .login-form-section .logo {
            width: 150px; /* Adjust logo size */
            margin-bottom: 20px;
        }

        /* Welcome Text */
        .login-form-section h1 {
            font-size: 2.2em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .login-form-section p {
            font-size: 1em;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.5;
        }

        /* Form Elements */
        .login-form {
            width: 100%;
            max-width: 350px; /* Max width for the form elements */
        }

        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-size: 0.9em;
            color: #555;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .input-group input {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            box-sizing: border-box; /* Include padding in width */
            transition: border-color 0.3s ease;
        }
        .input-group input:focus {
            border-color: #007bff; /* Highlight on focus */
            outline: none;
        }

        .password-input-group {
            position: relative;
        }
        .password-input-group input {
            padding-right: 40px; /* Space for eye icon */
        }
        .password-input-group .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(20%); /* Adjust based on input padding/height */
            cursor: pointer;
            color: #999;
            font-size: 1.1em;
        }

        /* Button */
        .login-button {
            width: 100%;
            padding: 15px;
            background-color: #5cb85c; /* Green color for register button in image */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .login-button:hover {
            background-color: #4cae4c; /* Darker green on hover */
        }

        /* Error messages */
        .error {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-page-container {
                flex-direction: column;
                height: auto;
                max-width: 500px;
            }
            .login-image-section {
                height: 250px; /* Make image section shorter on small screens */
                width: 100%;
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                border-bottom-left-radius: 0;
            }
            .login-form-section {
                width: 100%;
                padding: 30px;
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
                border-top-right-radius: 0;
            }
            .login-form-section h1 {
                font-size: 1.8em;
            }
            .login-form-section p {
                font-size: 0.9em;
                margin-bottom: 30px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
</style>

</head>
<body>
    <div class="login-page-container">
        <div class="login-image-section">
            {{-- This section is for the background image --}}
        </div>
        <div class="login-form-section">
            <img src="{{ asset('images/logo tel.png') }}" alt="logo tel.png" class="logo"> <h1>Welcome!</h1>
            <p>LOGISTA - Logistic Inventory System for TELPP Area</p>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <div class="input-group">
                    <label for="username">User name</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus value="{{ old('username') }}">
                    @error('username')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group password-input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TOMBOL INI SAYA GANTI MENJADI TOMBOL LOGIN --}}
                <button type="submit" class="login-button">Login</button>

                {{-- Jika Anda benar-benar ingin tombol "Register" tampil tapi tidak berfungsi (tidak disarankan): --}}
                {{-- <button type="button" class="login-button" style="background-color: #5cb85c; cursor: not-allowed;" disabled>Register</button> --}}

            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>
</body>
</html>