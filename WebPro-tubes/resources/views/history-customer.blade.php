<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PayDIDDY - History Customer</title>
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

        .history-container {
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            color: #000;
        }

        .history-title {
            color: #0f0f0f;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .status-success { color: #198754; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }

        .btn-confirm {
            background-color: #198754;
            color: white;
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
                        href="{{ route('profile.show') }}" 
                        style="padding-right: 20px; transition: color 0.3s;">
                            {{ Auth::user()->username }}
                        </a>
                    </li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('home.customer') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('transactions.history') }}">History</a></li>
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
        <div class="history-container">
            <h1 class="history-title">Riwayat Transaksi Top-Up</h1>
            <div id="loading" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat data...</span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Game</th>
                            <th>Item</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table-body">
                        <!--Data diambil menggunakan Ajax -->
                    </tbody>
                </table>
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
            // Mengatur CSRF token untuk request AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fungsi untuk memuat data transaksi
            function loadTransactions() {
                $('#loading').removeClass('d-none');
                
                $.ajax({
                    url: '{{ route("transactions.get") }}',
                    type: 'GET',
                    success: function(response) {
                        $('#loading').addClass('d-none');
                        let tableBody = '';
                        
                        if (response.transactions.length === 0) {
                            tableBody = `<tr>
                                <td colspan="7" class="text-center">Tidak ada riwayat transaksi</td>
                            </tr>`;
                        } else {
                            response.transactions.forEach(function(transaction) {
                                let statusClass = 
                                    transaction.status === 'Sukses' ? 'text-success' : 
                                    (transaction.status === 'Pending' ? 'text-warning' : 'text-danger');
                                
                                let actionButton = transaction.status === 'Pending' 
                                    ? `<button onclick="confirmTransaction(${transaction.id})" class="btn btn-sm btn-confirm">Konfirmasi</button>`
                                    : `<button class="btn btn-sm btn-secondary" disabled>Tidak Ada Aksi</button>`;

                                tableBody += `
                                    <tr>
                                        <td>${transaction.id}</td>
                                        <td>${transaction.product.nama_game}</td>
                                        <td>${transaction.product.item}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(transaction.harga)}</td>
                                        <td class="${statusClass}">${transaction.status}</td>
                                        <td>${new Date(transaction.created_at).toLocaleString('id-ID')}</td>
                                        <td>${actionButton}</td>
                                    </tr>
                                `;
                            });
                        }
                        
                        $('#transaction-table-body').html(tableBody);
                    },
                    error: function(xhr) {
                        $('#loading').addClass('d-none');
                        alert('Gagal memuat data transaksi');
                    }
                });
            }

            // Fungsi untuk konfirmasi transaksi
            window.confirmTransaction = function(transactionId) {
                if (confirm('Apakah Anda yakin ingin mengkonfirmasi transaksi ini?')) {
                    $('#loading').removeClass('d-none');
                    
                    $.ajax({
                        url: '{{ route("transactions.confirm") }}',
                        type: 'POST',
                        data: { id: transactionId },
                        success: function(response) {
                            $('#loading').addClass('d-none');
                            if (response.success) {
                                loadTransactions(); // Muat ulang tabel
                            }
                        },
                        error: function(xhr) {
                            $('#loading').addClass('d-none');
                            alert('Gagal mengkonfirmasi transaksi');
                        }
                    });
                }
            }
            loadTransactions();
            setInterval(loadTransactions, 5000);
        });
    </script>
</body>
</html>
