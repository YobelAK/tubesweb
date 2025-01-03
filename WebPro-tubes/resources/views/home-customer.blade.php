<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-section {
            background: 
                linear-gradient(to bottom, rgba(62, 16, 151, 0) 50%, rgba(62, 16, 151, 1)),
                url('{{ asset('images/banner-3.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 60vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .gamelist-section {
            background: linear-gradient(to bottom, rgba(62, 16, 151, 1), #1E88E5);
            padding: 50px 0;
        }

        .game-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .game-card {
            transition: transform 0.3s;
        }
        .game-card:hover {
            transform: scale(1.05);
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand ps-5" href="#">PayDIDDY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse pe-5" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link text-warning" 
                        href="{{ route('profile.show') }}" 
                        style="padding-right: 20px; transition: color 0.3s;">
                            {{ Auth::user()->username }}
                        </a>
                    </li>
                    @endif
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home.customer') }}">Home</a></li>
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

    <!-- Hero Section -->
    <section class="hero-section text-center text-light">
        <div>
            <h1>Top-Up Game Terbaik untuk Semua Game Favoritmu!</h1>
            <p>Top-Up cepat, aman, dan mudah. Nikmati pengalaman gaming tanpa hambatan.</p>
            <a href="#game-list" class="btn btn-primary btn-lg">Top-Up Sekarang</a>
        </div>
    </section>

    <!-- Game List Section -->
    <section id="game-list" class="gamelist-section py-5">
    <div class="container text-center">
        <h2 class="mb-4 text-white">List Top-Up</h2>
        <div class="row justify-content-center">
            @php
                $uniqueGames = $games->unique('nama_game');
            @endphp
            
            @foreach($uniqueGames as $game)
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="card game-card">
                    <img src="{{ asset('images/' . $game->image_url) }}" alt="{{ $game->nama_game }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $game->nama_game }}</h5>
                        <a href="{{ route('topup', ['game' => $game->nama_game]) }}" class="btn btn-primary">Top-Up</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
