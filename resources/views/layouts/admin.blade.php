<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/mylogo.png">
    <title>Admin</title>
    <link rel="stylesheet" href="/build/assets/admin_style-EfzTKaR2.css">
</head>
<body>
    <div class="side-bar sidebar">
        <div class="logo-container">
            <img src="/images/mylogo.png" id="mylogo">
            <h1>Yame T-shirt</h1>
            <p>Company</p>
        </div>
        <ul class="main-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <img src="/images/side-1.png" class="side-icons">
                    <p>Home</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products') }}">
                    <img src="/images/side-2.png" class="side-icons">
                    <p>Products</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders') }}">
                    <img src="/images/side-3.png" class="side-icons">
                    <p>Orders</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users') }}">
                    <img src="/images/side-4.png" class="side-icons">
                    <p>Manage Users</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.sales') }}">
                    <img src="/images/side-5.png" class="side-icons">
                    <p>Sales Report</p>
                </a>
            </li>
        </ul>
    </div>
    <div class="top-bar">
        <div class="hamburger-menu" id="hamburger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="pfp-box">
            <span class="pfp-holder"><img src="/images/pfp.png" id="mypfp"></span>
        </div>
        <div class="username-box">
            <p>Admin</p>
        </div>
        <div class="appearance-box">
            <button
                id="mode-btns"
                data-moon="/images/moon.png"
                data-sun="/images/sun.png"
                data-mode="dark"
                >
                <img src="/images/moon.png" id="modes">
            </button>
        </div>
    
        <div class="drop-down-box">
            <button id="dd-btn"><img src="/images/arrow.png" id="arrow"></button>
        </div>
        <div class="drop-down-window">
            <ul class="dd-menu">
                <li><a href=""><img src="/images/dd1.png" class="dd-icons"><p>Profile</p></a></li>
                <li><a href=""><img src="/images/dd2.png" class="dd-icons"><p>Security</p></a></li>
                <li><a href=""><img src="/images/dd3.png" class="dd-icons"><p>Settings</p></a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%; height: 100%; margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; width: 100%; height: 100%; display: grid; grid-template-columns: 30px auto; grid-template-rows: 1fr; color: black; padding: 0; text-align: left;">
                            <img src="/images/dd4.png" class="dd-icons">
                            <p style="width: 100%; height: 100%; display: flex; align-items: center; padding-left: 15px; margin: 0;">Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content">
       @yield('content') 
    </div>
    <div class="footer">
       <p> Developed by: John Lloyd Olipani | All Rights Reserved &copy 2026</p>
    </div>
    <script src="/build/assets/script-C_0nQZ-2.js"></script>
</body>
</html>