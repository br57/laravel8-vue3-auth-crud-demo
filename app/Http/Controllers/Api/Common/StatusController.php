<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;

use App\Http\Requests\Common\Status\GetAllRequest;
use App\Http\Requests\Common\Status\GetByIdRequest;
use App\Http\Requests\Common\Status\PostRequest;
use App\Http\Requests\Common\Status\PatchRequest;
use App\Http\Requests\Common\Status\DeleteRequest;

use App\Models\Status as modelClass;
use App\Http\Resources\Common\StatusResource as modelResource;

class StatusController extends Controller
{
    public function index(GetAllRequest $request)
    {
        $statuses  =   getCacheData('status');
        return response()->json([
            'statuses' => modelResource::collection($statuses)
        ]);
    }

    public function store(PostRequest $request)
    {
        $status = new modelClass;
        $status->fill($request->validated());
        $status->slug = makeSlug($status->label, 'status');
        if($request->has('user_uuid')){
            $status->user_id = getIdByUuid($request->user_uuid, 'user');
        }
        $status->save();

        return response()->json([
            "success" => true,
            "status" => new modelResource($status)
        ]);
    }

    public function show(GetByIdRequest $request)
    {
        $status = new modelResource(modelClass::firstWhere('uuid', $request->uuid));

        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }

    public function update(PatchRequest $request, $uuid)
    {
        $status = modelClass::firstWhere('uuid', $uuid);
        $status->fill($request->validated());
        $status->slug = makeSlug($status->label, 'status', $uuid);
        if($request->has('user_uuid')){
            $status->user_id = getIdByUuid($request->user_uuid, 'user');
        }
        $status->save();
        $status = $status->refresh();
        
        return response()->json([
            'success' => true,
            'status' => new modelResource($status)
        ]);
    }

    public function destroy(DeleteRequest $request)
    {
        $success = modelClass::where('uuid', $request->uuid)->delete();
        return response()->json([
            'success' => $success
        ]);
    }
}
