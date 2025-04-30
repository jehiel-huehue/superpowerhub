<?php

namespace App\Http\Controllers;

use App\Models\Superpower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SuperpowerController extends Controller
{

    public function showSuperpowerPage()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Retrieve the superpower associated with the user (if any)
        $superpower = $user->superpower; // assuming the relationship is defined

        // Pass the superpower data to the view
        return view('superpower', compact('superpower', 'user'));
    }
    
    public function generate(Request $request)
    {
        try {
            // Fetch all existing superpower names
            $existingSuperpowers = Superpower::pluck('superpower')->toArray();
            $existingSuperpowersText = implode(', ', $existingSuperpowers);

            // Prepare the instruction
            $instruction = "Generate a common superpower (not weird or abstract) in this format: 
                            superpower=\"<basic superpower name>\" description=\"<what it does>\" strength=\"<strong point>\" weakness=\"<weak point>\".
                            The superpower should be simple and recognizable like flying, teleportation, super speed, invisibility, strength, healing, telekinesis, etc.
                            Do NOT generate any of these existing superpowers: $existingSuperpowersText.";

            // Make the API call to OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'HTTP-Referer' => env('OPENROUTER_SITE_URL', ''),
                'X-Title' => env('OPENROUTER_SITE_NAME', '')
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'google/gemma-3-4b-it:free',
                'temperature' => 0.7, // Normal output
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

            // Log full API response
            Log::info('Superpower API Response:', $response->json());

            // Extract the AI message
            $textResponse = $response->json('choices.0.message.content', '');

            // Parse values
            preg_match('/superpower="([^"]+)"/', $textResponse, $superpowerMatch);
            preg_match('/description="([^"]+)"/', $textResponse, $descriptionMatch);
            preg_match('/strength="([^"]+)"/', $textResponse, $strengthMatch);
            preg_match('/weakness="([^"]+)"/', $textResponse, $weaknessMatch);

            $superpower = $superpowerMatch[1] ?? 'Unknown Superpower';
            $description = $descriptionMatch[1] ?? 'No description.';
            $strength = $strengthMatch[1] ?? 'No strength details.';
            $weakness = $weaknessMatch[1] ?? 'No weakness details.';

            // Save to database
            $superpowerRecord = Superpower::create([
                'superpower' => $superpower,
                'description' => $description,
                'strength' => $strength,
                'weakness' => $weakness,
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'superpower' => $superpower,
                'description' => $description,
                'strength' => $strength,
                'weakness' => $weakness,
                'user_id' => $superpowerRecord->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating superpower: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate superpower.'], 500);
        }
    }


}