<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Exercise;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{

    use HttpResponses;

    public function index()
    {
        $user = auth()->user();
        $exercises = Exercise::where('user_id', $user->id)
            ->orderBy('description')
            ->get();

        return response()->json($exercises, Response::HTTP_OK);
    }

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
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $exercise = Exercise::find($id);
    
        if (!$exercise) {
            return response()->json(['error' => 'Exercício não encontrado.'], Response::HTTP_NOT_FOUND);
        }
    
        if ($exercise->user_id !== $user->id) {
            return response()->json(['error' => 'Acesso não autorizado.'], Response::HTTP_FORBIDDEN);
        }
    
        if ($exercise->workouts()->count() > 0) {
            return response()->json(['error' => 'Não é permitido deletar o exercício devido a treinos vinculados.'], Response::HTTP_CONFLICT);
        }
    
        $exercise->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
    
    
}
