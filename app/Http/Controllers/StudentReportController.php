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
            $student = Student::with('workouts')->find($student_id);

            if (!$student) {
                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }

            $student = Student::with('workouts')->find($student_id);

            $pdf = Pdf::loadView('pdfs.workoutStudent', [
                'student' => $student,
                'workouts' => $student->workouts,
            ]);

            return $pdf->stream('treinos.pdf');

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

