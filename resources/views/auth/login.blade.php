    
@include('layouts.head')

<body class="flex items-center justify-center min-h-screen bg-gray-700">

    <form method="POST" action="{{ route('login') }}" class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
        @csrf

        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-500 text-sm list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-2" for="password">Password</label>
            <input type="password" name="password" id="password" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" name="remember" class="mr-2"> Remember Me
            </label>
        </div>

        <button type="submit" class="w-full cursor-pointer bg-black text-white p-2 rounded text-bg-primary">Login</button>
    </form>

</body>
</html>