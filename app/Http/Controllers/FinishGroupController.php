<?php

namespace App\Http\Controllers;

use App\FinishGroup;
use App\Http\Requests\FinishGroupRequest;
use Illuminate\Http\Request;

class FinishGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $company_id = $this->getCompanyId();

        if ($company_id) {
            
            return FinishGroup::whereCompanyId($company_id)->get();
       
        }else{
            
            return FinishGroup::all();

        }
        
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
     * @return \Illuminate\Http\Response
     */
    public function store(FinishGroupRequest $request)
    {
        $finish_groups = FinishGroup::create($request->all());
        return $finish_groups;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FinishGroup  $finishGroup
     * @return \Illuminate\Http\Response
     */
    public function show(FinishGroup $finishgroup)
    {
        return $finishgroup;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FinishGroup  $finishGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(FinishGroup $finishGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FinishGroup  $finishGroup
     * @return \Illuminate\Http\Response
     */
    public function update(FinishGroupRequest $request, FinishGroup $finishgroup)
    {
        $finishgroup->fill($request->all());
        $finishgroup->save();
        return $finishgroup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FinishGroup  $finishGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinishGroup $finishgroup)
    {
        $finishgroup->delete();
        return response()->json([],204);
    }

    private function getCompanyId()
    {
        $user = \Auth::guard('api')->user();
        $company=$user->user_companies->first();

        return $company->company_id;
    }

    public function getFinishGroups(Request $request)
    {
        return FinishGroup::whereCompanyId($request->company_id)->get();
    }
}
