<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmailToUser;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function store(Request $request){


        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'date_birth' => 'required|date',
            'cpf' => 'required|string|max:14|unique:users',
            'password' => 'required|string|min:8|max:32',
            'plan_id' => 'required|integer',
        ]);
    
        $plan = Plan::find($request->plan_id);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->date_birth = $request->date_birth;
        $user->cpf = $request->cpf;
        $user->password = Hash::make($request->password);
        $user->plan_id = $request->plan_id;
        $user->save();
    
        $this->sendWelcomeEmail($user, $plan);
    
        return response()->json($user, 201);

        //cadastro de usuario


        try {
            $data = $request->all();
        // $data['email'] email do usuario

        $request->validate([
            'description'=> 'unique:plans'
        ]);

        Plan::create($data);

        Plan:where('plain_id', 1);

        Mail::to('email', 'name')
        ->send(new SendWelcomeEmailToUser('Marcel Cardoso'));

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 400);
        }

        


    }
}
