<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-xl font-bold mb-4">Login</h2>

    @if(session('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input name="email" type="email"
            placeholder="Email"
            class="w-full border p-2 mb-2 rounded">

        <input name="password" type="password"
            placeholder="Password"
            class="w-full border p-2 mb-2 rounded">

        <button class="bg-green-500 text-white w-full py-2 rounded">
            Login
        </button>
    </form>

    <a href="/register" class="text-blue-500 text-sm">Register</a>
</div>

</body>
</html>