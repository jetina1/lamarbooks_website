<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <div class="container">
        <!-- Logo (optional) -->
        <div class="logo-container" style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('image/lallogo1.png') }}" alt="Logo" style="width: 100px; height: auto;">
        </div>

        <h2>Reset Password</h2>

        <!-- Display errors -->
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="form-card">
            <form action="{{ route('password.reset') }}" method="POST">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div>
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit">Reset Password</button>
            </form>
        </div>

        <p class="link">
            <a href="{{ route('signin') }}">Back to Signin</a>
        </p>
    </div>
</body>

<style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #222222;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        background-color: #1e1e1e;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h2 {
        text-align: center;
        color: gold;
    }

    .form-card {
        background-color: #333;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        font-size: 16px;
        margin-bottom: 5px;
        color: #f1f1f1;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 2px solid #444;
        border-radius: 5px;
        background-color: #222;
        color: #fff;
        font-size: 16px;
    }

    input:focus {
        border-color: gold;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: gold;
        border: none;
        border-radius: 5px;
        color: #222;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #f1c40f;
    }

    .error-list {
        list-style: none;
        padding: 0;
        margin-bottom: 15px;
    }

    .error-list li {
        background-color: #ff4d4d;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .link {
        text-align: center;
        color: gold;
        display: block;
        margin-top: 20px;
        text-decoration: none;
    }

    .link:hover {
        text-decoration: underline;
    }
</style>

</html>