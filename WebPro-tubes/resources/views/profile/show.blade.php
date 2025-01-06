<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgba(62, 16, 151, 1) 0%, rgba(51, 14, 123, 1) 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        
        .profile-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .navbar {
            background: rgba(0, 0, 0, 0.2) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        footer {
            background: rgba(0, 0, 0, 0.2) !important;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-link.text-warning {
            text-decoration: none; /* Remove underline by default */
        }

        .nav-link.text-warning:hover {
            color: #ffeb3b; /* Brighter yellow on hover */
            text-decoration: underline; /* Underline on hover */
        }

        .nav-link.text-warning:hover {
            color: #ffeb3b; /* Brighter yellow on hover */
        }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand ps-5" href="#">PayDIDDY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse pe-5" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                    <li class="nav-item active">
                        <a class="nav-link text-warning" 
                        href="{{ route('profile.show') }}" 
                        style="padding-right: 20px; transition: color 0.3s;">
                            {{ Auth::user()->username }}
                        </a>
                    </li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('home.customer') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transactions.history') }}">History</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="profile-container">
            <h2 class="mb-4">Profile</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Username:</label>
                        <p>{{ $user->username }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Role:</label>
                        <p>{{ ucfirst($user->role) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Member Since:</label>
                        <p>{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Phone:</label>
                        <p id="phone-display">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Email:</label>
                        <p id="email-display">{{ $user->email ?? 'Not provided' }}</p>
                    </div>
                    
                    <h3>Update Profile</h3>
                    <form id="update-profile-form">
                        @csrf
                        <div class="mb-3">
                            <label for="phone" class="form-label">Update Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Update Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    <div id="response-message" class="mt-3"></div>

                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
    <footer class="text-white text-center py-3 mt-auto">
        <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
    </footer>
    <script>
        document.getElementById('update-profile-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const responseMessage = document.getElementById('response-message');

            fetch("{{ route('profile.update.ajax') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update halaman secara langsung
                    document.getElementById('phone-display').innerText = data.data.phone || 'Not provided';
                    document.getElementById('email-display').innerText = data.data.email || 'Not provided';

                    responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    responseMessage.innerHTML = `<div class="alert alert-danger">An error occurred</div>`;
                }
            })
            .catch(error => {
                responseMessage.innerHTML = `<div class="alert alert-danger">Failed to update profile</div>`;
            });
        });
    </script>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>