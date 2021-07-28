<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        Log::info('Registration');
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|string|max:255|min:6|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->first(),
                'status_code' => 422
            ],422);
        }
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole(config('access.users.default_role'));

        if ($user->save()){
         return $this->getResponse($user);
        }else{
            return response()->json([
                'message' => 'Some error occurred,Please try again',
                'status_code' => 500
            ],500);
        }
    }

    public function login(Request $request){
        Log::info('login');
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status_code' => 422
            ],422);
        }

        $credentials=\request(['email','password']);
        if (Auth::attempt($credentials)){
            return $this->getResponse($request->user());
        }else{
            return response()->json([
                'message' => 'email or password doesnot match',
                'status_code' => 500
            ],500);
        }
    }

    public function logout(Request $request){
        $request->user()->tokens()->revoke();
        return response()->json([
            'message' => 'Login Successfully',
            'status_code' => 200
        ],200);
    }

    private function getResponse(User $user){
        Log::info('auth');
        $tokenResult = $user->createToken('authToken');
        $token=$tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
//        $user->with('roles')->get();
        Log::info('role'.$user->getRoleNames());
        return response()->json([
            'user'=>$user,
            'role'=>$user->getRoleNames(),
            'access_token'=>$tokenResult->accessToken,
            'token_type'=> 'Bearer',
            'expires_at'=>Carbon::parse($token->expires_at)->toDateTimeString(),
            'status_code' => 200
        ],200);
    }
}
