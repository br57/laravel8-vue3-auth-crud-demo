<?php

namespace App\Http\Controllers\Api\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Modules\User\GetAllRequest;
use App\Http\Requests\Modules\User\GetByIdRequest;
use App\Http\Requests\Modules\User\PostRequest;
use App\Http\Requests\Modules\User\PatchRequest;
use App\Http\Requests\Modules\User\DeleteRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User as modelClass;
use App\Http\Resources\Modules\UserResource as modelResource;


class UserController extends Controller
{
    public function index(GetAllRequest $request)
    {
        $users = getCacheData('user');
        return response()->json([
            'users' => modelResource::collection($users)
        ]);
    }

    public function store(PostRequest $request)
    {
        $user = new modelClass;
        $user->fill($request->validated());
        $user->password = Hash::make(Str::uuid()->toString());
        $user->save();
        
        return response()->json([
            "success" => true,
            "user" => new modelResource($user)
        ]);
    }

    public function show(GetByIdRequest $request)
    {
        $user = new modelResource(modelClass::firstWhere('uuid', $request->uuid));
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function update(PatchRequest $request, $uuid)
    {
        $user = modelClass::firstWhere('uuid', $request->uuid);
        $user->fill($request->validated());
        if($request->has('status_uuid')){
            $user->status_id = getIdByUuid($request->status_uuid, 'status');
        }
        $user->save();
        $user = $user->refresh();

        return response()->json([
            'success' => true,
            'user' => new modelResource($user)
        ]);
    }

    public function destroy(DeleteRequest  $request)
    {
        $success = modelClass::where('uuid', $request->uuid)->delete();
        
        return response()->json([
            'success' => $success
        ]);
    }
}
