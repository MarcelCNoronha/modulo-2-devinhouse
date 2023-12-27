<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
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

}