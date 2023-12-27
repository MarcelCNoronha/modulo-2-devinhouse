<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Exception;
use App\Models\Exercise;
use Symfony\Component\HttpFoundation\Response;



class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        try {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        $user = auth()->user();
        $existingExercise = Exercise::where('user_id', $user->id)
            ->where('description', $request->input('description'))
            ->first();

        if ($existingExercise) {
            return response()->json(['error' => 'Exercício já cadastrado para o mesmo usuário.'], Response::HTTP_CONFLICT);
        }

        $exercise = new Exercise();
        $exercise->description = $request->input('description');
        $exercise->user_id = $user->id;
        $exercise->save();

        return response()->json($exercise, Response::HTTP_CREATED);
    
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }  
}
