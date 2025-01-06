<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Admin Profile</title>
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
        .table-responsive {
            background: white;
            border-radius: 8px;
            padding: 1rem;
        }
        .action-buttons .btn {
            margin: 0 5px;
        }
        .nav-link.text-warning {
            text-decoration: none; 
        }

        .nav-link.text-warning:hover {
            color: #ffeb3b; 
            text-decoration: underline; 
        }

        .nav-link.text-warning:hover {
            color: #ffeb3b; 
        }
        .current-time-container {
            background-color: rgba(0, 123, 255, 0.8); /* Warna biru transparan */
            border: 2px solid #007bff; /* Border biru */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .current-time-container:hover {
            transform: scale(1.05); /* Efek zoom saat hover */
        }

        .text-white {
            color: white; /* Warna teks putih */
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
                        href="{{ route('admin.users.show') }}" 
                        style="padding-right: 20px; transition: color 0.3s;">
                            {{ Auth::user()->username }}
                        </a>
                    </li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('home.admin') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">List-Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transactions.admin-history') }}">History</a></li>
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
    <div class="current-time-container border rounded p-4 mb-4 text-center">
                <h4 class="text-white">Current Time (WIB)</h4>
                <div id="current-time" class="text-white" style="font-size: 2rem; font-weight: bold;"></div>
            </div>
    <div class="container my-5">
        <div class="profile-container">
            <h2 class="mb-4">Profile</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Username:</label>
                        <p>{{ Auth::user()->username }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Role:</label>
                        <p>{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Member Since:</label>
                        <p>{{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Phone:</label>
                        <p>{{ Auth::user()->phone ?? 'Not provided' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Email:</label>
                        <p>{{ Auth::user()->email ?? 'Not provided' }}</p>
                    </div>
                    <h3>Update Profile</h3>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="phone" class="form-label">Update Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Update Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    <div id="response-message" class="mt-3">
                        
                    </div>
                    
                </div>
            </div>
            <div class="card">
                
            
            </div>
        </div>
        
    </div>


    <div class="container my-5">
        <div class="profile-container">
            <h2 class="mb-4">Admin Dashboard - User Management</h2>
            
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Member Since</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if($user->role === 'customer')
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ $user->phone ?? 'Not provided' }}</td>
                                    <td>{{ $user->email ?? 'Not provided' }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="action-buttons">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete user: {{ $user->username }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-3 mt-auto">
        <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
    </footer>
    <script>
        function fetchCurrentTime() {
            fetch('/api/current-time')
                .then(response => response.json())
                .then(data => {
                    const formattedTime = data.time; 
                    
                    
                    document.getElementById('current-time').innerText = `${formattedTime}`;
                })
                .catch(error => console.error('Error fetching time:', error));
        }

        
        fetchCurrentTime(); 
    </script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>