<!-- Sidebar Spacer (keeps content from being hidden under fixed sidebar) -->
<div class="w-64"></div>



<!-- Fixed Comics-themed Sidebar -->
<aside class="fixed h-screen w-64 bg-gray-900 shadow-lg flex flex-col justify-between border-r-4 border-orange-500">
    <div>
        <!-- App Title with Comic-Style Typography -->
        <div class="p-6 border-b-2 border-orange-500 bg-blue-900">
            <h1 class="text-xl font-extrabold text-white tracking-wider uppercase" style="text-shadow: 2px 2px 0px #000;">
                SuperPower_Hub
            </h1>
        </div>
        
        @if (Route::is('dashboard'))
            <p class="mx-4 my-2 p-2 bg-blue-800 text-orange-300 rounded-lg font-bold text-center">
                BOOM! You're on the Dashboard!
            </p>
        @endif
        
        <!-- Navigation Links with Comic Styling -->
        <nav class="flex flex-col p-4 space-y-3">
            <a href="/dashboard" class="block p-3 rounded-lg font-bold uppercase tracking-wide text-orange-300 hover:bg-blue-700 hover:text-orange-400 transform hover:scale-105 transition-all {{ request()->is('dashboard') ? 'bg-blue-800 border-l-4 border-orange-500' : '' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </div>
            </a>
            <a href="/superpower" class="block p-3 rounded-lg font-bold uppercase tracking-wide text-orange-300 hover:bg-blue-700 hover:text-orange-400 transform hover:scale-105 transition-all {{ request()->is('superpower') ? 'bg-blue-800 border-l-4 border-orange-500' : '' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Superpower
                </div>
            </a>
            <a href="/training" class="block p-3 rounded-lg font-bold uppercase tracking-wide text-orange-300 hover:bg-blue-700 hover:text-orange-400 transform hover:scale-105 transition-all {{ request()->is('training') ? 'bg-blue-800 border-l-4 border-orange-500' : '' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Training
                </div>
            </a>
            <a href="/reports" class="block p-3 rounded-lg font-bold uppercase tracking-wide text-orange-300 hover:bg-blue-700 hover:text-orange-400 transform hover:scale-105 transition-all {{ request()->is('reports') ? 'bg-blue-800 border-l-4 border-orange-500' : '' }}">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Reports
                </div>
            </a>
        </nav>
    </div>

    <!-- Comic-Styled Logout Button -->
    <div class="mb-6 mx-4">
        <form method="POST" action="{{ route('logout') }}" class="p-2">
            @csrf
            <button type="submit" class="w-full bg-orange-500 text-blue-900 p-3 rounded-lg font-extrabold uppercase tracking-wider hover:bg-orange-600 transform hover:scale-105 transition-all" style="box-shadow: 0px 4px 0px #c05621;">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    POW! Logout
                </div>
            </button>
        </form>
    </div>
</aside>