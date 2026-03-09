<form action="{{ route('login.password') }}" method="POST" enctype="multipart/form-data" id="loginForm">
    @csrf

    <div class="mb-3">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" required>
    </div>

    <div id="passwordSection">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Login</button>
</form>