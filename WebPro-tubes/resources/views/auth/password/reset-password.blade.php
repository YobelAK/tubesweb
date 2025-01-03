<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(90deg, rgba(62, 16, 151, 1) 0%, rgba(33, 150, 243, 1) 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-title {
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

        .btn-login {
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

        .btn-login:hover {
            background-color: #0052cc;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 15px;
        }

        .login-link {
            color: #0066FF;
        }

        .login-link a {
            color: #0066FF;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Set New Password</h2>

        <div class="error-message" id="error-message" style="display:none;"></div>
        <div class="success-message" id="success-message" style="display:none;"></div>

        <form id="password-update-form">
            @csrf
            <input type="hidden" name="username" value="{{ $username ?? old('username') }}">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Password</button>
        </form>

        <div class="login-link" style="text-align: center; margin-top: 20px;">
            Remembered your password? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#password-update-form').submit(function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('password.update') }}",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $('#error-message').hide();
                        $('#success-message').show().text(response.message);
                        setTimeout(function () {
                            window.location.href = "{{ route('login') }}";
                        }, 2000);
                    },
                    error: function (xhr) {
                        $('#success-message').hide();
                        const errors = xhr.responseJSON.errors || {};
                        let errorMessage = '';
                        if (errors.password) {
                            errorMessage += errors.password[0] + '<br>';
                        }
                        if (errors.password_same) {
                            errorMessage += errors.password_same + '<br>';
                        }
                        $('#error-message').show().html(errorMessage);
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
