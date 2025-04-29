@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-lg p-8 bg-gray-800 rounded-lg shadow-lg border-2 border-orange-500">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-orange-500 uppercase tracking-wider text-shadow-lg">Join the Hero League!</h1>
            <p class="text-blue-200 mt-2 text-lg">Create your account and start your superpower journey!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div class="flex flex-col space-y-2">
                <!-- Name Input -->
                <label for="name" class="text-orange-400 font-bold">Hero Name</label>
                <input id="name" name="name" type="text" placeholder="Enter your hero name" class="p-2 bg-gray-700 text-white rounded-lg border-2 border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500" required>

                <!-- Email Input -->
                <label for="email" class="text-orange-400 font-bold">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" class="p-2 bg-gray-700 text-white rounded-lg border-2 border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500" required>

                <!-- Password Input -->
                <label for="password" class="text-orange-400 font-bold">Password</label>
                <input id="password" name="password" type="password" placeholder="Enter your password" class="p-2 bg-gray-700 text-white rounded-lg border-2 border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500" required>

                <!-- Confirm Password Input -->
                <label for="password_confirmation" class="text-orange-400 font-bold">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm your password" class="p-2 bg-gray-700 text-white rounded-lg border-2 border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full py-3 bg-orange-500 text-blue-900 rounded-lg font-extrabold text-xl tracking-wider hover:bg-orange-600 transition-all transform hover:scale-105">
                Join the Hero League
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-blue-200">Already have an account? <a href="{{ route('login') }}" class="text-orange-400 font-bold hover:underline">Login here</a></p>
        </div>
    </div>
</body>
</html>
