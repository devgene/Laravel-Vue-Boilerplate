<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('id','DESC')->paginate(10);

        return response()->json( $users,200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|string|max:255|min:6',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->first(),
                'status_code' => 422
            ],422);
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
            ]);
        $user->assignRole($request->input('role'));
        return response()->json( $user,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        Log::info('delete');
//        $user=User::query()->find($id);
        if($user->delete()){
            return response()->json([
                'message' => 'User delete successfully',
                'status_code' => 200
            ],200);
        }else{
            return response()->json([
                'message' => 'Some error occurred,Please try again',
                'status_code' => 500
            ],500);
        }
    }
}
