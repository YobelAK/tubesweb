<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PayDIDDY - Top Up</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
        background: linear-gradient(to bottom, #4A00E0, #8E2DE2);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .form-container {
        margin: 50px auto;
        max-width: 500px;
        background-color: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .form-title {
        text-align: center;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }
    .form-label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 16px;
    }
    .btn-action {
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        margin-top: 16px;
    }
    .btn-primary {
        background-color: #4A00E0;
        color: #fff;
    }
    footer {
        background-color:rgb(27, 27, 27);
        padding: 10px 0;
        text-align: center;
        color: #fff;
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

<div class="container">
<div class="container">
    <div class="form-container">
        <h2 class="form-title">Form Top Up</h2>
        <form action="{{ route('topup.process') }}" method="POST">
            @csrf
            <input type="hidden" name="nama_game" value="{{ $request->game }}">
            
            <label for="item" class="form-label">Pilih Item</label>
            <select id="item" name="item" class="form-select" required>
                <option value="" disabled selected>Pilih item</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-harga="{{ $product->harga }}">
                        {{ $product->item }}
                    </option>
                @endforeach
            </select>

            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                <option value="" disabled selected>Pilih metode pembayaran</option>
                <option value="e-wallet">E-Wallet</option>
                <option value="transfer">Transfer Bank</option>
            </select>

            <div id="harga-wrapper" style="display: none;">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" id="harga" name="harga" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-action btn-primary">Confirm</button>
        </form>

        <!-- Button Back to Home -->
        <a href="{{ route('home.customer') }}" class="btn btn-action btn-secondary mt-3">Back to Home</a>
    </div>
</div>

</div>

<footer class="mt-auto">
    <p>&copy; {{ date('Y') }} PayDIDDY - All Rights Reserved</p>
</footer>

<script>
        const itemSelect = document.getElementById('item');
        const metodePembayaranSelect = document.getElementById('metode_pembayaran');
        const hargaInput = document.getElementById('harga');
        const hargaWrapper = document.getElementById('harga-wrapper');

        // Fungsi untuk memperbarui harga berdasarkan metode pembayaran
        metodePembayaranSelect.addEventListener('change', () => {
            const selectedMethod = metodePembayaranSelect.value;

            // Ambil harga dari item yang dipilih
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const harga = selectedOption ? selectedOption.getAttribute('data-harga') : null;

            // Tampilkan harga jika ada item yang dipilih
            if (harga && selectedMethod) {
                hargaWrapper.style.display = 'block';

                // Tambahkan logika pajak hanya untuk transfer bank
                if (selectedMethod === 'transfer') {
                    const tax = parseFloat(harga) * 0.03; // 3% tax
                    const totalWithTax = parseFloat(harga) + tax;
                    hargaInput.value = totalWithTax.toFixed(2);
                } else {
                    hargaInput.value = parseFloat(harga).toFixed(2);
                }
            } else {
                hargaWrapper.style.display = 'none';
                hargaInput.value = '';
            }
        });

    // Memastikan harga diperbarui setiap kali item berubah
    itemSelect.addEventListener('change', () => {
        metodePembayaranSelect.dispatchEvent(new Event('change'));
    });
</script>
</body>
</html>
