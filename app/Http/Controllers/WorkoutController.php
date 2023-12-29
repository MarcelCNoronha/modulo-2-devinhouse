<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{

    use HttpResponses;

    public function store(Request $request)
    {

        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'exercise_id' => 'required|exists:exercises,id',
                'repetitions' => 'required|integer',
                'weight' => 'required|numeric',
                'break_time' => 'required|integer',
                'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
                'observations' => 'nullable|string',
                'time' => 'required|integer',
            ]);

            $existingWorkout = Workout::where('student_id', $request->student_id)
                ->where('exercise_id', $request->exercise_id)
                ->where('day', $request->day)
                ->first();

            if ($existingWorkout) {
                return response()->json(['error' => 'Já existe um treino cadastrado para o mesmo dia e exercício.'], Response::HTTP_CONFLICT);
            }

            $workout = Workout::create($request->all());

            return response()->json($workout, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
