@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-extrabold mb-6 text-orange-500 uppercase tracking-wider" style="text-shadow: 2px 2px 0px #000;">
            POW! Welcome to your Dashboard!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Users Card -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500 transform hover:scale-105 transition-all">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-3 text-orange-400 uppercase">Users</h2>
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-700 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <p class="text-blue-200">Manage all your users.</p>
                    <button class="mt-4 bg-orange-500 text-blue-900 px-4 py-2 rounded-lg font-bold uppercase tracking-wide hover:bg-orange-600">View All</button>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500 transform hover:scale-105 transition-all">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-3 text-orange-400 uppercase">Orders</h2>
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-700 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-blue-200">Track recent orders.</p>
                    <button class="mt-4 bg-orange-500 text-blue-900 px-4 py-2 rounded-lg font-bold uppercase tracking-wide hover:bg-orange-600">View All</button>
                </div>
            </div>

            <!-- Messages Card -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500 transform hover:scale-105 transition-all">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-3 text-orange-400 uppercase">Messages</h2>
                    <div class="w-12 h-12 mx-auto mb-4 bg-blue-700 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <p class="text-blue-200">View recent messages.</p>
                    <button class="mt-4 bg-orange-500 text-blue-900 px-4 py-2 rounded-lg font-bold uppercase tracking-wide hover:bg-orange-600">View All</button>
                </div>
            </div>
        </div>
    </main>

</body>
</html>