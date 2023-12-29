<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Student;

class ValidateLimitStudentToUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $userPlan = $user->plan;
        
        $registeredStudents = Student::where('user_id', $user->id)->count();
    
        if ($registeredStudents >= $userPlan->limit) {
            return response()->json(['error' => 'Limite de cadastro de estudantes atingido.'], Response::HTTP_FORBIDDEN);
        }
    
        return $next($request);
    }
    
    
}
