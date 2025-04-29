@include('layouts.head')

<body class="flex items-center justify-center min-h-screen bg-blue-900">

    <form method="POST" action="{{ route('login') }}" class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-sm transform hover:scale-105 transition-all">
        @csrf

        <h1 class="text-3xl font-extrabold text-orange-500 uppercase text-center text-shadow-lg mb-8">Login to your Hero Account</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-500 text-white p-4 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <label for="email" class="block text-orange-400 font-bold text-sm mb-2">Hero Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="w-full p-4 bg-gray-700 text-white border-2 border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-orange-400 font-bold text-sm mb-2">Hero Password</label>
            <input type="password" name="password" id="password" required class="w-full p-4 bg-gray-700 text-white border-2 border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all">
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center text-sm text-gray-300">
                <input type="checkbox" name="remember" class="mr-2 text-orange-500"> Remember Me
            </label>
        </div>

        <button type="submit" class="w-full p-4 bg-orange-500 text-blue-900 rounded-lg font-extrabold text-xl tracking-wider hover:bg-orange-600 transform transition-all hover:scale-105">
            Login Now
        </button>

        <div class="mt-6 text-center">
            <p class="text-blue-200">Not a hero yet? <a href="{{ route('register') }}" class="text-orange-400 font-bold hover:underline">Create an account</a></p>
        </div>
    </form>

</body>
</html>
