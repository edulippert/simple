<?php

namespace App\Http\Controllers;

use App\LicenseOption;
use Illuminate\Http\Request;

class LicenseOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LicenseOption::all();
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
            'name' => 'required'
        ]);

        $license_option = LicenseOption::create($attributes);

        return $license_option;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LicenseOption  $licenseOption
     * @return \Illuminate\Http\Response
     */
    public function show(LicenseOption $licenseOption)
    {
        return $licenseOption;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LicenseOption  $licenseOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicenseOption $licenseOption)
    {
        $attributes = request()->validate([
            'name' => 'required'
        ]);

        $licenseOption->update($attributes);

        return $licenseOption;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LicenseOption  $licenseOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(LicenseOption $licenseOption)
    {
        $licenseOption->delete();
    }
}
