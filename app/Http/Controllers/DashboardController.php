<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Student;
use App\Models\Exercise;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    public function index()
    {    
        try {
            $user = auth()->user();

            $registered_students = Student::where('user_id', $user->id)->count();
            $registered_exercises = Exercise::where('user_id', $user->id)->count();
            $current_user_plan = Plan::find($user->plan_id);
            $remaining_students = $current_user_plan ? $current_user_plan->limit - $registered_students : null;

            $data = [
                'registered_students' => $registered_students,
                'registered_exercises' => $registered_exercises,
                'current_user_plan' => $current_user_plan,
                'remaining_students' => $remaining_students
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
