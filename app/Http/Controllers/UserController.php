<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmailToUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {

        try {
            $data = $request->all();


            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'date_birth' => 'required|date',
                'cpf' => 'required|string|max:14|unique:users',
                'password' => 'required|string|min:8|max:32',
                'plan_id' => 'required|integer',
            ]);

            $user = User::create($data);

            Mail::to($user->email, $user->name)->send(new SendWelcomeEmailToUser($user));

            return response()->json($user, response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
