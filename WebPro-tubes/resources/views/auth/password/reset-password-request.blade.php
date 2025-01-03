<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: rgba(62, 16, 151, 1);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .reset-title {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn-reset {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #0066FF;
            color: white;
            font-weight: 500;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn-reset:hover {
            background-color: #0052cc;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 15px;
        }

        .reset-link {
            color: #0066FF;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
            display: block;
        }

        .reset-link a {
            color: #0066FF;
            text-decoration: none;
        }

        .reset-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2 class="reset-title">Reset Your Password</h2>

        @if (session('reset_link'))
            <div class="success-message">
                Reset link generated successfully!
            </div>
            <div class="reset-link">
                <a href="{{ session('reset_link') }}">Click here to reset your password</a>
            </div>
        @else
            <form action="{{ route('password.generate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <button type="submit" class="btn-reset">Generate Reset Link</button>
            </form>
        @endif

        <div class="reset-link" style="text-align: center; margin-top: 20px;">
            Remembered your password? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
