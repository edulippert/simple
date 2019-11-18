<?php

namespace App\Http\Controllers;

use App\MaintenanceProgram;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function buildDashboard(Request $request)
    {

        $month = null;
        $year = null;


        if ($request->month) {
            $month = $request->month;
        }else{
            $month = $request->month;
        }

        if ($request->year) {
            $year= $request->year;
        }else{
            $year= $request->year;
        }

        return [
            'cards' => $this->buildCardsResponse($request->condominium_id,month,year)
        ];

    }

    private function buildCardsResponse($condominium_id,$month=null,$year=null)
    {
        $response = [];
        
        return [
            'maintenance_progress' => 'asd',
        ];

    }
}
