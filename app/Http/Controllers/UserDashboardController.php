<?php

namespace App\Http\Controllers;

use App\MaintenanceProgram;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function buildDashboard(Request $request)
    {

        $month = null;
        $year = null;

        $now = Carbon::now();

        if ($request->month) {
            $month = $request->month;
        }else{
            $month = $now->month;
        }

        if ($request->year) {
            $year= $request->year;
        }else{
            $year= $now->year;
        }

        return [
            'cards' => $this->buildCardsResponse($request->condominium_id,$month,$year)
        ];

    }

    private function buildCardsResponse($condominium_id,$month=null,$year=null)
    {
        return MaintenanceProgram::get_maintenance_info_by_month($condominium_id,$month,$year);
    }
}
