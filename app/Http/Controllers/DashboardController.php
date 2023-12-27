<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Student;
use App\Models\Exercise;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $user = Auth::user();

            $registeredStudents = Student::where('user_id', $user->id)->count();
            $registeredExercises = Exercise::where('user_id', $user->id)->count();
            $currentUserPlan = $user->plan->description;
            $remainingStudents = max(0, $user->plan->limit - $registeredStudents);

            return response()->json([
                'registered_students' => $registeredStudents,
                'registered_exercises' => $registeredExercises,
                'current_user_plan' => $currentUserPlan,
                'remaining_students' => $remainingStudents,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
