<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentReportController extends Controller
{
    use HttpResponses;

    public function showWorkout(Request $request)
    {
        $student_id = $request->input('student_id');
    
        try {
            $student = Student::find($student_id);
            $workouts = Workout::with('exercise')->where('student_id', $student_id)->get();
    
            if (!$student) {
                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }
    
            if ($workouts->isEmpty()) {
                return $this->error('Treinos não encontrados para este estudante', Response::HTTP_NOT_FOUND);
            }
    
            // Verifica se a relação "exercise" está carregada corretamente
            foreach ($workouts as $workout) {
                if (!$workout->relationLoaded('exercise')) {
                    $workout->load('exercise');
                }
            }
    
            $pdf = Pdf::loadView('pdfs.workoutStudent', [
                'name' => $student->name,
                'workouts' => $workouts->map(function ($workout) {
                    return [
                        "description" => $workout->relationLoaded('exercise') ? $workout->exercise->description : null,
                        "repetitions" => $workout->repetitions,
                        "weight" => $workout->weight,
                        "break_time" => $workout->break_time,
                        "day" => $workout->day,
                        "observations" => $workout->observations,
                    ];
                }),
            ]);
            
            return $pdf->stream('treinos.pdf');
            
    
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
}
