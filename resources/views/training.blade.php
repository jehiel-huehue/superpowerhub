@include('layouts.head')

<body class="bg-blue-900 min-h-screen flex">
    @include('layouts.sidebar')
   
    <main class="flex-1 p-6 space-y-6">
        <h1 class="text-3xl font-extrabold mb-6 text-orange-500 uppercase tracking-wider" style="text-shadow: 2px 2px 0px #000;">
            TRAIN Your Superpower!
        </h1>

        @if ($superpower)
            <div class="bg-gray-800 rounded-lg shadow-lg border-2 border-orange-500 p-6 mb-6">
                <h2 class="text-2xl font-extrabold text-orange-400 uppercase" style="text-shadow: 1px 1px 0px #000;">
                    SUPERPOWER: {{ $superpower->superpower }}
                </h2>
            </div>
            
            <div class="bg-blue-800 p-4 rounded-lg border-l-4 border-orange-500 flex justify-between items-center mb-6"> 
                <p class="text-xl font-bold text-blue-100">
                    Training Available Today: 
                    <span class="bg-orange-500 text-blue-900 px-3 py-1 rounded-full font-extrabold">
                        {{ $trainings->where('trainings_per_day', '>', 0)->count() }}
                    </span>
                </p>
                
                @if ($trainings->count() == 0)
                    <button id="generateBtn" class="bg-orange-500 hover:bg-orange-600 text-blue-900 font-extrabold uppercase py-3 px-6 rounded-lg transform hover:scale-105 transition-all" style="box-shadow: 0px 4px 0px #c05621;">
                        GENERATE TRAINING!
                    </button>
                @endif
            </div>
            
            @if ($trainings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($trainings as $training)
                        <div class="flex flex-col justify-between bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-orange-500 hover:transform hover:scale-105 transition-duration-300 h-full">
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-xl font-extrabold text-orange-400 uppercase">{{ $training->title }}</h3>
                                    <div class="bg-blue-700 px-3 py-1 rounded-full text-sm text-blue-100 font-bold">
                                        LEVEL {{ $training->level }}/{{ $training->max_level }}
                                    </div>
                                </div>
                                <p class="text-blue-100 mb-4">{{ $training->description }}</p>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="text-blue-200 font-medium">
                                        <span class="text-orange-300">Trainings Left Today:</span> 
                                        <span class="font-extrabold">{{ $training->trainings_per_day }}</span>
                                    </div>
                                </div>
                                
                                <button 
                                    id="trainingBtn" 
                                    class="w-full p-3 bg-orange-500 text-blue-900 rounded-lg font-extrabold uppercase tracking-wider transition-all
                                    {{ $training->trainings_per_day === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-orange-600 transform hover:scale-105' }}"
                                    style="box-shadow: 0px 4px 0px #c05621;"
                                    {{ $training->trainings_per_day === 0 ? 'disabled' : '' }}
                                >
                                    <div class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        {{ $training->trainings_per_day > 0 ? 'TRAIN NOW!' : 'NO TRAININGS LEFT' }}
                                    </div>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-800 p-8 rounded-lg border-2 border-orange-500 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-orange-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xl text-blue-100 font-bold">No training available yet for this superpower.</p>
                </div>
            @endif
        @else
            <div class="bg-gray-800 p-8 rounded-lg border-2 border-orange-500 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-orange-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-xl text-blue-100 font-bold mb-6">You don't have a superpower yet!</p>
                <a href="/superpower" class="bg-orange-500 hover:bg-orange-600 text-blue-900 font-extrabold uppercase py-3 px-6 rounded-lg transform inline-block hover:scale-105 transition-all" style="box-shadow: 0px 4px 0px #c05621;">
                    GET YOUR POWER!
                </a>
            </div>
        @endif
    </main>

    <script>
        const btn = document.getElementById('generateBtn');
        
        if (btn) {
            btn.addEventListener('click', async () => {
                btn.disabled = true;
                btn.innerText = 'GENERATING...';
                btn.classList.add('animate-pulse');

                try {
                    const response = await fetch('{{ route('generate_training') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });

                    const data = await response.json();
                    
                    // Show comic-style success message
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-blue-800 border-4 border-orange-500 p-6 rounded-lg shadow-xl z-50';
                    messageDiv.innerHTML = `
                        <h2 class="text-2xl font-extrabold text-orange-400 uppercase mb-4">WHAM! SUCCESS!</h2>
                        <p class="text-blue-100 mb-4">Your training has been generated!</p>
                        <div class="text-center">
                            <div class="inline-block bg-orange-500 text-blue-900 font-bold py-2 px-4 rounded-lg">
                                Loading your training...
                            </div>
                        </div>
                    `;
                    document.body.appendChild(messageDiv);

                    // After a short delay, refresh the page
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);

                } catch (error) {
                    console.error('Error generating training:', error);
                    
                    // Show comic-style error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-red-800 border-4 border-orange-500 p-6 rounded-lg shadow-xl z-50';
                    errorDiv.innerHTML = `
                        <h2 class="text-2xl font-extrabold text-orange-400 uppercase mb-4">CRASH! ERROR!</h2>
                        <p class="text-blue-100 mb-4">Failed to generate training.</p>
                        <div class="text-center">
                            <button class="bg-orange-500 text-blue-900 font-bold py-2 px-4 rounded-lg" onclick="this.parentElement.parentElement.remove()">
                                Try Again
                            </button>
                        </div>
                    `;
                    document.body.appendChild(errorDiv);
                    
                } finally {
                    btn.disabled = false;
                    btn.innerText = 'GENERATE TRAINING!';
                    btn.classList.remove('animate-pulse');
                }
            });
        }
        
        // Add event listeners to training buttons
        document.querySelectorAll('#trainingBtn').forEach(button => {
            if (!button.disabled) {
                button.addEventListener('click', function() {
                    // Add a pulse effect when clicked
                    this.classList.add('animate-pulse');
                    setTimeout(() => {
                        this.classList.remove('animate-pulse');
                        
                        // Show comic-style training message
                        const trainingDiv = document.createElement('div');
                        trainingDiv.className = 'fixed top-1/4 left-1/2 transform -translate-x-1/2 bg-blue-800 border-4 border-orange-500 p-6 rounded-lg shadow-xl z-50';
                        trainingDiv.innerHTML = `
                            <h2 class="text-2xl font-extrabold text-orange-400 uppercase mb-4">ZAP! Training In Progress!</h2>
                            <p class="text-blue-100 mb-4">Your powers are growing stronger!</p>
                            <div class="text-center">
                                <button class="bg-orange-500 text-blue-900 font-bold py-2 px-4 rounded-lg" onclick="this.parentElement.parentElement.remove(); window.location.reload();">
                                    AWESOME!
                                </button>
                            </div>
                        `;
                        document.body.appendChild(trainingDiv);
                    }, 1000);
                });
            }
        });
    </script>
</body>
</html>