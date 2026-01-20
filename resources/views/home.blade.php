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
    @vite('resources/js/script.js')
</body>
</html>