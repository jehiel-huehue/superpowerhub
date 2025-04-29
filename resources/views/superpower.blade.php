@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6 space-y-6">
        <h1 class="text-3xl font-semibold mb-6 text-orange-500 uppercase tracking-wider" style="text-shadow: 2px 2px 0px #000;">
            Welcome to your Superpower Generator!
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            @if ($superpower)

            
                <!-- Display Existing Superpower -->
                <div id="superpowerResult" class="bg-gray-800 p-6 rounded-lg shadow-lg w-full">
                    <h2 class="text-2xl font-bold mb-4 text-blue-600" id="powerName">Superpower: {{ $superpower->superpower }}</h2>
                    <p class="text-white mb-2" id="powerDescription">Description: {{ $superpower->description }}</p>
                    <p class="text-green-600 font-semibold" id="powerStrength">Strength: {{ $superpower->strength }}</p>
                    <p class="text-red-600 font-semibold" id="powerWeakness">Weakness: {{ $superpower->weakness }}</p>
                </div>
            @else
                <!-- Button to Generate Superpower -->
                <button id="generateBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                    Generate Superpower
                </button>
            @endif

        </div>
    </main>

    <script>
        const btn = document.getElementById('generateBtn');
        const resultDiv = document.getElementById('superpowerResult');
        const powerName = document.getElementById('powerName');
        const powerDescription = document.getElementById('powerDescription');
        const powerStrength = document.getElementById('powerStrength');
        const powerWeakness = document.getElementById('powerWeakness');

        btn.addEventListener('click', async () => {
            btn.disabled = true;
            btn.innerText = 'Generating...';

            try {
                const response = await fetch('{{ route('generate') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();
                alert('Superpower successfully generated! Refreshing...');

                // After a short delay, refresh the page

                setTimeout(() => {
                    window.location.reload();
                }, 2000); // Adjust the delay as needed

            } catch (error) {
                console.error('Error generating superpower:', error);
                alert('Failed to generate superpower.');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Generate Superpower';
            }
        });
    </script>

</body>
</html>