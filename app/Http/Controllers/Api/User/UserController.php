<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\User\UserGetAllRequest;
use App\Http\Requests\User\UserGetByIdRequest;
use App\Http\Requests\User\UserPostRequest;
use App\Http\Requests\User\UserPatchRequest;
use App\Http\Requests\User\UserDeleteRequest;

use App\Models\User;
use App\Http\Resources\User\UserResource;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\User\UserGetAllRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(UserGetAllRequest $request)
    {
        $users = Cache::get('users', function(){
            return Cache::remember("users", 2629800, function () {
                return User::all();
            });
        });

        return response()->json([
            'users' => UserResource::collection($users)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\UserPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $request)
    {
        $user = new User;
        $user->fill($request->validated());
        $user->password = Hash::make(Str::uuid()->toString());
        $user->save();
        Cache::forget("users");
        return response()->json([
            "success" => true,
            "user" => new UserResource($user)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\User\UserGetByIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function show(UserGetByIdRequest $request)
    {
        $user = new UserResource(User::where('uuid', $request->uuid)->get()->first());

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UserPatchRequest $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UserPatchRequest $request, $uuid)
    {
        $update = $request->validated();
        unset($update['uuid']);
        unset($update['_method']);
        User::where('uuid', $uuid)->update($update);
        Cache::forget("users");
        return response()->json([
            'success' => true,
            'user' => new UserResource(User::where('uuid', $uuid)->get()->first())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\User\UserDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest  $request)
    {
        $success = User::where('uuid', $request->uuid)->delete();
        Cache::forget("users");
        return response()->json([
            'success' => $success
        ]);
    }
}
