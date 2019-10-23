<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::with('items')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $attributes = request()->validate([
            'description' => 'required',
            'is_guarantee' => '',
            'is_maintenance' => '', 
        ]);

        $group = Group::create($attributes);

        return $group;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $group;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $attributes = request()->validate([
            'description' => 'required'
        ]);

        $group->update($attributes);

        return $group;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
    }

    public function getGroupsbyType(Request $request){

        
        if ($request->type === 'Guarantee'){

            $groups = Group::where('is_guarantee',true)->get();
        }else {
            $groups = Group::where('is_maintenance',true)->getI();
        }

        return $groups;
    }

    
}
