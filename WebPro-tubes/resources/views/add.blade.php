<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PayDIDDY - Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: rgba(62, 16, 151, 1);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .form-container {
            margin: 50px auto;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container .form-label {
            color: #333; 
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-title {
            text-align: center;
            font-weight: 600;
            color: #0f0f0f;
            margin-bottom: 20px;
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

    <div class="container">
   <div class="form-container">
        <h2 class="form-title">Form Input Item</h2>
        <form id="addProductForm" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_game" class="form-label">Nama Game</label>
                <select class="form-control" id="nama_game" name="nama_game" required>
                        <option value="" disabled selected>Pilih nama game</option>
                        <option value="Mobile Legends">Mobile Legends</option>
                        <option value="Genshin Impact">Genshin Impact</option>
                        <option value="Honkai Star Rail">Honkai Star Rail</option>
                        <option value="Valorant">Valorant</option>
                        <option value="Wuthering Waves">Wuthering Waves</option>
                        <option value="Steam Wallet">Steam Wallet</option>
                        </select>
                <div class="invalid-feedback" id="nama_game_error"></div>
                </div>
                <div class="mb-3">
                    <label for="item" class="form-label">Item</label>
                    <input type="text" class="form-control" id="item" name="item" required>
                    <div class="invalid-feedback" id="item_error"></div>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                    <div class="invalid-feedback" id="harga_error"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>

            <div class="alert alert-success mt-3" id="successAlert" style="display: none;">
                Product added successfully!
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            $(document).ready(function() {
                // Set up CSRF token for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#addProductForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Reset previous error states
                    $('.invalid-feedback').hide();
                    $('.form-control').removeClass('is-invalid');
                    
                    // Get form data
                    let formData = $(this).serialize();
                    
                    $.ajax({
                        // Ubah URL ke route products.store
                        url: "{{ route('products.store') }}", // Ini akan mengarah ke /products bukan /products/create
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if(response.success) {
                                // Show success message
                                $('#successAlert').fadeIn().delay(3000).fadeOut();
                                
                                // Clear form
                                $('#addProductForm')[0].reset();
                            }
                        },
                        error: function(xhr) {
                            if(xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                // Display validation errors
                                Object.keys(errors).forEach(field => {
                                    $(`#${field}`).addClass('is-invalid');
                                    $(`#${field}_error`).text(errors[field][0]).show();
                                });
                            }
                        }
                    });
                });
            });
    </script>
</body>
</html>
