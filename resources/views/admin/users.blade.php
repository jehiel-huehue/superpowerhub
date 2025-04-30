@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.adminsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-extrabold mb-6 text-orange-500 uppercase tracking-wider"
            style="text-shadow: 2px 2px 0px #000;">
            POW! Welcome to your Dashboard Admin!
        </h1>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-blue-900">User Training Analytics</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Hero Class
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                        @foreach ($userAnalytics as $analytics)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $analytics['user']->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $analytics['user']->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                    @if ($analytics['averageLevel'] < 6)
                                        <p class="text-orange-400 font-semibold mt-2">Class C Hero.</p>
                                        <p> Power Level ({{ $analytics['averageLevel'] }})</p>
                                    @elseif ($analytics['averageLevel'] == 7)
                                        <p class="text-orange-400 font-semibold mt-2">Class C Hero.</p>
                                    @elseif ($analytics['averageLevel'] == 8)
                                        <p class="text-yellow-400 font-semibold mt-2">Class B Hero.</p>
                                    @elseif ($analytics['averageLevel'] == 9)
                                        <p class="text-green-400 font-semibold mt-2">Class A Hero.</p>
                                    @elseif ($analytics['averageLevel'] == 10)
                                        <p class="text-blue-400 font-semibold mt-2">S-Class Hero. Power {{ $analytics['averageLevel'] }}</p>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <script></script>
</body>

</html>
