<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;
    use SoftDeletes;

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:students,email|max:255',
                'date_birth' => 'required|date_format:Y-m-d',
                'cpf' => [
                    'required',
                    'unique:students,cpf',
                    'regex:/^\d{3}\d{3}\d{3}\d{2}$/',
                ],
                'contact' => 'required|max:20',
                'cep' => 'max:20',
                'street' => 'max:30',
                'state' => 'max:2',
                'neighborhood' => 'max:50',
                'city' => 'max:50',
                'number' => 'max:30',
            ]);


            $user = auth()->user();
            // $userPlan = $user->plan;

            // if ($userPlan->limit_students <= $user->students()->count()) {
            //     return response()->json(['error' => 'Limite de cadastro de estudantes atingido.'], Response::HTTP_FORBIDDEN);
            // }

            $student = new Student([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'date_birth' => $request->input('date_birth'),
                'cpf' => $request->input('cpf'),
                'contact' => $request->input('contact'),
                'cep' => $request->input('cep'),
                'street' => $request->input('street'),
                'state' => $request->input('state'),
                'neighborhood' => $request->input('neighborhood'),
                'city' => $request->input('city'),
                'number' => $request->input('number'),
                'user_id' => $user->id,
            ]);

            $student->save();

            return response()->json($student, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $query = Student::where('user_id', $user->id);

            $query = Student::query();

            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->has('cpf')) {
                $query->where('cpf', 'like', '%' . $request->input('cpf') . '%');
            }

            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->input('email') . '%');
            }

            $students = $query->orderBy('name')->get();

            return response()->json($students, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        if ($student->user_id !== $user->id) {
            return response()->json(['error' => 'Acesso proibido.'], Response::HTTP_FORBIDDEN);
        }

        $student->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $student = Student::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id . '|max:255',
            'date_birth' => 'sometimes|date_format:Y-m-d',
            'cpf' => [
                'sometimes',
                'unique:students,cpf,' . $id,
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$|^\d{11}$/',
            ],
            'cep' => 'sometimes|max:20',
            'street' => 'sometimes|max:30',
            'state' => 'sometimes|max:2',
            'neighborhood' => 'sometimes|max:50',
            'city' => 'sometimes|max:50',
            'number' => 'sometimes|max:30',
            'contact' => 'sometimes|max:20',
        ]);

        $student->update($request->all());

        return response()->json($student, Response::HTTP_OK);
    }

    public function getWorkouts($studentId)
    {
        $workouts = Workout::where('student_id', $studentId)
            ->orderBy('day')
            ->orderBy('created_at')
            ->get();

        $groupedWorkouts = $workouts->groupBy('day');

        return response()->json($groupedWorkouts, Response::HTTP_OK);
    }

}
