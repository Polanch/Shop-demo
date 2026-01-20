@extends('layouts.admin')

@section('content')
    <form action="/admin/users" method="post">
        @csrf

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role" required>
            <option value="" disabled selected>Position</option>
            <option value="Admin">Admin</option>
            <option value="Employee">Employee</option>
            <option value="Consumer">Consumer</option>
        </select>

        <input type="submit" value="Submit">
    </form>

    @if(session('success') || session('error'))
        <div class="alert-window" id="alertWindow">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <button id="closeAlert">Close</button>
        </div>
    @endif



@endsection