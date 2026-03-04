<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
           <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-xl font-bold mb-4">Register</h2>

    <form method="POST" action="/register">
        @csrf

        <input name="name" placeholder="Name"
            class="w-full border p-2 mb-2 rounded">

        <input name="email" type="email" placeholder="Email"
            class="w-full border p-2 mb-2 rounded">

        <input name="password" type="password" placeholder="Password"
            class="w-full border p-2 mb-2 rounded">

        <button class="bg-blue-500 text-white w-full py-2 rounded">
            Register
        </button>
    </form>

    <a href="/login" class="text-blue-500 text-sm">Login</a>
</div>

</body>
</html>