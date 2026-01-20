<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
     @vite('resources/css/admin_style.css')
</head>
<body>
    <div class="side-bar">
        <div class="logo-container">
            <img src="{{ Vite::asset('resources/images/mylogo.png') }}" id="mylogo">
            <h1>Yame T-shirt</h1>
            <p>Company</p>
        </div>
        <ul class="main-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ Vite::asset('resources/images/side-1.png') }}" class="side-icons">
                    <p>Home</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products') }}">
                    <img src="{{ Vite::asset('resources/images/side-2.png') }}" class="side-icons">
                    <p>Products</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders') }}">
                    <img src="{{ Vite::asset('resources/images/side-3.png') }}" class="side-icons">
                    <p>Orders</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users') }}">
                    <img src="{{ Vite::asset('resources/images/side-4.png') }}" class="side-icons">
                    <p>Manage Users</p>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.sales') }}">
                    <img src="{{ Vite::asset('resources/images/side-5.png') }}" class="side-icons">
                    <p>Sales Report</p>
                </a>
            </li>
        </ul>
    </div>
    <div class="top-bar">
        <div class="pfp-box">
            <span class="pfp-holder"><img src="{{ Vite::asset('resources/images/pfp.png') }}" id="mypfp"></span>
        </div>
        <div class="username-box">
            <p>Admin</p>
        </div>
        <div class="appearance-box">
            <button
                id="mode-btns"
                data-moon="{{ Vite::asset('resources/images/moon.png') }}"
                data-sun="{{ Vite::asset('resources/images/sun.png') }}"
                data-mode="dark"
                >
                <img src="{{ Vite::asset('resources/images/moon.png') }}" id="modes">
            </button>
        </div>
    
        <div class="drop-down-box">
            <button id="dd-btn"><img src="{{ Vite::asset('resources/images/arrow.png') }}" id="arrow"></button>
        </div>
        <div class="drop-down-window">
            <ul class="dd-menu">
                <li><a href=""><img src="{{ Vite::asset('resources/images/dd1.png') }}" class="dd-icons"><p>Profile</p></a></li>
                <li><a href=""><img src="{{ Vite::asset('resources/images/dd2.png') }}" class="dd-icons"><p>Security</p></a></li>
                <li><a href=""><img src="{{ Vite::asset('resources/images/dd3.png') }}" class="dd-icons"><p>Settings</p></a></li>
                <li><a href=""><img src="{{ Vite::asset('resources/images/dd4.png') }}" class="dd-icons"><p>Logout</p></a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
       @yield('content') 
    </div>
    <div class="footer">
       <p> Developed by: John Lloyd Olipani | All Rights Reserved &copy 2026</p>
    </div>
    @vite('resources/js/script.js')
</body>
</html>