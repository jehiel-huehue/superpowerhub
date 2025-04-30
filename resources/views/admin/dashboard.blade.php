@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.adminsidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-extrabold mb-6 text-orange-500 uppercase tracking-wider"
            style="text-shadow: 2px 2px 0px #000;">
            POW! Welcome to your Dashboard Admin!
        </h1>

        <div class="flex gap-2">
            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-2xl font-bold mb-4 text-orange-400">Hero Class Distribution</h2>
                <div class="relative h-48">
                    <!-- Chart.js or other chart library could be used here -->
                    <canvas id="heroClassChart" height="120"></canvas>
                </div>
            </div>

            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-2xl font-bold mb-4 text-orange-400">Most Active Users</h2>
                <div class="relative h-48">
                    <!-- Chart.js or other chart library could be used here -->
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <div class="w-2/6 mt-8 bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500">
                <h2 class="text-2xl font-bold mb-4 text-orange-400">Most Active Users</h2>
                <div class="relative h-48">
                    <!-- Chart.js or other chart library could be used here -->
                    <canvas id="superpowerChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

    </main>
    <script>
        const classCtx = document.getElementById('heroClassChart').getContext('2d');
        const heroClassChart = new Chart(classCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($classCounts)) !!},
                datasets: [{
                    label: 'Number of Users',
                    data: {!! json_encode(array_values($classCounts)) !!},
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)', // C - orange
                        'rgba(250, 204, 21, 0.8)', // B - yellow
                        'rgba(34, 197, 94, 0.8)', // A - green
                        'rgba(59, 130, 246, 0.8)', // S - blue
                    ],
                    borderColor: [
                        'rgba(251, 191, 36, 1)',
                        'rgba(250, 204, 21, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                    ],
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#1e3a8a'
                        },
                        grid: {
                            color: '#d1d5db'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#1e3a8a'
                        },
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#1e3a8a'
                        }
                    }
                }
            }
        });

        var ctx = document.getElementById('activityChart').getContext('2d');

        var activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels), // User names
                datasets: [{
                    label: 'Training Log Counts',
                    data: @json($trainingCounts), // Training log counts per user
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color
                    fill: true,
                    tension: 0.4 // Smooth line
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        var ctx3 = document.getElementById('superpowerChart').getContext('2d');
        var superpowerChart = new Chart(ctx3, {
            type: 'bar',  // Bar chart to compare Has Superpower vs No Superpower
            data: {
                labels: @json($superpowerLabels),  // Labels: 'Has Superpower' and 'No Superpower'
                datasets: [{
                    label: 'Users',
                    data: @json($superpowerCounts),  // Counts of users with and without superpowers
                    backgroundColor: [
                        'rgba(0, 123, 255, 0.2)',  // Light blue for Has Superpower
                        'rgba(255, 99, 132, 0.2)'   // Light red for No Superpower
                    ],
                    borderColor: [
                        'rgba(0, 123, 255, 1)',    // Blue border for Has Superpower
                        'rgba(255, 99, 132, 1)'    // Red border for No Superpower
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Users'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
