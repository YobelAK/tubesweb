<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PayDIDDY - History Admin</title>
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
        }

        .status-success { color: #198754; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('transactions.admin-history') }}">History</a></li>
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
            
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select id="status-filter" class="form-select">
                            <option value="all">Semua Status</option>
                            <option value="Sukses">Sukses</option>
                            <option value="Pending">Pending</option>
                            <option value="Gagal">Gagal</option>
                        </select>
                                        </div>
                    <div class="col-md-4">
                        <input type="date" id="date-filter" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <button type="button" id="filter-button" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>

            <div id="loading" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat data...</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Game</th>
                            <th>Item/Denominasi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table-body">
                        <!-- Data akan dimuat menggunakan AJAX -->
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function loadTransactions() {
                $('#loading').removeClass('d-none');
                
                const status = $('#status-filter').val();
                const date = $('#date-filter').val();

                $.ajax({
                    url: '{{ route("transactions.admin-get") }}',
                    type: 'GET',
                    data: {
                        status: status,
                        date: date
                    },
                    success: function(response) {
                        $('#loading').addClass('d-none');
                        let tableBody = '';
                        
                        if (response.transactions.length === 0) {
                            tableBody = `<tr>
                                <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                            </tr>`;
                        } else {
                            response.transactions.forEach(function(transaction) {
                                let statusClass = 
                                    transaction.status === 'Sukses' ? 'status-success' : 
                                    (transaction.status === 'Pending' ? 'status-pending' : 
                                    (transaction.status === 'Gagal' ? 'status-failed' : ''));
                                
                                let cancelButton = transaction.status === 'Pending' 
                                    ? `<form onsubmit="return cancelTransaction(${transaction.id}, event)">
                                            <button type="submit" class="btn btn-danger btn-sm ms-2">Cancel</button>
                                        </form>`
                                    : '';

                                tableBody += `
                                    <tr>
                                        <td>${transaction.id}</td>
                                        <td>${transaction.username}</td>
                                        <td>${transaction.product ? transaction.product.nama_game : 'N/A'}</td>
                                        <td>${transaction.product ? transaction.product.item : 'N/A'}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(transaction.harga)}</td>
                                        <td>
                                            <span class="${statusClass}">${transaction.status}</span>
                                            ${cancelButton}
                                        </td>
                                        <td>${transaction.metode_pembayaran}</td>
                                        <td>${new Date(transaction.created_at).toLocaleString('id-ID')}</td>
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

            // Filter button click handler
            $('#filter-button').click(function() {
                loadTransactions();
            });

            // Cancel transaction function
            window.cancelTransaction = function(transactionId, event) {
                event.preventDefault(); // Mencegah reload halaman
                if (confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
                    $.ajax({
                        url: '{{ route("transactions.cancel") }}',
                        type: 'POST',
                        data: { id: transactionId },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                loadTransactions(); // Memuat ulang data transaksi
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                        }
                    });
                }
            };
            loadTransactions();
            setInterval(loadTransactions, 5000);
        });
    </script>
</body>
</html>
