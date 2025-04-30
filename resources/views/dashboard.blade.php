@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-extrabold mb-6 text-orange-500 uppercase tracking-wider"
            style="text-shadow: 2px 2px 0px #000;">
            POW! Welcome to your Dashboard!
        </h1>

        <div class="mb-6 p-4 bg-gray-700 text-white rounded-lg shadow-md">
            <p class="text-lg">Power Level: <span class="font-bold">{{ $averageLevel }}</span></p>

            @if ($averageLevel < 6)
                <p class="text-orange-400 font-semibold mt-2">You are a Class C Hero.</p>
            @elseif ($averageLevel == 7)
                <p class="text-orange-400 font-semibold mt-2">You are a Class C Hero.</p>
            @elseif ($averageLevel == 8)
                <p class="text-yellow-400 font-semibold mt-2">You are a Class B Hero.</p>
            @elseif ($averageLevel == 9)
                <p class="text-green-400 font-semibold mt-2">You are a Class A Hero.</p>
            @elseif ($averageLevel == 10)
                <p class="text-blue-400 font-semibold mt-2">You are an S-Class Hero.</p>
            @endif
        </div>

        <div class="flex gap-2">
            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-2xl font-bold mb-4 text-orange-400">Average Training Level</h2>
                <div class="relative h-48">
                    <!-- Chart.js or other chart library could be used here -->
                    <canvas id="progressBarChart"></canvas>
                </div>
            </div>
            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-2xl font-bold mb-4 text-orange-400">Last 7 days Training</h2>
                <div class="relative h-48">
                    <!-- Chart.js or other chart library could be used here -->
                    <canvas id="weeklyTrainingChart"></canvas>
                </div>
            </div>
            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-lg font-semibold text-gray-700">Time Since Last Training</h2>
                <p class="text-2xl font-bold text-indigo-600">
                    {{ $daysSinceLastTraining }}
                </p>
            </div>
        </div>
        <!-- Chart for Average Training Level -->

    </main>
    <script>
        var ctx = document.getElementById('progressBarChart').getContext('2d');
        const remaining = 100 - {{ $completionRate }};
        var progressBarChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Progress', 'Remaining'],
                datasets: [{
                    data: [{{ $completionRate }}, remaining], // Replace 70 with your progress value
                    backgroundColor: ['#4FC987',
                        '#fff'
                    ], // Green for progress and gray for remaining
                    borderWidth: 0, // No border around the segments,
                    hoverOffset: 4
                }]
            },

            options: {
                cutoutPercentage: 80,
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true // Disable tooltip if not needed
                    },
                    legend: {
                        display: true // Hide the legend
                    }
                }
            }
        });

        const weeklyLogs = @json($weeklyLogs);

        const labels = weeklyLogs.map(entry => entry.date);
        const data = weeklyLogs.map(entry => entry.total);

        const ctx2 = document.getElementById('weeklyTrainingChart').getContext('2d');
        const weeklyChart = new Chart(ctx2, {
            type: 'bar', // you can use 'line' if you prefer
            data: {
                labels: labels,
                datasets: [{
                    label: 'Trainings per Day (Last 7 Days)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
</body>

</html>
