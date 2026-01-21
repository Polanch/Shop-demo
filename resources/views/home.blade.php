<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS System</title>
    @vite('resources/css/style.css')
</head>
<body>
    <div class="login-window">
        <div class="logo-section">
            <img src="/mylogo.png" alt="Yame T-shirt Logo" class="login-logo">
            <h1>Yame T-shirt</h1>
            <p>COMPANY</p>
        </div>
        <form action="{{ route('login') }}" method="post">
            @csrf

            <label>Username or Email</label>
            <input type="text" name="login" placeholder="Username or Email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Login">
        </form>

        {{-- Alert messages --}}
       @if(session('error'))
            <div class="alert-window" id="alertWindow">
                {{ session('error') }}
                <button id="closeAlert">Close</button>
            </div>
        @endif

    </div>

    <!-- Manual Button -->
    <button class="manual-btn" id="manualBtn">Manual</button>

    <!-- Manual Popup -->
    <div class="manual-overlay" id="manualOverlay">
        <div class="manual-popup">
            <button class="manual-close" id="manualClose">&times;</button>
            <h2>Login Manual</h2>
            <div class="manual-content">
                <div class="account-info">
                    <h3>Admin Account</h3>
                    <p><strong>Username:</strong> Admin</p>
                    <p><strong>Password:</strong> 12345</p>
                </div>
                <div class="account-info">
                    <h3>Consumer Account</h3>
                    <p><strong>Username:</strong> John</p>
                    <p><strong>Password:</strong> 12345</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const manualBtn = document.getElementById('manualBtn');
        const manualOverlay = document.getElementById('manualOverlay');
        const manualClose = document.getElementById('manualClose');

        manualBtn.addEventListener('click', () => {
            manualOverlay.classList.add('active');
        });

        manualClose.addEventListener('click', () => {
            manualOverlay.classList.remove('active');
        });

        manualOverlay.addEventListener('click', (e) => {
            if (e.target === manualOverlay) {
                manualOverlay.classList.remove('active');
            }
        });
    </script>

    @vite('resources/js/script.js')
</body>
</html>