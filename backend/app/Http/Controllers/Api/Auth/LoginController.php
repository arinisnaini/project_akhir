<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    /**
    * Handle the incoming request.
    */
    public function __invoke(Request $request)
    {
        auth()->shouldUse('web');
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            
            return (new UserResource($user))->additional([
                'token' => $user->createToken('myAppToken')
                 ->plainTextToken,
            ]);
        }
        return response()->json([
            'message' => 'Your credential does not match.',
        ], 401);
    }
}