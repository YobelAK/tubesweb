<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayDIDDY - Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: rgba(62, 16, 151, 1);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .form-container {
            margin: 50px auto;
            max-width: 600px;
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            color: #000;
            margin-bottom: 40px;
        }
        .form-label {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .form-control {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 24px;
        }
        .btn-submit {
            background-color: #0066FF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #0052cc;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
            <h2 class="form-title">Edit Product</h2>

            <div id="alert-container"></div>

            <form id="editProductForm">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama_game" class="form-label">Nama Game</label>
                    <select class="form-control" id="nama_game" name="nama_game" required>
                        <option value="Mobile Legends" {{ $product->nama_game === 'Mobile Legends' ? 'selected' : '' }}>Mobile Legends</option>
                        <option value="Genshin Impact" {{ $product->nama_game === 'Genshin Impact' ? 'selected' : '' }}>Genshin Impact</option>
                        <option value="Honkai Star Rail" {{ $product->nama_game === 'Honkai Star Rail' ? 'selected' : '' }}>Honkai Star Rail</option>
                        <option value="Valorant" {{ $product->nama_game === 'Valorant' ? 'selected' : '' }}>Valorant</option>
                        <option value="Wuthering Waves" {{ $product->nama_game === 'Wuthering Waves' ? 'selected' : '' }}>Wuthering Waves</option>
                        <option value="Steam Wallet" {{ $product->nama_game === 'Steam Wallet' ? 'selected' : '' }}>Steam Wallet</option>
                    </select>
                </div>
                <div>
                    <label for="item" class="form-label">Item</label>
                    <input type="text" class="form-control" id="item" name="item" value="{{ $product->item }}" required>
                </div>
                <div>
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $product->harga }}" required>
                </div>
                <button type="submit" class="btn-submit">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3 w-100">Back to Product List</a>
            </form>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#editProductForm').on('submit', function(e) {
                e.preventDefault();

                var formData = {
                    nama_game: $('#nama_game').val(),
                    item: $('#item').val(),
                    harga: $('#harga').val(),
                };
                var url = "{{ route('products.update', $product->id) }}";

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#alert-container').html(
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                response.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul>';

                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });

                            errorHtml += '</ul>' +
                                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                         '</div>';

                            $('#alert-container').html(errorHtml);
                        } else {
                            $('#alert-container').html(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                'An unexpected error occurred.' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>'
                            );
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>