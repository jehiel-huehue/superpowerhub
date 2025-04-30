<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperpowerController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Superpower;
use App\Models\TrainingLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/generate', [SuperpowerController::class, 'generate'])->name('generate');
Route::post('/generate_training', [TrainingController::class, 'generate_training'])->name('generate_training');
Route::post('/train', [TrainingController::class, 'train'])->name('train');

// Protected route example:
Route::middleware('auth')->group(function () {


    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role !== 'user') {
            return redirect('/admin/dashboard'); // Redirect to admin dashboard if not an user
        }

        $superpower = Superpower::where('user_id', $user->id)->first();
        $trainings = [];
        $averageLevel = 0;
        $completionRate = 0;
        $weeklyLogs = [];
        $daysSinceLastTraining = null;

        if ($superpower) {
            $trainings = $superpower->trainings;

            if ($trainings->count() > 0) {
                $totalLevel = $trainings->sum('level');
                $totalMaxLevel = $trainings->sum('max_level');

                $averageLevel = round($totalLevel / $trainings->count() + 0.00001);

                if ($totalMaxLevel > 0) {
                    $completionRate = round(($totalLevel / $totalMaxLevel) * 100, 2);
                }

                $trainingIds = $trainings->pluck('id');

                // 7-day log data
                $weeklyLogs = DB::table('training_logs')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                    ->whereIn('training_id', $trainingIds)
                    ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->orderBy('date')
                    ->get()
                    ->keyBy('date');

                // Time since last training in human-readable format
                $lastTraining = DB::table('training_logs')
                    ->whereIn('training_id', $trainingIds)
                    ->latest('created_at')
                    ->first();

                if ($lastTraining) {
                    $daysSinceLastTraining = Carbon::parse($lastTraining->created_at)->diffForHumans(); // <-- key part
                } else {
                    $daysSinceLastTraining = 'No training yet';
                }
            }
        }

        // Fill missing dates with zero
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $last7Days->push([
                'date' => $date,
                'total' => $weeklyLogs[$date]->total ?? 0
            ]);
        }

        return view('dashboard', [
            'trainings' => $trainings,
            'averageLevel' => $averageLevel,
            'completionRate' => $completionRate,
            'weeklyLogs' => $last7Days,
            'daysSinceLastTraining' => $daysSinceLastTraining,
        ]);
    });

    Route::get('/admin/users', function () {
        // Ensure the user is an admin
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect('/dashboard'); // Redirect to user dashboard if not an admin
        }

        // Get all users
        $users = User::where('role', '!=', 'admin')->get();
        $userAnalytics = [];

        foreach ($users as $user) {
            $superpower = Superpower::where('user_id', $user->id)->first();

            $averageLevel = 0;
            if ($superpower) {
                $trainings = $superpower->trainings;

                if ($trainings->count() > 0) {
                    // Calculate average level per user
                    $totalLevel = $trainings->sum('level');
                    $averageLevel = round($totalLevel / $trainings->count() + 0.00001);
                }
            }

            // Add user's analytics data to the userAnalytics array
            $userAnalytics[] = [
                'user' => $user,
                'averageLevel' => $averageLevel,
            ];
        }

        return view('admin.users', [
            'userAnalytics' => $userAnalytics,
        ]);
    });

    Route::get('/admin/dashboard', function () {
        // Ensure the user is an admin
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect('/dashboard');
        }
    
        $users = User::where('role', '!=', 'admin')->get();
        $userAnalytics = [];
    
        // Initialize counters for users with and without superpowers
        $usersWithSuperpower = 0;
        $usersWithoutSuperpower = 0;
    
        foreach ($users as $user) {
            $superpower = Superpower::where('user_id', $user->id)->first();
            $averageLevel = 0;
            $trainingLogCount = TrainingLog::where('user_id', $user->id)->count();
    
            // Count users with superpower or without
            if ($superpower) {
                $usersWithSuperpower++;
            } else {
                $usersWithoutSuperpower++;
            }
    
            if ($superpower) {
                $trainings = $superpower->trainings;
                if ($trainings->count() > 0) {
                    $totalLevel = $trainings->sum('level');
                    $averageLevel = round($totalLevel / $trainings->count() + 0.00001);
                }
            }
    
            $userAnalytics[] = [
                'user' => $user,
                'averageLevel' => $averageLevel,
                'trainingLogCount' => $trainingLogCount,
            ];
        }
    
        // Sort by training log count descending
        $mostActiveUsers = collect($userAnalytics)
            ->sortByDesc('trainingLogCount')
            ->take(5)
            ->values()
            ->all();
    
        // Data for chart
        $labels = [];
        $trainingCounts = [];
    
        foreach ($mostActiveUsers as $data) {
            $labels[] = $data['user']->name; // User names
            $trainingCounts[] = $data['trainingLogCount']; // Log count
        }
    
        // Group into hero classes
        $classCounts = [
            'Class C Hero' => 0,
            'Class B Hero' => 0,
            'Class A Hero' => 0,
            'S-Class Hero' => 0,
        ];
    
        foreach ($userAnalytics as $data) {
            $level = $data['averageLevel'];
            if ($level < 7) {
                $classCounts['Class C Hero']++;
            } elseif ($level == 8) {
                $classCounts['Class B Hero']++;
            } elseif ($level == 9) {
                $classCounts['Class A Hero']++;
            } elseif ($level == 10) {
                $classCounts['S-Class Hero']++;
            }
        }
    
        // Prepare data for the new chart (Has Superpower vs No Superpower)
        $superpowerLabels = ['Has Superpower', 'No Superpower'];
        $superpowerCounts = [$usersWithSuperpower, $usersWithoutSuperpower];
    
        return view('admin.dashboard', [
            'userAnalytics' => $userAnalytics,
            'classCounts' => $classCounts,
            'mostActiveUsers' => $mostActiveUsers,
            'labels' => $labels,
            'trainingCounts' => $trainingCounts,
            'superpowerLabels' => $superpowerLabels,
            'superpowerCounts' => $superpowerCounts,
        ]);
    });
    


    Route::get('/superpower', [SuperpowerController::class, 'showSuperpowerPage'])->name('superpower.page');
    Route::get('/training', [TrainingController::class, 'showTrainingPage'])->name('training.page');
});
