<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Company\CompanyGetAllRequest;
use App\Http\Requests\Company\CompanyGetByIdRequest;
use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPatchRequest;
use App\Http\Requests\Company\CompanyDeleteRequest;

use App\Models\Company;
use App\Http\Resources\Company\CompanyResource;

use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Company\CompanyGetAllRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(CompanyGetAllRequest $request)
    {
        $companies = Cache::get('companies', function(){
            return Cache::remember("companies", 2629800, function () {
                return Company::get();
            });
        });
        
        return response()->json([
            'companies' => CompanyResource::collection($companies)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Company\CompanyPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyPostRequest $request)
    {
        $company = new Company;
        $company->fill($request->validated());
        $company->save();

        Cache::forget("companies");
        $companies = Cache::get('companies', function(){
            return Cache::remember("companies", 2629800, function () {
                return Company::get();
            });
        });

        return response()->json([
            "success" => true,
            "company" => new CompanyResource($company)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Company\CompanyGetByIdRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyGetByIdRequest $request)
    {
        $company = new CompanyResource(Company::where('uuid', $request->uuid)->get()->first());

        return response()->json([
            'success' => true,
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Company\CompanyPatchRequest $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyPatchRequest $request, $uuid)
    {
        $updates = $request->validated();
        $fillableFields = app(Company::class)->getFillable();

        $company = Company::firstWhere('uuid', $uuid);
        collect($updates)->each(function ($update, $key) use($company, $fillableFields){
            if(in_array($key, $fillableFields)){
                $company->$key = $update;
            }
        });
        $company->save();
        $company = $company->refresh();
        
        return response()->json([
            'success' => true,
            'company' => new CompanyResource($company)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Company\CompanyDeleteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyDeleteRequest  $request)
    {
        $success = Company::where('uuid', $request->uuid)->delete();
        Cache::forget("companies");
        return response()->json([
            'success' => $success
        ]);
    }
}
