<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Training;
use App\Models\TrainingLog;
use App\Models\Superpower;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function showTrainingPage()
    {
        $user = Auth::user();

        // Get the user's superpower (assuming 1 superpower per user)
        $superpower = Superpower::where('user_id', $user->id)->first();
        Log::info('Superpower API Response:' . $superpower);
        $trainings = [];

        if ($superpower) {
            // Get all trainings linked to this superpower
            $trainings = $superpower->trainings; // Make sure you have a relation in Superpower model
        }

        return view('training', compact('superpower', 'trainings'));
    }

    public function generate_training(Request $request)
    {
        try {
            // Fetch the logged-in user's current superpower
            $userSuperpower = Superpower::where('user_id', Auth::id())->latest()->first();

            if (!$userSuperpower) {
                return response()->json(['error' => 'No superpower found for the user.'], 400);
            }

            // Fetch all existing trainings for this superpower
            $existingTrainings = Training::where('superpower_id', $userSuperpower->id)
                                        ->pluck('title')
                                        ->toArray();
            $existingTrainingsText = implode(', ', $existingTrainings);

            // Prepare the instruction for OpenRouter AI
            $instruction = "Generate multiple different training routines (3-5) for the following superpower:
            Superpower: {$userSuperpower->superpower}
            Description: {$userSuperpower->description}
            Strength: {$userSuperpower->strength}
            Weakness: {$userSuperpower->weakness}

            Each training should help the user improve their strengths and work on their weaknesses. 
            Make them practical, realistic, and unique.
            Avoid repeating any of these existing trainings: {$existingTrainingsText}.

            Respond ONLY in this format for each training:
            training=\"<training title>\" description=\"<short training explanation>\"

            Separate each training clearly.";

            // Make the API call to OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'HTTP-Referer' => env('OPENROUTER_SITE_URL', ''),
                'X-Title' => env('OPENROUTER_SITE_NAME', '')
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'google/gemma-3-4b-it:free',
                'temperature' => 0.7,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $instruction
                            ]
                        ]
                    ]
                ]
            ]);

            // Log the full response
            Log::info('Training Generation API Response:', $response->json());

            // Extract the AI text response
            $textResponse = $response->json('choices.0.message.content', '');

            // Find all trainings using regex
            preg_match_all('/training="([^"]+)" description="([^"]+)"/', $textResponse, $matches, PREG_SET_ORDER);

            if (empty($matches)) {
                return response()->json(['error' => 'No valid trainings found in AI response.'], 400);
            }

            $savedTrainings = [];

            foreach ($matches as $match) {
                $trainingTitle = $match[1];
                $trainingDescription = $match[2];

                // Check if this training already exists
                $alreadyExists = Training::where('superpower_id', $userSuperpower->id)
                                        ->where('title', $trainingTitle)
                                        ->exists();

                if ($alreadyExists) {
                    continue; // Skip duplicates
                }

                // Save the training
                $trainingRecord = Training::create([
                    'superpower_id' => $userSuperpower->id,
                    'title' => $trainingTitle,
                    'description' => $trainingDescription,
                    'level' => 1,
                    'max_level' => 10,
                    'trainings_per_day' => 1,
                    'ai_response' => json_encode($response->json())
                ]);

                $savedTrainings[] = [
                    'title' => $trainingTitle,
                    'description' => $trainingDescription,
                    'training_id' => $trainingRecord->id
                ];
            }

            if (empty($savedTrainings)) {
                return response()->json(['error' => 'All generated trainings already exist.'], 400);
            }

            // Return all saved trainings
            return response()->json([
                'trainings' => $savedTrainings,
                'user_id' => Auth::id(),
                'superpower_id' => $userSuperpower->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating training: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate training.'], 500);
        }
    }

    public function train(Request $request)
    {
        Log::info('Train method called', ['request_data' => $request->all()]);

        $request->validate([
            'id' => 'required|exists:trainings,id'
        ]);

        $training = Training::find($request->id);

        if (!$training) {
            Log::warning('Training not found', ['id' => $request->id]);
            return response()->json(['error' => 'Training not found'], 404);
        }

        $user = Auth::user(); // Get the authenticated user

        $previousLevel = $training->level;
        $training->trainings_per_day = 0;
        $training->level += 1;
        $training->save();

        // Save to TrainingLog
        TrainingLog::create([
            'training_id' => $training->id,
            'user_id' => $user->id,
            'previous_level' => $previousLevel,
            'new_level' => $training->level,
            'trained_at' => now(),
        ]);

        Log::info('Training updated and logged', [
            'training_id' => $training->id,
            'user_id' => $user->id,
            'previous_level' => $previousLevel,
            'new_level' => $training->level,
        ]);

        return response()->json([
            'message' => 'Training updated successfully.',
            'training' => $training
        ]);
    }

}