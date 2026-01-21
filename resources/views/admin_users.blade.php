@extends('layouts.admin')

@section('content')
    @if(session('success') || session('error'))
        <div class="alert-window {{ session('success') ? 'success' : 'error' }}" id="alertWindow">
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
            <div class="alert-progress-bar"></div>
        </div>
    @endif

    <div class="users-container">
        <div class="users-head">
            <h6>User Management</h6>
            <button class="add-user-btn" id="addUserBtn">+ Add Account</button>
        </div>

        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge role-{{ strtolower($user->role) }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->status }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->id !== auth()->id())
                                    <button class="toggle-status-btn" data-id="{{ $user->id }}" data-status="{{ $user->status }}">
                                        {{ $user->status === 'active' ? 'Block' : 'Unblock' }}
                                    </button>
                                    <button class="delete-user-btn" data-id="{{ $user->id }}">Delete</button>
                                @else
                                    <span style="color: #999; font-size: 13px;">Current User</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pop-window">
        <div class="confirm-container">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="confirm-buttons">
                <button id="confirmDeleteUserBtn" class="confirm-delete-btn">Delete</button>
                <button id="cancelDeleteUserBtn" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Add User Popup -->
    <div class="add-user-overlay" id="addUserOverlay">
        <div class="add-user-popup">
            <button class="popup-close" id="closeAddUser">&times;</button>
            <h2>Add New Account</h2>
            <form action="{{ route('admin.users.store') }}" method="POST" class="add-user-form">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="Consumer">Consumer</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="submit-user-btn">Create Account</button>
            </form>
        </div>
    </div>

    <script>
        // Add User Popup
        const addUserBtn = document.getElementById('addUserBtn');
        const addUserOverlay = document.getElementById('addUserOverlay');
        const closeAddUser = document.getElementById('closeAddUser');

        addUserBtn.addEventListener('click', () => {
            addUserOverlay.classList.add('active');
        });

        closeAddUser.addEventListener('click', () => {
            addUserOverlay.classList.remove('active');
        });

        addUserOverlay.addEventListener('click', (e) => {
            if (e.target === addUserOverlay) {
                addUserOverlay.classList.remove('active');
            }
        });
    </script>
@endsection